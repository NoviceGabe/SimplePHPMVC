<?php

namespace app\controller;
use app\core\Controller as base;
use app\helper;

class Home extends base{
	private $_model;

	public function __construct(){
		$this->_model = $this->model('User');
	}

	public function index(){
		$this->redirectActiveSession();
		$data = [
			'title' => 'Home',
			'error' => [
				'emailError' => '',
				'messageError' => ''
			]
		];
		$this->view('home/index', $data);
	}

	public function error(){
		$this->view('error/404');
	}

	public function subscribe(){
		$this->redirectActiveSession();
		$data = [
			'title' => 'Home',
			'email' => '',
			'error' => [
				'emailError' => '',
			]
		];

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data['email'] = trim($_POST['email']);

			if(empty($data['email'])){
				$data['error']['emailError'] = 'Empty email.';
			}else if(!helper\Validator::isEmailValid($data['email'])){
				$data['error']['emailError'] = 'Invalid email address.';
			}else{
				if(in_array('', $data['error'])){
					if($this->_model->isSubscribe($data['email'])){
						echo '<script>alert("You\'re already subscribed.")</script>'; 
					}else{
						if($this->_model->subscribe($data['email'])){
							echo '<script>alert("Check your email for daily newsletter")</script>'; 
							echo '<script>window.location.replace('.ROOT_PATH.'/);</script>';
						}else{
							echo '<script>alert("Unknown error occured! Please try again.")</script>'; 
						}
					}
				}
			}
		}
		$this->view('home/index', $data);
	}

	public function message(){

		$data = [
			'title' => 'Home',
			'email' => '',
			'subject' => '',
			'message' => '',
			'subscribe' => '', 
			'error' => [
				'emailError' => '',
				'messageError' => ''
			]
		];

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data['email'] = trim($_POST['email']);
			$data['message'] = trim($_POST['message']);
			$data['subscribe'] = isset($_POST['subscribe'])? trim($_POST['subscribe']): 'NO';

			if(empty($data['email'])){
				$data['error']['emailError'] = 'Empty email.';
			}else if(!helper\Validator::isEmailValid($data['email'])){
				$data['error']['emailError'] = 'Invalid email address.';
			}else if(empty($data['message'])){
				$data['error']['messageError'] = 'Empty message.';
			}else{
				if(in_array('', $data['error'])){
					if($this->_model->message($data)){
						echo '<script>alert("Your message has been sent successfully")</script>'; 
						echo '<script>window.location.replace('.ROOT_PATH.'/);</script>';
					}else{
						echo '<script>alert("Unknown error occured! Please try again.")</script>'; 
					}
				}
			}
		}
		$this->view('index', $data);
	}

	public function login(){
		$this->redirectActiveSession();
		$data = [
			'title' => 'Login',
			'email' => '',
			'password' => '',
			'error' => [
				'emailError' => '',
				'passwordError' => ''
			]
		];

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data['email'] = trim($_POST['email']);
			$data['password'] = trim($_POST['password']);

			if(empty($data['email'])){
				$data['error']['emailError'] = 'Empty email.';
			}else if(empty($data['password'])){
				$data['error']['passwordError'] = 'Empty password.';
			}else{
				if(in_array('', $data['error'])){
					$data['error']['passwordError'] = 'Invalid email or password.';
					if($user = $this->_model->login($data['email'], $data['password'])){
						if(!isset($_SESSION)){
							helper\SessionManager::start();
						}
						helper\SessionManager::setGroup($user);
						$data['error']['passwordError'] = '';
						header('location: '.ROOT_PATH.'/');
					}
				}
			}

		}
		$this->view('home/login', $data);
	}

	public function register(){
		$this->redirectActiveSession();
		$data = [
			'title' => 'Register',
			'name' => '',
			'email' => '',
			'password' => '',
			'error' => [
				'nameError' => '',
				'emailError' => '',
				'passwordError' => ''
			]
		];

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$data['name'] = trim($_POST['name']);
			$data['email'] = trim($_POST['email']);
			$data['password'] = trim($_POST['password']);

			// input validation
			if(empty($data['name'])){
				$data['error']['nameError'] = 'Empty name.';
			}else if(strlen($data['name']) < 3){
				$data['error']['nameError'] = "Name must be atleast 3 characters";
			}else if(strlen($data['name']) > 100){
				$data['error']['nameError'] = "Name must not exceed 100 characters";
			}else if(!helper\Validator::isNameValid($data['name'])){
				$data['error']['nameError'] = 'Name can only contain alphabetical characters and white spaces.';
			}else if(empty($data['email'])){
				$data['error']['emailError'] = 'Empty email.';
			}else if(!helper\Validator::isEmailValid($data['email'])){
				$data['error']['emailError'] = 'Invalid email address.';
			}else if(empty($data['password'])){
				$data['error']['passwordError'] = 'Empty password.';
			}else if(strlen($data['password']) < 8){
				$data['error']['passwordError'] = "Password must be at least 8 characters";
			}else if(strlen($data['password']) > 25){
				$data['error']['passwordError'] = "Password must not exceed 25 characters";
			}else if(!helper\Validator::isPasswordValid($data['password'])){
				$data['error']['passwordError'] = 'Password must start with a capital letter and contains at least one number';
			}else if($this->_model->findUserByEmail($data['email'])){
					$data['error']['emailError'] = 'An account with this email already exists.';
			}else{
				if(in_array('', $data['error'])){
					$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
					$data['joined']  = helper\Utility::getDateString();
					if($this->_model->register($data)){
						header('location: '.ROOT_PATH.'/login');
					}else{
						echo '<script>alert("Unknown error occured! Please try again.")</script>'; 
					}
				}
			}

		}
		$this->view('home/register', $data);
	}

	public function redirectActiveSession(){
		helper\SessionManager::start();
		if(helper\SessionManager::has('id')){
			header('location: '.ROOT_PATH.'/user/index');
			die();
		}
	}

}