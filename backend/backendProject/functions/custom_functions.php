<?php

function prepare_new_member($post)
{
	if (empty($post->id)) {
		$post->username = substr(preg_replace("/[^a-zA-Z0-9]+/", "", explode("@", $post->email)[0]), 0, 7) . random(3);
		$post->username = strtolower($post->username);
		$post->first_name = ucwords(strtolower($post->first_name));
		$post->last_name = ucwords(strtolower($post->last_name));
		$post->email = strtolower($post->email);
	}
	return $post;
}

// Post sumbit function
function default_tracking($post)
{
	if ($post->submitType === "insert") {
		global $generic;
		global $paramControl;
		$tracking_messages = $paramControl->load_sources("tracking_message");
		$ds = array_keys(arrray($tracking_messages));
		$tracking = [
			"waybill_id" => $post->primary_key,
			"tracking_message" => reset($ds),
			"status" => "warning"
		];
		$response = $generic->insert($tracking, "tracking");
		if (!empty($response->status)) {
			$messenger = new Messenger($generic);
			$company = $generic->company();
			$mail       = (object)[
				'subject'    =>  "New Waybill",
				'body'      =>  "Hi admin, a new waybill with ID:{$post->tracking_number} was created",
				'from'      =>  $company->email,
				'to'        =>  $company->email,
				'from_name'  =>  $company->name,
				'to_name'    =>  $company->name,
				"template"  =>  "code",
				"code"  =>  $post->tracking_number,
			];
			$messenger->sendMail($mail);
		}
	}
	return $post;
}

// pre sumbit function
function tracking_number($post)
{

	if (empty($post->id)) {
		$post->tracking_number = uniqid(random(2));
		$post->return_values = true;
	}
	return ($post);
}

function myround($number)
{
	$fmn = new NumberFormatter("en", NumberFormatter::DECIMAL);
	$appCurrency = "$";
	return $appCurrency . $fmn->format(round($number, 2));
}

function get_percent($amount, $total)
{
	return empty($total) ? 0 : ($amount * 100) / $total;
}

function get_percent_of($percent, $amount)
{
	return ($amount * $percent) / 100;
}

function my_slug($post)
{
	$post->symbol = strToUrl($post->name);
	return $post;
}

function notifyUser($post)
{
	global $generic;
	global $paramControl;

	$tx = $post;
	$type = isset($post->tx_type) ? $post->tx_type : $post->pageType;
	if (!empty($post->status) && empty($post->notify)) {
		$user = $generic->getFromTable("users", "id={$post->user_id}");
		$user = reset($user);
		$currency = $paramControl->load_sources("currency");
		$messenger = new Messenger($generic);
		$company = $generic->company();
		$notify_mail = object([
			"subject" => ucwords("{$type} Approved"),
			"body" => "Hi {$user->first_name}, your {$type} of {$currency}{$post->amount} has been approved.",
			"to" => $user->email,
			"from" => $company->email,
			"from_name" => $company->name,
			"to_name" => $user->first_name,
			"template" => "success",
		]);
		$post = $messenger->sendMail($notify_mail);
		if (!empty($post->status)) {
			$db = $generic->connect();
			if (empty($tx->primary_key) && !empty($tx->id)) $tx->primary_key = $tx->id;
			$db->query("UPDATE transaction SET notify='1' WHERE id='{$tx->primary_key}'");
		}
	}
	return $post;
}

function getCountries($countries)
{
	$keys = array_column($countries, "code");
	return array_map(function ($country) {
		return $country["name"];
	}, array_remap($countries, $keys));
}

function buildKeys($values)
{
	$keys = array_map(function ($value) {
		return str_replace(" ", "-", strtolower($value));
	}, $values);
	return array_remap($values, $keys);
}
