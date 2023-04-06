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
// $response = $Response::set(["code" => "unauthorized", "message" => "Unauthorized"]);

if (empty(arrray($post))) {
  $post = json_decode(file_get_contents('php://input'));
  if (empty($post)) $post = $newObject;
}

// Authenticate all incoming requests
$proceed = false;
$excludeAuthentication = ["send-message"];
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
    case 'send-message':
      $messenger = new Messenger($generic);
      $required = ["full_name", "email", "phone"];
      if (isRequired(array_extract($post, $required))) {
        $company    = $generic->company();
        $mail       = (object)[
          'subject'    =>  "Contact company",
          'body'      =>  "My name is {$post->full_name} and Phone number is {$post->phone}. I want to waybill a package of {$post->weight} kg using {$post->cargo_type} and delivered to {$post->delivery_type}",
          'from'      =>  $company->email,
          'to'        =>  $company->email,
          'from_name'  =>  $company->name,
          'to_name'    =>  $post->full_name,
          "template"  =>  "notify",
        ];

        $data    = $messenger->sendMail($mail);
        $response = $Response::set(["data" => $data], !empty($data->status));
      } else $response = $Response::set(["message" => "Some parameters are required", "code" => "bad_request"]);
      break;
    default:
      $response = $Response::set(["message" => "Invalid Request endpoint", "code" => "bad_request"]);
      break;
  }
}

if (isset($sessionFile)) _writeFile($sessionFile, $session);

// http_response_code($response->code);
