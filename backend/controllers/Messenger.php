<?php
require_once "PHPMailer.php";
require_once "Curl.php";
require_once __DIR__ . '../../vendor/autoload.php';

use Twilio\Rest\Client;
// use MailchimpTransactional\ApiClient;

class Messenger
{
  public $email;
  public $name;
  static $generic;
  public function __construct($generic)
  {
    self::$generic = $generic;
  }

  public function sendMail($post)
  {
    if (gettype($post) !== 'object') {
      $post = (object) $post;
    }

    if (isset($post->process_url)) { //Send online
      $response = curl_post($post);
    } else {
      $response = new stdClass;
      $response->status = 1;

      $params = ['subject', 'body', 'from', 'to', 'from_name', 'to_name'];
      foreach ($params as $field) {
        if (!isset($post->{$field})) {
          return ("$field field is not defined for sending email parameters");
        }
      }
      $company = $this::$generic->company();
      $uridata = $this::$generic->getUriData();

      $company->site = $uridata->backend;
      $post    = object(array_merge((array)$company, (array)$post));
      // unset($post->branches);
      // Required fields for various templates
      if (empty($post->template)) $post->template = "default";
      if ($post->template == "link" && empty($post->link)) return "Template requires a `link` field";
      if ($post->template == "token" && empty($post->token)) return "Template requires a `token` field";

      // Map templates to their files
      $maps = [
        "default" => "basic-content",
        "basic" => "basic-content",
        "token" => "kyc-tokens",
        "link" => "click-link",
        "success" => "kyc-approved",
        "notify" => "kyc-notification",
        "info" => "kyc-notification",
        "warning" => "kyc-pending",
        "letter" => "letter-format",
        "registeration" => "welcome"
      ];
      if (!in_array($post->template, array_keys($maps))) return "Invalid template, use any of these template; (" . implode(", ", array_keys($maps)) . ")";

      $post->html = curl_post("{$uridata->backend}includes/email-template/{$maps[$post->template]}.php", $post);

      return self::mailTrap($post);
    }
  }

  private static function mailTrap($post)
  {
    $sandbox = get_env("ENV") === "development";
    $response = new stdClass;
    $curl = new Curl();

    $mail = [
      "to" => [
        [
          "email" => $post->to,
          "name" => $post->to_name
        ]
      ],
      "from" => [
        "email" => "support@cron.website",
        "name" => $post->from_name
      ],
      "subject" =>  $post->subject,
      "html" =>  $post->html,
      "text" =>  $post->body,
    ];
    if ($sandbox) {
      $curl::setHeader('Api-Token: ' . get_env("MAILTRAP_SANDBOX_KEY"));
      $endpoint = "https://sandbox.api.mailtrap.io/api/send/2141027";
    } else {
      $curl::setHeader('Authorization: Bearer ' .  get_env("MAILTRAP_API_KEY"));
      $endpoint = "https://send.api.mailtrap.io/api/send";
    }

    $response = $curl::post($endpoint, $mail);
    return $response;
  }

  private static function sendGrid($post)
  {
    $response = new stdClass;
    $mailKey = get_env("SENDGRID_API_KEY");
    $curl = new Curl();
    $curl::setHeader('authorization: Bearer ' . $mailKey);

    $response = $curl::post(
      "https://api.sendgrid.com/v3/mail/send",
      array(
        "personalizations" => array(array(
          "to" => array(
            array(
              "email" => $post->to,
              "name" => $post->to_name
            )
          ),
          "subject" => $post->subject
        )),
        "content" => array(array(
          "type" => "text/html",
          "value" => $post->html
        )),
        "from" => array(
          "email" => "hello@easypayy.com",
          "name" => $post->from_name
        ),
        "reply_to" => array(
          "email" => $post->from,
          "name" => $post->from_name
        )

      )
    );

    return ($response);
  }

  public static function phpMailer($post)
  {
    $response = new stdClass;
    $Mail = new PHPMailer();

    $subject = ucwords($post->subject);
    if (empty($post->replyTo)) $post->replyTo = $post->from;
    $Mail->AddReplyTo($post->replyTo, "RE: $subject");
    $Mail->From     = $post->from;
    $Mail->FromName = $post->from_name;
    $Mail->Body = $post->html;
    $Mail->AltBody = $post->body;
    $Mail->Subject = $subject;
    $Mail->AddAddress($post->to);
    $Mail->WordWrap = 50;
    $Mail->IsHTML(true);
    if (!empty($post->copy_to)) {
      foreach ($post->copy_to as $key => $value) {
        $Mail->AddCC($value);
      }
    }
    if (!$Mail->send()) {
      $response->status = 0;
      $response->message = 'Error Sending email to ' . $post->to;
    } else $response->message = 'Mail Sent';
    return ($response);
  }

  private static function mailChimp($post)
  {
    $uridata = self::$generic->getUriData();
    $mailKey = get_env($uridata->backend, "MAILCHIMP");

    $response = new stdClass;
    $message = [
      "from_email" => $post->from,
      "subject" => $post->subject,
      "text" => $post->body,
      "to" => [
        [
          "email" => $post->to,
          "type" => "to"
        ]
      ]
    ];
    $response = Curl::post("https://mandrillapp.com/api/1.0/messages/send", ["message" => $message, "key" => $mailKey]);
    // try {
    //   $mailchimp = new MailchimpTransactional\ApiClient();
    //   $mailchimp->setApiKey($mailKey);
    //   $response = $mailchimp->messages->send(["message" => $message]);
    //   $response->status = 1;
    // } catch (Error $e) {
    //   $response->status = 0;
    //   $response->message = 'Error Sending email to ' . $post->to;
    //   echo 'Error: ', $e->getMessage(), "\n";
    // }
    return $response;
  }

  private function reroute($post)
  {
    $email = array_extract($post, ["body", "from", "from_name", "html", "subject", "to", "to_name"], true);

    $email["case"] = "php-mailer";
    $response = Curl::post("https://xcredenx.com/backend/process/custom/", $email);
    return $response->body;
  }
}
