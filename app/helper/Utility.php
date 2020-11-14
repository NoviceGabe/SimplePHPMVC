<?php

namespace app\helper;

class Utility{
	public static function getDateString($timezone = 'Asia/Manila', $format = 'm/d/Y h:i:s a'){
		date_default_timezone_set($timezone);
		return strtotime(date($format, time()));
	}
}