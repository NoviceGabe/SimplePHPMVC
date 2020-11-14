<?php

namespace app\controller;
use app\core\Controller as base;
use app\helper;

class User extends base{
	private $_model;

	public function __construct(){
		parent::__construct();
		$this->_model = $this->model('User');
	}

	public function index(){
		$data = [
			'title' => 'Users',
		];
		$this->view->render('user/index', $data);
	}

	public function logout(){
		helper\SessionManager::start();
		helper\SessionManager::end();
		header('location: '.ROOT_URL.'/index');
		die();
	}

	public function register(){
		$this->view->render('user/register');
	}

	public function error(){
		$this->view->render('error/404');
	}
}