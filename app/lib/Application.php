<?php

namespace app\lib;

class Application{
	public Router $router;
	public Request $request;
	
	public function __construct(){
		$this->_set_reporting();
		$this->request = new Request();
		$this->router = new Router($this->request);
	}

	public function run(){
		$this->router->dispatch();
	}

	private function _set_reporting(){
		if(DEBUG){
			error_reporting(E_ALL);
			ini_set('display_errors', 1);
		}else{
			error_reporting(0);
			ini_set('log_errors', 1);
			ini_set('error_log', ROOT_URL.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'errors.log');

		}
	}
}