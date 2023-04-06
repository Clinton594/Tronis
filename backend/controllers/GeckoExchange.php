<?php
// All currency codes must adhere to ISO_4217 currency codes.
// Visit https://en.wikipedia.org/wiki/ISO_4217#Active_codes to find out what this means
// Compiled by Clinton 27-02-2020
class GeckoExchange
{
  // https://currencyapi.net API Key
  static $API_KEY = null;
  static $generic = null;
  public $filename = "";

  public function __construct($base = "USD")
  {
    $this->base = $base;
    $generic = new Generic;
    $uri = $generic->getURIdata();
    $dir = absolute_filepath($uri->site) . "cache/";
    $file = "{$dir}rates.json";
    $this->filename = $file;
    $this::$generic = $generic;
  }


  public function coinGeckoRates($coins = [], $createOnly = false)
  {
    sort($coins);
    $today = time();
    $dir   = dirname($this->filename);
    $filename = strtourl(implode(" ", $coins));
    $file  = "{$dir}/{$filename}.json";
    $response = [];
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }
    // see($coins);
    // Check if all the coins to be fetched exits in the file already, if not it request must come from internet
    if (file_exists($file)) {
      $fileRates = json_decode(_readFile($file));
      $crypto = array_column($fileRates, "id");
      if (array_diff($coins, $crypto)) {
        $createOnly = true;
      }
    }

    if (file_exists($file) && $createOnly !== true && (round(($today - filemtime($file)) / 60) < 6400)) { //Less than 2hours
      $rates = $fileRates;
    } else {

      $default_coins = ["bitcoin", "binancecoin", "bitcoin-cash", "cardano", "matic-network", "solana", "litecoin", "ripple", "dogecoin", "ethereum"];

      if (count($coins)) {
        $_coins = array_unique(array_merge($coins, array_diff($default_coins, $coins)));
        $_coins = "&ids=" . implode(",", array_map("strtoupper", $_coins));
      } else $_coins = "&ids=" . implode(",", array_map("strtoupper", $default_coins));

      $rates = [];
      $url = strtolower("https://api.coingecko.com/api/v3/coins/markets?vs_currency={$this->base}{$_coins}&order=market_cap_desc&per_page=100&page=1&sparkline=false");
      $response = curl_get_content($url, $this::$generic);
      $result = isJson($response);
      if ($result) {
        $rates = array_map(function ($rate) {
          $rate->price = $rate->current_price;
          $rate->symbol = strtoupper($rate->symbol);
          return $rate;
        }, $result);
        _writeFile($file, $rates);
      }
    }
    if (count($coins)) {
      $rates = array_filter($rates, function ($rate) use ($coins) {
        return in_array($rate->id, $coins);
      });
    }
    return array_remap(array_values($rates), array_column(array_values($rates), "symbol"));
  }

  public function coinGeckoList($coins = [], $createOnly = false)
  {
    $today = time();
    $dir   = dirname($this->filename);
    $file  = "{$dir}/coin-gecko-list.json";
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }
    if (file_exists($file) && $createOnly !== true && (round(($today - filemtime($file)) / 60) < (3600 * 24))) { //Less than 1 day
      $rates = json_decode(_readFile($file));
    } else {
      $rates = curl_get_content("https://api.coingecko.com/api/v3/coins/list", $this::$generic);
      $rates = _writeFile($file, $rates, true);
      $rates = isJson($rates);
    }
    if (count($coins)) {
      $rates = array_filter($rates, function ($rate) use ($coins) {
        return in_array($rate->symbol, $coins);
      });
    }
    return (array_values($rates));
  }

  public function currencyGraph($coins = [], $createOnly = false)
  {
    $today = time();
    $dir   = dirname($this->filename);
    $file  = "{$dir}/currencyGraph.json";
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }
    if (file_exists($file) && $createOnly !== true && (round(($today - filemtime($file)) / 60) < (3600 * 24))) { //Less than 1 day
      $rates = json_decode(_readFile($file));
    } else {
      $rates = curl_get_content("https://coinlib.io/searchable_items_json?v=109987&json", $this::$generic);
      $rates = _writeFile($file, $rates, true);
      $rates = isJson($rates);
    }
    if (count($coins)) {
      $rates = array_filter($rates, function ($rate) use ($coins) {
        return in_array($rate->symbol, $coins);
      });
    }
    return (array_values($rates));
  }
}
