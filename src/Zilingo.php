<?php
namespace igun997\Objects;

class Zilingo {

	public static $endpoint;

	public static $seller_id;
	public static $api_key;
	public static $locale;
	private static $_instance = null;

	public static function load(String $selid, String $selapi){

		self::$endpoint = 'https://api.sellers.zilingo.com';
		self::$seller_id = $selid;
		self::$api_key = $selapi;
		self::$locale = "id";

		if (self::$_instance === null) {
        self::$_instance = new self;
    }
    return self::$_instance;

	}
	private static function _getHeader(){

		return [
			'sellerId: '.self::$seller_id,
			'apiKey: ' .self::$api_key,
			'locale: ' .self::$locale
		];
	}

	public static function request($end_api,$request_data = null,int $type = 0){

    if ($type == 1 && $request_data != null) {
      $endpoint = self::$endpoint . $end_api."?".http_build_query($request_data);
    }else {
      $endpoint = self::$endpoint . $end_api;
    }


		$ch = curl_init($endpoint);
    if ($type == 1) {
      curl_setopt($ch, CURLOPT_POST, true);
  		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data));
    }
		curl_setopt($ch, CURLOPT_HTTPHEADER, self::_getHeader());
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$result = curl_exec($ch);
		if ($result === FALSE) {
			return FALSE;
		}

		curl_close($ch);
		$result = json_decode($result, TRUE);
    if (!empty($result)) {
			if (isset($result["STATUS"])) {
				if ($result["STATUS"] == "FAILED") {
					return FALSE;
				}
			}
      return $result;
    }

		return NULL;
	}

	public static function makeResponse(Int $code = 200,$data = [],String $msg = null)
	{

		header('Content-Type: application/json');
		http_response_code($code);

		$build = [
			"code"=>$code,
			"data"=>$data,
			"msg"=>$msg,
		];

		echo json_encode($build);
		return;

	}

	public static function stream(Array $old,String $status = "awaitingPickupRequest",String $endTime = null,int $rollBackTime = 1)
	{

		$req = self::request("/api/v2/orders/byStatus/".$status,NULL);

		$ord = new Order_Object($req);

		// $end = strtotime(date("2020-03-17 23:59:59"));


		$end = strtotime(date("Y-m-d 23:59:59"));

		$start = strtotime("-1 day",$end);


		if ($endTime != null) {

			$end = strtotime(date("{$endTime} 23:59:59"));

			$start = strtotime("-{$rollBackTime} day",$end);

		}

		$ord->recent($old,[$start,$end]);

		return $ord;
	}


}
