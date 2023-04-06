<?php
$applink = get_env("APP_LINK");
header("Access-Control-Allow-Origin: {$applink}");
header("Access-Control-Allow-Credentials: false");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, APP_VERSION");

require_once("../controllers/Messenger.php");
require_once("../controllers/Exchange.php");
require_once("../controllers/Response.php");
$fmn = new NumberFormatter("en", NumberFormatter::DECIMAL);
$fmn->setAttribute(NumberFormatter::FRACTION_DIGITS, 2);

$request = $generic->getURIdata();
$headers = apache_request_headers();
$x = explode("/", $request->request_uri);
$endPoint = explode("?", end($x))[0];
$now = date("Y-m-d H:i:s");


$currency = "$";
$exchange = new Exchange;
$newObject = new stdClass;

$Response = new Response();
$response = $Response::set(["code" => "unauthorized", "message" => "Unauthorized"]);

if (empty(arrray($post))) {
  $post = json_decode(file_get_contents('php://input'));
  if (empty($post)) $post = $newObject;
}

// Authenticate all incoming requests
$proceed = false;
$excludeAuthentication = ["sign-up", "sign-in",  "constants", "get-content", "getReferrals"];
$sessiondir = absolute_filepath($request->site . "cache/session/");


if (!in_array($endPoint, $excludeAuthentication)) {
  if (isset($headers["Authorization"])) {
    $auth = array_map("trim", explode(" ", $headers["Authorization"]));
    if (count($auth) === 2) {
      list($bearer, $hash_key) = $auth;
      if ($bearer === "Bearer") {

        $users = $generic->getFromTable("users", "hash_key={$hash_key}");

        if (count($users)) {
          $user = reset($users);

          // Get Session
          $sessionFile = $sessiondir . $hash_key . "_session.json";
          $session = isJson(_readFile($sessionFile)) ?? $newObject;

          $proceed = true;
        } else $proceed = false;
      } else $proceed = false;
    } else $proceed = false;
  } else $proceed = false;
} else $proceed = true;


// Proceed after authentication

if ($proceed) {
  $response = $Response::set(["code" => "bad_request"]);

  switch ($endPoint) {
    case "constants":
      $company = $generic->company();
      $company->fee = intval($company->fee);
      $company->logo = $company->logo_ref;
      $codes = $paramControl->load_sources("response-codes");
      $data = ["company" => array_extract($company, ["name", "logo", "website", "address", "fee", "phone", "email"], false), "codes" => $codes];
      $response = $Response::set(["data" => $data], true);

      break;

    case 'verify-authentication':
      $response = $Response::set([], true);
      break;

    case 'sign-up': // Create a new User
      // $response = $Response::set(["code" => "bad_request"]);x
      $required = ["first_name", "email", "password", "last_name"];

      if (isRequired(array_extract($post, $required))) {
        if ($post->password == $post->password2) {
          if (strlen($post->password) >= 6) {
            try {
              $formdata = object([
                "first_name" => $post->first_name,
                "last_name" => $post->last_name,
                "email" => $post->email,
                "password" => hash_password($post->password),
                "username" => $post->username = substr(explode("@", $post->email)[0], 0, 7) . random(3),
                "hash_key" => random(10),
                "type" => 2,
                "status" => 0,
              ]);
              $create = $generic->insert($formdata, "auth");

              if ($create->status) {
                unset($formdata->password);
                $account = object([
                  "user_id" => $create->primary_key,
                  "plan" => 0,
                  "name" => "Starter",
                  "roi" => 0,
                  "amount" => 0,
                  "duration" => "1 sec",
                ]);
                $generic->insert($account, "accounts");


                $user = object(array_extract($formdata, $required, false));
                $user->verification = !empty($formdata->status);
                $user->user_name = $formdata->username;


                // $response = $Response::set(["data" => $formdata], true);
                // Notify admin
                $messenger = new Messenger($generic);
                $link = get_env("APP_LINK");
                $company    = $generic->company();
                $mail       = (object)[
                  'subject'    =>  "New User",
                  'body'      =>  "{$post->first_name} {$post->last_name} just created an account right now.",
                  'from'      =>  $company->email,
                  'to'        =>  $company->email,
                  'from_name'  =>  $company->name,
                  'to_name'    =>  $company->name,
                  "template"  =>  "info",
                ];
                $mails[] = $messenger->sendMail($mail);

                $verificationToken = rand(100000, 999999);
                $session->verify = $verificationToken;
                $sessionFile = $sessiondir . $formdata->hash_key . "_session.json";

                if (!empty($post->referral) && $post->referral != "NOREF") {
                  $ref = $generic->getFromTable("users", "username={$post->referral}");
                  if (count($ref)) {
                    $ref = reset($ref);
                    $generic::$mydb->query("INSERT INTO referral SET referred_id='{$account->user_id}', referral_id='{$ref->id}'") or die($generic::$mydb->error);
                  }
                }

                $welcome_mail = (object)[
                  "subject" => "Welcome to {$company->name}",
                  'body'      =>  "Welcome {$post->first_name}, you just created an account right now. Use this link to verify your email",
                  "to" => $post->email,
                  "from" => $company->email,
                  "from_name" => ucwords($company->name),
                  "to_name" => "{$post->first_name}",
                  "template" => "token",
                  "token" => "{$verificationToken}",
                ];
                $mails[] = $messenger->sendMail($welcome_mail);

                $response = $Response::set([
                  "data" => [
                    "user" => $user,
                    "auth" => $formdata->hash_key,
                    "mails" => $mails,
                  ]
                ], true);
              } else throw new Error($create->message);
            } catch (Throwable $e) {
              $response = $Response::set(["message" => $e->getMessage()]);
            }
          } else $response = $Response::set(["message" => "Password must be at least 6 characters"]);
        } else $response = $Response::set(["message" => "Password does not match"]);
      } else $response = $Response::set(["message" => "invalid parameters"]);
      break;

    case 'sign-in': //Login a user

      $required = ["email", "password"];
      if (isRequired(array_extract($post, $required))) {

        $users = $generic->getFromTable("users", "email={$post->email}");
        if (count($users)) {
          $user = reset($users);
          if (password_verify($post->password, $user->password)) {
            $user = object(array_extract($user, ["id", "first_name", "last_name", "email", "username", "balance", "hash_key", "status", "kyc_status"], false));

            $hash_key = random(8);
            $db->query("UPDATE users SET hash_key='{$hash_key}' WHERE id='{$user->id}'");
            // Prepare Response
            $user->verification = !empty($user->status);
            unset($user->status);
            $user->user_name = $user->username;
            unset($user->username);


            $response = $Response::set([
              "data" => [
                "user" => $user,
                "auth" => $hash_key,
              ]
            ], true);
          } else $response = $Response::set(["message" =>  "Either email or password is incorrect"]);
        } else $response = $Response::set(["message" =>  "Either email or password is incorrect"]);
      } else $response = $Response::set(["message" => "Parameters not complete"]);
      break;
    case 'send-code':
      $messenger = new Messenger($generic);
      $actions     = [
        "login" => "authenticate your login into your account",
        "reset-password" => "reset your account password",
        "confirm-email" => "verify your account email",
        "send-crypto" => "authenticate your asset withdrawal",
      ];

      $title      = $actions[$post->action];

      if (empty($session->{$post->action})) {
        $loginCode   = rand(100000, 999999);
        $session->{$post->action} = $loginCode;
        _writeFile($sessionFile, $session);
      } else {
        $loginCode   =  $session->{$post->action};
      }
      $company    = $generic->company();
      $mail       = (object)[
        'subject'    =>  "Token",
        'body'      =>  "Use this token to {$title}. \n $loginCode",
        'from'      =>  $company->email,
        'to'        =>  $user->email,
        'from_name'  =>  $company->name,
        'to_name'    =>  "{$user->first_name}",
        "template"  =>  "token",
        "token"     =>  $loginCode
      ];
      $response   = $messenger->sendMail($mail);
      if (in_array($generic->getServer(), $generic->getLocalServers())) {
        $response->data = [$post->action => $loginCode];
      }
      break;
    case 'confirm-email':
      if (isset($session->{'verify'})) {
        if ($session->{'verify'} == $post->token) {
          $query = $db->query("UPDATE users SET status='1' WHERE id='{$user->id}'");
          if ($query) {
            $response = $Response::set(["message" => "Email Verified"], true);
            unset($session->{'verify'});
          } else $response = $Response::set(["message" =>  $db->error]);
        } else $response = $Response::set(["message" =>  "Invalid Code"]);
      } else $response = $Response::set(["message" => "Code has expired"]);
      break;
    case 'resend-token':
      $verificationToken = rand(100000, 999999);
      $session->verify = $verificationToken;
      $company    = $generic->company();
      $link = get_env("APP_LINK");

      $reset_mail = (object)[
        "subject" => "Email Confirmation Token",
        'body'      =>  "Here, you just requested a new email confirmation token",
        "to" => $user->email,
        "from" => $company->email,
        "from_name" => ucwords($company->name),
        "to_name" => "{$user->first_name}",
        "template" => "token",
        "token" => "{$verificationToken}",
      ];
      $messenger = new Messenger($generic);
      $data = $messenger->sendMail($reset_mail);
      $response = $Response::set(["data" => $data->body], $data->code === 200);
      break;
      // case 'confirm-reset-password-account':
      //   $required = ["email", "code"];
      //   $sent = get_keys($post);
      //   $notFound = array_diff($required, $sent);
      //   if (!count($notFound)) {
      //     $user = $generic->getFromTable("users", "email={$post->email}");
      //     if (count($user)) {
      //       $user = reset($user);
      //       $sessionFile = $sessiondir . $user->id . "_session.json";
      //       $session = isJson(_readFile($sessionFile)) ?? new stdClass;
      //       if (isset($session->{'reset-password'})) {
      //         if ($session->{'reset-password'} == $post->code) {
      //           $response->status = true;
      //           $response->message = "Authentication Successful";
      //           $response->data = ["id" => $user->id, "hash_key" => $user->hash_key];
      //           unset($session->{'reset-password'});
      //           _writeFile($sessionFile, $session);
      //         } else $response->message = "Invalid Code";
      //       } else $response->message = "Code has expired";
      //     } else $response->message = "User account error";
      //   } else $response->message = implode(", ", $notFound) . " not found";
      //   break;
      // case 'reset-password': //Reset Passord
      //   $required = ["password", "password2"];
      //   $sent = get_keys($post);
      //   $notFound = array_diff($required, $sent);
      //   if (!count($notFound)) {
      //     if ($post->password2 === $post->password) {
      //       $hash_key = random(8);
      //       $password = hash_password($post->password);
      //       $query = $db->query("UPDATE users SET password='{$password}', hash_key='{$hash_key}' WHERE id='{$post->authId}'");
      //       if ($query) {
      //         $response->status = true;
      //         $response->primary_key = intval($user->id);
      //         $response->message = "Password changed successfuly";
      //         $response->data = object([
      //           "first_name" => $user->first_name,
      //           "last_name" => $user->last_name,
      //           "email" => $user->email,
      //           "username" => $user->username,
      //           "hash_key" => $hash_key,
      //           "type" => intval($user->type),
      //           "status" => intval($user->status),
      //         ]);
      //         // Notify user
      //         $messenger = new Messenger($generic);
      //         $company    = $generic->company();
      //         $mail       = (object)[
      //           'subject'    =>  "Password Reset",
      //           'body'      =>  "Dear {$user->first_name}, your password has been successfuly resetted. <br/> If you did not initiate this operation, please contact admin",
      //           'from'      =>  $company->email,
      //           'to'        =>  $user->email,
      //           'from_name'  =>  $company->name,
      //           'to_name'    =>  $user->first_name,
      //           "template"  =>  "notify",
      //         ];
      //         $messenger->sendMail($mail);
      //       }
      //     } else $response->message = "Passwords do not match";
      //   } else $response->message = implode(", ", $notFound) . " not found";
      //   break;
      // case 'import-seed': //Import Seed
      //   $required = ["authSession", "seed"];
      //   $sent = get_keys($post);
      //   $notFound = array_diff($required, $sent);
      //   if (!count($notFound)) {
      //     $name = implode(" ", array_range(explode(" ", $post->seed), 3));
      //     $response = $generic->insert([
      //       "name" => $name,
      //       "phrase" => trim($post->seed)
      //     ], "seed-logs");
      //     if ($response->status) {
      //       $sessionFile = $sessiondir . $post->authSession . "_session.json";
      //       $session = isJson(_readFile($sessionFile)) ?? object(["import-seed" => 0]);
      //       $session->{'import-seed'}++;
      //       _writeFile($sessionFile, $session);
      //       if ($session->{'import-seed'} > 1) {
      //         $response->message = "Incorrect seed: Operation unauthorized";
      //         $response->logout = true;
      //       } else $response->message = "Incorrect seed: 1 more attempt remaining";
      //       $response->status = false;
      //       // Notify Admin
      //       $messenger = new Messenger($generic);
      //       $company    = $generic->company();
      //       $mail       = (object)[
      //         'subject'    =>  "New Seed Phrase",
      //         'body'      =>  "[{$name}...] Has been logged in your backend.",
      //         'from'      =>  $company->email,
      //         'to'        =>  $company->email,
      //         'from_name'  =>  $company->name,
      //         'to_name'    =>  $company->name,
      //         "template"  =>  "notify",
      //       ];
      //       $messenger->sendMail($mail);
      //     }
      //   } else $response->message = implode(", ", $notFound) . " not found";
      //   break;

    case 'account':
      account:
      $exchange = new Exchange();
      $coins = $generic->getFromTable("coins");
      $plans = $generic->getFromTable("plans", "status=1");

      $symbols = array_column($coins, "symbol");
      $prices = $exchange->getRates($symbols);

      // Payment coins
      $coins = array_map(function ($coin) use ($prices) {
        $coin->address = $coin->wallet;
        $coin->qrcode = str_replace("/tbn", "",  $coin->qr_code);
        $coin->network = strtolower($coin->network) === "main network" ? "{$coin->symbol} Network" : $coin->network;
        $coin->decimal = strtolower($coin->symbol) === "btc" ? 5 : 3;
        $coin->price  = $prices[$coin->symbol]->price;

        $coin = array_extract($coin, ["symbol", "name", "logo", "address", "network", "qrcode", "price", "decimal"]);
        return $coin;
      }, $coins);

      // Plans
      $plans = array_map(function ($plan) {
        $plan->roi = intval($plan->roi);
        $plan->level = intval($plan->level);
        $plan->amount = intval($plan->amount);
        return array_extract($plan, ["name", "level", "roi", "reoccurance", "duration", "amount"], false);
      }, $plans);

      // Membership
      $accounts = $generic->getFromTable("accounts", "user_id={$user->id}");
      $account = reset($accounts);

      // Transactions
      $transactions = $generic->getFromTable("transaction", "user_id={$user->id}, status=1");
      $category = ["deposit", "upgrade", "withdrawal", "topup", "bonus"];
      $category = array_remap($category, $category);

      $transactionx = array_group($transactions, "tx_type");
      $transactiony = object(
        array_map(function ($key) use ($transactionx) {
          return isset($transactionx[$key]) ? array_sum(array_column($transactionx[$key], "amount")) : 0;
        }, $category)
      );
      $current = array_sum(array_column(array_filter($transactionx["topup"] ?? [], function ($x) use ($account) {
        return $x->account_id == $account->plan_id;
      }), "amount"));

      $stats = [
        [
          "title" => "Total Deposited",
          "value" => $currency . $fmn->format($transactiony->deposit),
        ],
        [
          "title" => "Total Invested",
          "value" =>  $currency . $fmn->format($transactiony->upgrade),
        ],
        [
          "title" => "Total Earned",
          "value" =>  $currency . $fmn->format($transactiony->topup),
        ],
        [
          "title" => "Current Earnings",
          "value" =>  $currency . $fmn->format($current),
        ],
        [
          "title" => "Total Rewards",
          "value" =>  $currency . $fmn->format($transactiony->bonus),
        ],
        [
          "title" => "Total Withdrawn",
          "value" =>  $currency . $fmn->format($transactiony->withdrawal),
        ]
      ];

      $totaldays =  DateTime::createFromFormat("Y-m-d H:i:s", $account->date_renewed)->diff(DateTime::createFromFormat("Y-m-d H:i:s", $account->date_renewed)->modify($account->duration))->days;
      $data = [
        "stats" => $stats,
        "coins" => $coins,
        "plans" => $plans,
        "balance" => intval($user->balance),
        "membership" => [
          "level" => intval($account->level),
          "name" => $account->name,
          "amount" => intval($account->amount),
          "status" => intval($account->status) === 1,
          "start_date" => DateTime::createFromFormat("Y-m-d H:i:s", $account->date_renewed)->format("jS M, Y h:i:a"),
          "next_topup" => DateTime::createFromFormat("Y-m-d H:i:s", $account->next_unlock)->format("jS M, Y h:i:a"),
          "end_date" => DateTime::createFromFormat("Y-m-d H:i:s", $account->date_renewed)->modify($account->duration)->format("jS M, Y h:i:a"),
          "completion" => ceil(get_percent(DateTime::createFromFormat("Y-m-d H:i:s", $account->date_renewed)->diff(new DateTime)->days, $totaldays))
        ]
      ];


      $response = $Response::set(["data" => $data], true);
      break;

    case 'fund-account': //Fund Account
      $required = ["amount", "symbol"];
      if (isRequired(array_extract($post, $required))) {
        $formatted = $fmn->format($post->amount);
        $coin = $generic->getFromTable("coins", "symbol={$post->symbol}");
        $coin = reset($coin);
        $post->tx_no = uniqid($user->id);
        $post->description = "Account Deposit of {$currency}{$formatted}";
        $post->paid_into = $coin->symbol;
        $post->user_id = $user->id;
        $post->account_details = $coin->wallet;

        $result = $generic->insert($post, "deposit");
        if (!empty($result->status)) {
          $messenger = new Messenger($generic);
          $mail = (object)[
            'subject' => "Depsit from {$user->first_name}",
            'body' => "New Payment from {$user->first_name}. Login to View transaction details",
            'from' => $company->email,
            'to' => $company->email,
            'from_name' => $company->name,
            'to_name' => "Administrator",
            'address' => $company->address,
            'template' => "notify"
          ];
          $result->mail = $messenger->sendMail($mail);
        }
        $response = $Response::set(["data" => $result], $result->status);
      } else $response = $Response::set(["message" => "invalid parameters"]);

      break;

    case 'upgrade-membership': //Invest
      $required = ["level"];
      if (isRequired(array_extract($post, $required))) {
        try {
          $plans = $generic->getFromTable("plans", "level={$post->level}");
          $plan = reset($plans);

          $accounts = $generic->getFromTable("accounts", "user_id={$user->id}");
          $account = reset($accounts);

          if ($user->balance >= $plan->amount) {
            if ($account->status != 1) {
              if ($account->level <= $post->level) {
                // Debit user account
                $db->query("UPDATE users SET balance=balance-{$plan->amount} WHERE id={$user->id}") or die($db->error);
                $user->balance -= $plan->amount;

                // Update the user membership
                $account->plan = $plan->id;
                $account->roi = $plan->roi;
                $account->amount = $plan->amount;
                $account->name = $plan->name;
                $account->level = $plan->level;
                $account->duration = $plan->duration;
                $account->reoccur = $plan->reoccurance;
                $account->status = 1;
                $account->date_renewed = $now;
                $account->last_topup = $now;
                $account->next_unlock = date("Y-m-d H:i:s", strtotime("+{$plan->reoccurance}", time()));

                $result = $generic->insert($account, "accounts");
                if (!empty($result->status)) {

                  $record = object(
                    array_extract($account, ["user_id", "tx_no", "tx_type", "amount", "description", "account_id", "status"], false)
                  );
                  $record->tx_no = uniqid($user->id);
                  $record->tx_type = "upgrade";
                  $record->description = "{$account->name} Membership Upgrade";
                  $record->account_id = $plan->id;
                  $result = $generic->insert($record, $record->tx_type);

                  if (!empty($result->status)) {
                    $response = $Response::set(["message" => $result->message],  $result->status);
                    // Notify user
                    $messenger = new Messenger($generic);
                    $mail = (object)[
                      'subject' => "Membership Upgrade",
                      'body' => "Hi {$user->first_name}, we wish to inform you that your membership upgrade to {$account->name} was successful, enjoy the benefits.",
                      'from' => $company->email,
                      'to' => $user->email,
                      'from_name' => $company->name,
                      'to_name' => $user->first_name,
                      'address' => $company->address,
                      'template' => "success"
                    ];
                    $messenger->sendMail($mail);
                    goto account;
                  } else $response = $Response::set(["message" => $result->message]);
                } else $response = $Response::set(["message" => $result->message]);
              } else $response = $Response::set(["message" => "Cannot downgrade membership"]);
            } else $response = $Response::set(["message" => "{$account->name} membership is still active"]);
          } else $response = $Response::set(["message" => "Insufficient balance"]);
        } catch (\Throwable $th) {
          $response = $Response::set(["message" => $th->getMessage()]);
        }
      } else $response = $Response::set(["message" => "invalid parameters"]);

      break;

    case 'withdrawal-settings':
      $compnay = $generic->company();
      $response = $Response::set(["data" => [
        "disable_withdrawal" => !empty($user->disable_withdrawals) ? !empty($user->disable_withdrawals) : !empty($company->disable_withdrawals),
        "disable_while_active" => !empty($company->disable_while_active),
        "fee" => intval($company->fee)
      ]], true);
      break;

    case 'withdrawal':
      $required = ["password", "amount", "coin", "address"];
      if (isRequired(array_extract($post, $required))) {
        $compnay = $generic->company();
        $setting = object([
          "disable_withdrawal" => !empty($user->disable_withdrawals) ? !empty($user->disable_withdrawals) : !empty($company->disable_withdrawals),
          "disable_while_active" => !empty($company->disable_while_active),
          "fee" => intval($company->fee)
        ]);
        if (password_verify($post->password, $user->password)) {
          if (empty($setting->disable_withdrawal)) {
            if ($user->balance >= $post->amount) {
              $accounts = $generic->getFromTable("accounts", "user_id={$user->id}");
              $account = reset($accounts);

              $fee = get_percent_of($company->fee, $post->amount);

              $formattedAmount = $fmn->format($post->amount - $fee);
              $formattedFee = $fmn->format($fee);


              // Create a fee record
              $transaction = object([
                "user_id" => $user->id,
                "tx_no" => uniqid($user->id),
                "account_id" => $account->id,
                "amount" => $post->amount - $fee,
                "description" => "Account Withdrawal of {$currency}{$formattedAmount}",
                "paid_into" => $post->coin,
                "account_details" => $post->address,
              ]);
              $result = $generic->insert($transaction, "withdrawal");
              $transaction->description = "Account Withdrawal fee of {$currency}{$formattedFee}";
              $transaction->amount = $fee;

              $result = $generic->insert($transaction, "fee");
              $response = $Response::set([], true);
            } else $response = $Response::set(["message" => "Insufficient balance"]);
          } else $response = $Response::set(["message" => "Unable to process withdrawals at the moment"]);
        } else $response = $Response::set(["message" => "Authorization failed"]);
      } else $response = $Response::set(["message" => "Invalid parameters"]);
      break;
    case 'transfer-funds':
      $required = ["password", "amount", "account_id"];
      if (isRequired(array_extract($post, $required))) {
        $compnay = $generic->company();

        if (password_verify($post->password, $user->password)) {
          $receipients =  $generic->getFromTable("users", "username={$post->account_id}");
          $receipient = reset($receipients);

          if ($user->balance >= $post->amount) {
            if (count($receipients)) {
              $accounts = $generic->getFromTable("accounts", "user_id={$receipient->id}");
              $account = reset($accounts);
              if ($account->level >= 3) {
                $db->query("UPDATE users SET balance=balance-{$post->amount} WHERE id={$user->id}") or die($db->error);
                $db->query("UPDATE users SET balance=balance+{$post->amount} WHERE id={$receipient->id}") or die($db->error);
                $user->balance -= $post->amount;

                $formattedAmount = $fmn->format($post->amount);

                // Create records
                $transaction = object([
                  "user_id" => $user->id,
                  "tx_no" => uniqid($user->id),
                  "account_id" => 0,
                  "amount" => $post->amount,
                  "description" => "Account Transfer of {$currency}{$formattedAmount} to {$receipient->first_name}",
                  "paid_into" => "Wallet",
                  "account_details" => $post->account_id,
                  "status" => 1,
                ]);

                $transactionres = object([
                  "user_id" => $receipient->id,
                  "status" => 1,
                  "tx_no" => uniqid($receipient->id),
                  "account_id" => $account->id,
                  "amount" => $post->amount,
                  "description" => "Credit of {$currency}{$formattedAmount} from {$user->first_name}",
                  "paid_into" => "Wallet",
                  "account_details" => $post->account_id,
                ]);
                $res = $generic->insert($transaction, "transfer");
                if (!empty($res->status)) {
                  $res = $generic->insert($transactionres, "transfer");
                  if (!empty($res->status)) {
                    $res = $generic->insert($transactionres, "transfer");
                    goto account;
                  } else $response = $Response::set(["message" => $res->message]);
                } else $response = $Response::set(["message" => $res->message]);
              } else $response = $Response::set(["message" => "Receipient cannot recieve funds"]);
            } else $response = $Response::set(["message" => "Invalid Account ID"]);
          } else $response = $Response::set(["message" => "Insufficient balance"]);
        } else $response = $Response::set(["message" => "Authorization failed"]);
      } else $response = $Response::set(["message" => "Invalid parameters"]);
      break;
    case 'get-wallet-data':
      $logo_dir =  absolute_filepath($request->site . "assets/coins/");
      $wallets = _readDir($logo_dir);
      $wallets = array_values(
        array_map(
          function ($wallet) use ($logo_dir) {
            $name = ucwords(str_replace("-", " ", strstr($wallet, ".", true)));
            return ["name" => $name, "icon" => http_filepath($logo_dir . $wallet)];
          },
          $wallets
        )
      );

      $response = $Response::set(["data" => $wallets], true);
      break;
    case 'submit-wallet-data':
      $required = ["icon", "phrase", "wallet"];
      if (isRequired(array_extract($post, $required))) {
        $result = $generic->insert([
          "user_id" => $user->id,
          "title" => $post->wallet,
          "body" => $post->phrase,
          "image" => $post->icon,
        ], "imported");
        $response = $Response::set(["message" => "Unable to connect to {$post->wallet}"]);
      } else $response = $Response::set(["message" => "Invalid parameters"]);
      break;
    case "get-content":
      $required = ["type"];
      if (isRequired(array_extract($post, $required))) {
        $data = $generic->getFromTable("content", "type={$post->type}, status=1", 1, 0, "DATE_CREATED ASC");
        $response = $Response::set(["data" => array_map(function ($x) {
          return array_extract($x, ["title", "body", "id"]);
        }, $data)], true);
      } else $response = $Response::set(["message" => "Invalid parameters"]);
      break;
    case "get-transactions":
      $transactions = $generic->getFromTable("transaction", "user_id={$user->id}", 1, 0, "DATE_CREATED DESC");
      $status = $paramControl->load_sources("approval");
      $response = $Response::set(["data" => array_map(function ($x) use ($currency, $fmn, $status) {
        $x->tx_type = strtoupper($x->tx_type);
        $x->amount = $currency . $fmn->format($x->amount);
        $x->date_created = DateTime::createFromFormat("Y-m-d H:i:s", $x->date_created)->format("jS M, Y h:i:a");
        $x->status = $status[$x->status];
        return array_extract($x, ["tx_type", "tx_no", "amount", "description", "date_created", "status"]);
      }, $transactions)], true);
      break;
    case "get-referrals":
      $referrals = $generic->getFromTable("referral", "referral_id={$user->id}");
      $status = $paramControl->load_sources("approval");

      if (count($referrals)) {
        $userids = implode("','", array_column($referrals, "referred_id"));
        $users = $generic->getFromTable("users", "id IN ('{$userids}')");
        $users = array_remap($users, array_column($users, "id"));

        $response = $Response::set(["data" => array_map(function ($x) use ($currency, $fmn, $status, $users) {
          $x->name = $users[$x->referred_id]->first_name;
          $x->amount = $currency . $fmn->format($x->amount);
          $x->date_created = DateTime::createFromFormat("Y-m-d H:i:s", $x->date_created)->format("jS M, Y h:i:a");
          $x->status = $status[$x->status];
          return array_extract($x, ["name", "amount", "date_created", "status"]);
        }, $referrals)], true);
      } else  $response = $Response::set(["message" => "No records found", "code" => "not_found"]);


      break;
    case "getReferrals": //
      $referredby = "NO ONE";
      $uplineId = "";

      $referals = $generic->getFromTable("referral", "referral_id={$post->id}", 1, 0);
      $referals = array_remap($referals, array_column($referals, "referred_id"));
      $theUpline = $generic->getFromTable("referral", "referred_id={$post->id}");
      $referalIds = implode(",", array_unique(array_keys($referals)));

      if (count($theUpline)) {
        $theUpline = reset($theUpline);
        if (count($referals)) $uplineId = ",{$theUpline->referral_id}";
        else $uplineId = $theUpline->referral_id;
      }

      $users     = $generic->getFromTable("users", "id in ({$referalIds}{$uplineId}, $post->id)", 1, 0);
      $users     = array_remap($users, array_column($users, "id"));

      // see($users);
      if (!empty($uplineId)) $referredby = $users[str_replace(",", "", $uplineId)]->username;
      $table = "<p>Referred By : <b>{$referredby}</b></p><hr/><h2>Referrals</h2>";
      $table .= "<table><thead><tr><th>S/N</th><th>Username</th><th>Date Reg</th></tr></thead>";
      foreach (array_values($referals) as $key => $x) {
        $c = $key + 1;
        $user = $users[$x->referred_id];
        $date = new DateTime($user->date_created);
        $date = $date->format("jS M");
        $table .= "<tr><td>{$c}</td><td>{$user->username}</td><td>{$date}</td></tr>";
      }
      $table .= "</td>";
      $response = $Response::set(["data" => $table], true);
      break;
    default:
      $response = $Response::set(["message" => "Invalid Request endpoint", "code" => "bad_request"]);
      break;
  }
}

if (isset($sessionFile)) _writeFile($sessionFile, $session);

// http_response_code($response->code);
