<?php

namespace app\lib;
use PDO;

class Database{
	private static $_instance = null;

	private $_conn;
	private $_error = false;
	private $_errorMessage;

	private $_dbHandler;
	private $_query = null;

	private string $_sql = '';
	private array $_conditions = [];
	private array $_fvalues = [];
	private string $_delimiter = ' AND ';

	private $_action = '';

	private function __construct($dbhost, $dbname, $dbuser, $dbpassword){
		$this->_conn = 'mysql:host='.$dbhost.';dbname='.$dbname;
		$options = array(
					PDO::ATTR_PERSISTENT => true,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
		);

		try{
			$this->_dbHandler = new PDO($this->_conn, $dbuser, $dbpassword, $options);
			
		}catch(PDOException $e){
			$this->_error = true;
			$this->_errorMessage = $e->getMessage();
			die($this->_errorMessage );
		}
	}

	public static function getInstance($dbhost, $dbname, $dbuser, $dbpassword){
		if(!isset(self::$_instance)){
			self::$_instance = new Database($dbhost, $dbname, $dbuser, $dbpassword);
		}
		return self::$_instance;
	}

	public function query($sql){
		$this->_error = false;
		$this->_query = $this->_dbHandler->prepare($sql);
		return $this;
	}

	public function get($table, $param = '*'){
		if(is_array($param) && count($array)){
			$this->param = implode(', ', $param);
		}
		$this->_sql = 'SELECT '.$param.' FROM '.$table;
		$this->_action = 'select';
		return $this;
	}

	public function insert($table, $data = array()){
		$sql = 'INSERT INTO '.$table.' (';
		$sql .= '`'.implode('`, `', array_keys($data)).'`) VALUES (';
		$key = array_keys($data);
		foreach ($key as &$value) {
			$value = ':'.$value;
		}
		unset($value);
		$sql .= implode(", ", $key).")";
		$this->_sql = $sql;
		$this->_fvalues[] = $data;
		$this->query($this->_sql)->bindGroup($this->_fvalues);
		$this->_action = 'insert';
		return $this;
	}

	public function bind($param, $value, $type = null){
		switch (is_null($type)) {
			case is_int($value):
				$type = PDO::PARAM_INT;
				break;
			case is_bool($value):
				$type = PDO::PARAM_BOOL;
				break;
			case is_null($value):
				$type = PDO::PARAM_NULL;
				break;
			default:
				$type = PDO::PARAM_STR;
		}
		return $this->_query->bindValue($param, $value, $type);
	}

	public function bindGroup($values){	
		foreach ($values as $value) {
			foreach ($value as $key => $val) {
				$this->bind(':'.$key, $val);
			}			
		}
	}

	public function where(){
		$numArgs = func_num_args();
		$args = func_get_args();

		if($numArgs == 3){
			$scalarCount = 0;
			$arrayCount = 0;
			foreach ($args as $arg) {
				if(is_scalar($arg)){
					$scalarCount++;
				}else if(is_array($arg)){
					$arrayCount++;
				}
			}
			if($numArgs == $scalarCount){
				if(count($this->_conditions)){
					$this->_conditions[] = $this->_delimiter;
				}
			
				$this->_conditions[] = [
					'field' => $args[0],
					'operator' => $args[1],
					'value' => ':'. $args[0]
				];

				$this->_fvalues[] = [$args[0] => $args[2]];
	
			}else if($numArgs == $arrayCount){
				
				if(count($this->_conditions)){
					$this->_conditions[] =  $this->_delimiter;;
				}
				$this->_conditions[] = '(';
				foreach ($args as $arg) {
					if(count($arg) == 3){
						$this->_conditions[] = [
							'field' => $arg[0],
							'operator' =>  $arg[1],
							'value' => $arg[2]
						];

					}else{

						$key = array_keys($arg)[0];
						$this->_conditions[] = [
							'field' => $key,
							'operator' => '=',
							'value' => $arg[$key]
						];
					}
				}
				$this->_conditions[] = ')';
			}
		}else{
			if(count($this->_conditions)){
					$this->_conditions[] =  $this->_delimiter;;
				}
				$this->_conditions[] = '(';
				$i = 0;
				foreach ($args as $arg) {
					if(count($arg) == 3){
						$this->_conditions[] = [
							'field' => $arg[0],
							'operator' =>  $arg[1],
							'value' => $arg[2]
						];

					}else{
						$key = array_keys($arg)[0];
						$this->_conditions[] = [
							'field' => $key,
							'operator' => '=',
							'value' => $arg[$key]
						];
					}
					if($i < count($args)-1){
						$this->_conditions[] =  $this->_delimiter;;
					}
					$i++;
				}
				$this->_conditions[] = ')';
		}
		$sql = ' WHERE ';
		foreach ($this->_conditions as $condition) {
			if(is_array($condition)){
				$sql .= implode(' ', $condition);
			}else{
				$sql .= $condition;
			}
		}
		$this->_sql .= $sql;
		return $this;
	}

	public function or(){
		 $this->_delimiter = ' OR ';
		 return $this;
	}

	public function and(){
		 $this->_delimiter = ' AND ';
		 return $this;
	}

	public function execute(){
		try{
			if(is_null($this->_query)){
				$this->query($this->_sql)->bindGroup($this->_fvalues);
			}
			if($this->_query->execute()){
				$this->_error = false;
				$this->_errorMessage = '';
			}else{
				$this->_error = true;
				$this->_errorMessage = 'Query error';
			}
		}catch(PDOException $e){
			$this->_error = true;
			$this->_errorMessage = $e->getMessage();
		}
		return $this;
	}

	public function results(){
		try{
			return $this->_query->fetchAll(PDO::FETCH_OBJ);
		}catch(PDOException $e){
			$this->_error = true;
			$this->_errorMessage = $e->getMessage();
			return false;
		}
	}

	public function result(){
		try{
			return $this->_query->fetch(PDO::FETCH_OBJ);
		}catch(PDOException $e){
			$this->_error = true;
			$this->_errorMessage = $e->getMessage();
			return false;
		}
	}

	public function count(){
		return $this->_query->rowCount();
	}

	public function error(){
		return $this->_error;
	}

	public function errorMessage(){
		return $this->_errorMessage;
	}
}