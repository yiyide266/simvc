<?php
namespace app\rbac\controller;
class LoginController extends \simvc\lib\controller\C{

	public function login(){
		$data['u_account'] = req( 0, 'n' );
		$data['u_pass'] = req( 0, 'p' );
		$m = \app\rbac\module\Login::instance();
		$re = $m -> login( $data );
		var_dump( $re );
	}

	public function logout(){
		
		$m = \app\rbac\module\Login::instance();
		$re = $m -> logout();
		var_dump( $re );
	}

	public function cookieLogin(){
		
		$m = \app\rbac\module\Login::instance();
		$re = $m -> cookieLogin();
		var_dump( $re );
	}

	public function show(){
		var_dump( cookie_get( 'u_id' ) );
		var_dump( cookie_get( 'u_sess' ) );
		var_dump( sess( 'u_id' ) );
		var_dump( sess( 'u_permit' ) );
	}

}
?>
