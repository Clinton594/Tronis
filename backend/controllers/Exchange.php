<?php
// All currency codes must adhere to ISO_4217 currency codes.
// Visit https://en.wikipedia.org/wiki/ISO_4217#Active_codes to find out what this means
// Compiled by Clinton 27-02-2020
require_once("Curl.php");
class Exchange
{
  public $base;
  static $API_KEY = null;
  static $generic = null;
  public $dir = "";

  public function __construct($base = "USD")
  {
    $generic = new Generic;
    $this->base = $base;
    $uri = $generic->getURIdata();
    $this->dir = absolute_filepath($uri->site) . "cache/";
  }

  public function getRates($coins = [], $createOnly = false)
  {
    $response = [];
    sort($coins);
    $today = time();
    $dir   = $this->dir;
    $filename = strtourl(implode(" ", $coins));
    $file  = "{$dir}{$filename}.json";
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $filestatus = file_exists($file) ? "EXISTS" : "NOT_EXISTS";

    // Check if the actual file exists, if not, search existing files
    if ($filestatus === "NOT_EXISTS") {
      $files = array_map(function ($x) use ($dir) {
        return object(["file" => $dir . $x, "time" => filemtime($dir . $x)]);
      }, _readDir($dir));
      usort($files, function ($a, $b) {
        return $b->time <=> $a->time;
      });

      $files = array_map(function ($x) {
        return $x->file;
      }, $files);
      $files = array_filter($files, function ($file) use ($coins) {
        $status = true;
        foreach ($coins as $key => $coin) {
          if (stripos($file, $coin) === false) {
            $status = false;
            break;
          }
        }
        return $status;
      });

      if (count($files)) {
        $filestatus = "FOUND";
        $file = reset($files);
      }
    }

    $last_modified = $filestatus !== "NOT_EXISTS" ? round(($today - filemtime($file)) / 3600) : 500;

    if ($filestatus !== "NOT_EXISTS" && $createOnly !== true &&  $last_modified < 6) { //Less than 6hours
      $rates  = isJson(_readFile($file));
    } else {
      $response = $this->coinMarketCapRates($coins, $file, $filestatus);
      if ($response->code === 200) $rates = $response->body;
      else {
        $response = $this->coinGeckoRates($coins, $file, $filestatus);
        if ($response->code === 200) $rates = $response->body;
        else $rates = [];
      }
    }

    $coins = array_map("strtolower", $coins);
    $rates = array_filter((array)$rates, function ($rate) use ($coins) {
      return in_array(strtolower($rate->symbol), $coins);
    });

    return (array)$rates;
  }

  public function coinMarketCapRates($coins, $file, $filestatus)
  {
    $response = Curl::get(
      "https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest",
      ["symbol" => implode(",", array_map("strtoupper", $coins)), "aux" => "cmc_rank"],
      ["X-CMC_PRO_API_KEY" => get_env("COINMARKETCAP_API_KEY")]
    );
    if ($response->code === 200) {
      $rates = $response->body->data;
      foreach ($rates as $coin => $data) {
        $data = reset($data);
        $data = flatten_array($data);
        $rates->{$coin} = $data;
      }
      if ($filestatus === "FOUND") $file = $this->dir . strtourl(implode(" ", $coins)) . ".json";

      _writeFile($file, $rates);
      $response->body = $rates;
    }
    return $response;
  }

  public function coinGeckoRates(
    $coins,
    $file,
    $filestatus
  ) {
    $_coins = $this->coinGeckoList($coins);

    $_coins = implode(",", array_map("strtolower", array_column($_coins, "id")));

    $rates = [];
    $response = Curl::get(
      "https://api.coingecko.com/api/v3/coins/markets",
      ["vs_currency" => $this->base, "ids" =>  $_coins, "order" => "market_cap_desc", "per_page" => 100, "page" => 1, "sparkline" => "false"],
    );
    if ($response->code === 200) {
      foreach ($response->body as $key => $coin) {
        $newCoin = object(array_extract($coin, ["id", "symbol", "name", "last_updated", "market_cap"], true));
        $newCoin->symbol = strtoupper($coin->symbol);
        $newCoin->price = $coin->current_price;
        $newCoin->cmc_rank = $coin->market_cap_rank;
        $newCoin->percent_change_24h = $coin->price_change_percentage_24h;

        $rates[strtoupper($coin->symbol)] = $newCoin;
      }
      if ($filestatus === "FOUND") $file = $this->dir . strtourl(implode(" ", $coins)) . ".json";
      _writeFile($file, $rates);
      $response->body = $rates;
    }
    return $response;
  }

  // Meta data
  public function getMetaData($coins, $createOnly = false)
  {
    sort($coins);
    $today = time();
    $dir   = $this->dir;
    $filename = strtourl(implode(" ", $coins));
    $file  = "{$dir}{$filename}-metadata.json";
    $response = [];
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    if (file_exists($file) && $createOnly !== true && (round(($today - filemtime($file)) / 60) < (24 * 365))) { //Less than 1 year
      $response  = isJson(_readFile($file));
    } else {
      $response = Curl::get(
        "https://pro-api.coinmarketcap.com/v2/cryptocurrency/info",
        ["symbol" => implode(",", array_map("strtoupper", $coins)), "aux" => "urls,logo,description"],
        ["X-CMC_PRO_API_KEY" => get_env("COINMARKETCAP_API_KEY")]
      );
      if ($response->code === 200) {
        $result = $response->body->data;
        foreach ($result as $coin => $data) {
          $data = reset($data);
          $data = array_extract(flatten_array($data), ["id", "name", "symbol", "description", "logo"], true);
          $result->{$coin} = object($data);
        }
        _writeFile($file, $result);
        $response = $result;
      }
    }
    return $response;
  }

  // Coin List
  public function coinGeckoList($coins = [], $createOnly = false)
  {
    $today = time();
    $dir   = $this->dir;
    $file  = "{$dir}/coin-gecko-list.json";
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }
    $rates = [];
    if (file_exists($file) && $createOnly !== true && (round(($today - filemtime($file)) / 60) < (3600 * 24))) { //Less than 1 day
      $rates = json_decode(_readFile($file));
    } else {
      $response = Curl::get("https://api.coingecko.com/api/v3/coins/list");
      if ($response->code === 200) {
        $rates = $response->body;
        $rates = _writeFile($file, $rates, true);
        $rates = isJson($rates);
      }
    }
    if (count($coins)) {
      $rates = array_filter($rates, function ($rate) use ($coins) {
        return in_array(strtolower($rate->symbol), array_map("strtolower", $coins));
      });
    }
    return (array_values($rates));
  }

  // coinlib Graph
  public function currencyGraph($coins = [], $createOnly = false)
  {
    $today = time();
    $dir   = dirname($this->dir);
    $file  = "{$dir}/currencyGraph.json";
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }
    $rates = [];
    if (file_exists($file) && $createOnly !== true && (round(($today - filemtime($file)) / 60) < (3600 * 24 * 365))) { //Less than 1 year
      $rates = json_decode(_readFile($file));
    } else {
      $result = Curl::get("https://coinlib.io/searchable_items_json?v=109987&json");
      if ($result->code === 200) {
        $rates = _writeFile($file, $result->body, true);
        $rates = isJson($rates);
      }
    }
    if (count($coins)) {
      $rates = array_filter($rates, function ($rate) use ($coins) {
        return in_array($rate->symbol, $coins);
      });
    }
    return (array_values($rates));
  }
}
