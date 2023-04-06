<?php
session_start();
require_once("backend/controllers/Controllers.php");
require_once("backend/controllers/Exchange.php");
// require_once("backend/controllers/NumberFormatter.php");

$generic = new Generic;
$generic->connect();
$company = $generic->company();
$uri = $generic->getURIdata();

if (!empty($company->lock_site)) die("The website is currently unavailable");

$paramControl = new ParamControl($generic);
$session = object($_SESSION);
// see($company);
$cargo = $paramControl->load_sources("cargo_type");

$forExchange = new Exchange;
$currency = $paramControl->load_sources("currency");

$ext = pathinfo($uri->page_source, PATHINFO_EXTENSION);
if (!empty($ext)) {
  $url = $_SERVER['REQUEST_URI'];
  $url = str_replace(".$ext", "", $url);
  header("Location: $url");
}
$fmn = new NumberFormatter("en", NumberFormatter::DECIMAL);
$fmn->setAttribute(NumberFormatter::FRACTION_DIGITS, 2);

$valid_pages = [
  '' => "views/home.php",

];
$cache_control = "?ver=" . random();
$page_exists = isset($valid_pages[$uri->page_source]);
if ($page_exists == true) {
  require_once("{$valid_pages[$uri->page_source]}");
} else {
  require_once("views/page-404.php");
}
