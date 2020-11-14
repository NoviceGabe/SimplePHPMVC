<?php
namespace app\core; 

class Controller{
	protected $view;

	public function __construct(){
		$this->view = new View();
	}

	public function model($model){
		if(file_exists('./app/model/'.$model.'.php')){
			$class = 'app\\model\\'.$model;
			return new $class();
		}
		return NULL;
	}

	public function view($view, $data = []){
		if(file_exists('./app/view/'.$view.'.php')){
			require_once './app/view/'.$view.'.php';
		}else{
			die("View doesnt exist");
		}
	}
}