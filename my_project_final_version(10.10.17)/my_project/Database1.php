<?php

	class Database1{
		private $hostdb = "localhost";
		private $userdb = "root";
		private $passdb = "";
		private $namedb = "task_share";
		public $pdo;

		public function Database1(){
			if(!isset($this->pdo)){
				try{
					$link = new PDO("mysql:host=".$this->hostdb.";dbname=".$this->namedb, $this->userdb, $this->passdb);
					$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$link->exec("SET CHARACTER SET utf8");
					$this->pdo = $link;
				}catch(PDOException $e){
					die("Failed to connect with Database");
				}
			}	
		}
	}
?>