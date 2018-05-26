<?php

class BasicController {
	
	public static function action_obfuscator()
	{
		$arr_return = array();
		$arr_return = Flight::request()->data->getData();
		Flight::renderSmarty('obfuscator.html',$arr_return);
		return FALSE;//Stop Route
	}
	
	public function checklogin(){
		if(isset($_SESSION["login_token"]) == TRUE && $_SESSION["login_token"] == md5(SYSTEM_PASSCODE)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
}
