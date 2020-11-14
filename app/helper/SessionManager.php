<?php

namespace app\helper;

class SessionManager{

	public static function set($key, $value){
		$_SESSION[$key] = $value;
	}

	public static function setGroup($data){
		foreach ($data as $datum => $value) {
			self::set($datum, $value);
		}
	}

	public static function get($key){
		return $_SESSION[$key];
	}

	public static function has($key){
		return isset($_SESSION[$key]);
	}

	public static function start(){
		if(session_status() == PHP_SESSION_NONE){
			session_start();
		}
	}

	public static function end(){
		if(session_status() != PHP_SESSION_NONE){
			session_destroy();
		}
	}
}