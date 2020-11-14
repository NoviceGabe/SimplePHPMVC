<?php

namespace app\core;

class View{
	protected $head;
	protected $body;
	protected $title;
	protected $output;
	protected $layout = DEFAULT_LAYOUT;

	public function __construct(){}

	public function render($view, $data = []){
		if(file_exists('./app/view/'.$view.'.php')){
			require_once './app/view/'.$view.'.php';
		}else{
			die("View doesnt exist");
		}
	}

	public function layoutContent(){
		
	}
}