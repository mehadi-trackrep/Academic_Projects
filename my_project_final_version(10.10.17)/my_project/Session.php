<?php

class Session{
	public static function init(){
		if(version_compare(phpversion(),'5.4.0', '<')){
			if(session_id() == ''){
				session_start();
			}
		}else{
			if(session_status() == PHP_SESSION_NONE){
				session_start();
			}else{
				echo "session does not start\n";
			}
		}
	}

	public static function set($key,$val){
		$_SESSION[$key] = $val;
	}

	public static function get($key){
		//echo "check the key: ".$key;
		if(isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}else{
			return false;
		}
	}

	public static function checkSession(){
		//self::destroy();
		if(self::get("login") == false){
			self::destroy();
			header("Location: login.php");
			
		}
	}

	public static function checkLogin(){
		if(self::get("login") == true) {
			//header("Location: index.php");
			;
		}else{
			header("Location: login.php");
		}
	}

	public static function destroy(){
		session_destroy();
		session_unset();
		header("Location: login.php");
	}

}

?>