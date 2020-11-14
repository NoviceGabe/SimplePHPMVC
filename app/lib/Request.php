<?php

namespace app\lib;

class Request{
	private string $uri = '';
	private string $method = 'GET';
	
	public function __construct(){
	 	$this->uri = isset($_REQUEST['url'])? filter_var($_REQUEST['url'], FILTER_SANITIZE_URL) : $this->uri;
		$this->method = isset($_SERVER['REQUEST_METHOD'])? $_SERVER['REQUEST_METHOD']: $method;
	}

	public function getPath(): string{
		return $this->uri;
	}

	public function getMethod() :string{
		return $this->method;
	}
}