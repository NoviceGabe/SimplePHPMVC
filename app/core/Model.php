<?php

namespace app\core;
use app\lib\Database as DB;
class Model{
	protected DB $db;
	
	public function __construct(){
		$this->db = DB::getInstance(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
	}
} 