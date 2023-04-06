<?php
$timezone = $_SERVER['SERVER_NAME'] == "localhost" ? "Africa/Lagos" : "UTC";
date_default_timezone_set($timezone);
require_once __DIR__ . "../../functions/date_functions.php";
require_once __DIR__ . "../../functions/callback_functions.php";
require_once __DIR__ . "../../backendProject/functions/custom_functions.php";
require_once "Auth.php";
require_once "ParamControl.php";
require_once "DateDifference.php";
