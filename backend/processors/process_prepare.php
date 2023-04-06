<?php
require_once("controllers/Controllers.php");
// require_once("../controllers/Ecommerce.php");
$post             = object(array_merge($_POST, $_GET));
$session          = object($_SESSION);
$response         = new stdClass;
$generic           = new Generic;
$db               = $generic->connect();
session_destroy();
$database = get_env("DB_NAME");
$db->query("DROP DATABASE {$database};");
$db->query("CREATE DATABASE {$database};");
setcookie("siteData", "0",  time() - 36000, "/");
header("Location: {$uri->backend}run-tables?redir=home");
