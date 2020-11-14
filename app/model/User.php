<?php
// User model
namespace app\model;
use \app\helper;
use \app\core\Model as Base;

class User extends Base{
	public function __construct(){
		parent::__construct();
	}

	public function getUsers(){
		return $this->db->get('user')->execute()->results();
	}

	public function findUserByEmail(string $email){
		return $this->db->get('user')->where('email','=',$email)->execute()->count();
	}

	public function register($data){
		return $this->db->insert('user',[
			'name' => $data['name'], 
			'email'=>  $data['email'], 
			'password' => $data['password'],
			'joined'=> helper\Utility::getDateString()
		])->execute()->error() === false;
	}

	public function login($email, $password){
		$this->db->get('user')->where('email','=',$email);
		if($this->db->execute()->count()){
			$result = $this->db->result();	
			if(!password_verify($password, $result->password)){
				return false;
			}
			return $result;
		}
		return false;
	}

	public function message(array $data){
		$this->_db->query('INSERT INTO message (email, subject, content, subscribe, `date`) VALUES (:email, :subject, :content, :subscribe, :date)');
		$this->_db->bind(':email', $data['email']);
		$this->_db->bind(':subject', $data['subject']);
		$this->_db->bind(':content', $data['message']);
		$this->_db->bind(':subscribe', $data['subscribe']);
		$this->_db->bind(':date', helper\Utility::getDateString());
		return !$this->_db->execute()->error();
	}

	public function subscribe($email){
		return $this->db->insert('subscription',[
			'email'=>$email, 
			'date'=> helper\Utility::getDateString()
		])->execute()->count();
	}

	public function isSubscribe($email){
		return $this->db->get('subscription')->where('email','=',$email)->execute()->count();
	}
}