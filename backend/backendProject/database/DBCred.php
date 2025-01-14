<?php
class DBCred
{
  static $local_server = "localhost";
  static $server = "localhost";
  static $local_servers = ['localhost', 'localhost:8080', "127.0.0.1"];
  public $backend = "backend/";
  public $isReact = false;
  static $foreign_exchange = [
    "API_KEY" => ""
  ];

  static $twilio = [
    "SMS_DEFAULT" => "",
    "ACCOUNT" => "",
    "PHONE" => "",
    "SECRET" => "",
    "ACCOUNT_SID" => "",
    "API_KEY" => "",
    "AUTH_TOKEN" => "",
    "services" => [
      "verify" => [
        "NAME" => "",
        "SID" => ""
      ]
    ]
  ];

  static $paystack = [
    "DEFAULT" => "SK_TEST",
    "SK_LIVE" => "",
    "PK_LIVE" => "",
    "SK_TEST" => "",
    "PK_TEST" => "",
  ];

  static $recaptcha = [
    "PUBLIC_KEY" => "6Le75kMaAAAAAH3Bev51t1Dmx8BVvh1JMCre6G7n",
    "SECKRET_KEY" => "6Le75kMaAAAAAA9Gu9-pLRmBRcj_E2o6zNrcu1vd"
  ];

  static $exchange = [
    "API_KEY" => ""
  ];

  static $coinlib = [
    "API_KEY" => "e69328884b1d0f0e"
  ];
}
