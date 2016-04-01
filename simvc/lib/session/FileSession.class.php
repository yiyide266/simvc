<?php
namespace simvc\lib\Session;
class FileSession extends Session{

	

	public function get( $key ){
		return isset($_SESSION['simvc'][$key])?$_SESSION[$key]:null;
	}
	
	public function set( $key, $val ){
		$_SESSION['simvc'][$key] = $val;
	}
	
	public function del( $key ){
		unset($_SESSION['simvc'][$key]);
	}

	public function destroy(){
		//session_destroy();
		unset($_SESSION['simvc']);
	}
	
	/*
	·ÃÎÊÏÞÖÆ
	*/
	public function frequency( $name, $expire ){
		if( isset( $_SESSION['simvc'][$name] ) ){
			if( $_SESSION['simvc'][$name] < time() ){
				unset($_SESSION['simvc'][$name]);
				return true; 
			}else{
				return false; 
			}
		}else{
			$_SESSION['simvc'][$name] = time() + $expire;
			return true;
		}
	}
	/*
	·ÀÖ¹ÖØ¸´Ìá½»
	*/
	public function sublimit_m( $name ){
		$token = rand(10000000,99999999);
		$_SESSION['simvc'][$name] = $token;
		return $token;
	}
	public function sublimit_c( $name, $token ){
		if( $token == $_SESSION['simvc'][$name] ){ return true; }
		else{ return false; }
	}
	public function sublimit_d( $name ){
		unset($_SESSION['simvc'][$name]);
	}
}
?>
