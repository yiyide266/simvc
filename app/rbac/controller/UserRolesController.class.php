<?php
namespace app\rbac\controller;
class UserRolesController extends \simvc\lib\controller\C{
	

	public function addPage(){
		$token = sess_token_set( 'app_rbac_user_roles_add' );
		$this -> assign( 'token', $token );
		$this -> display();
	}
	public function add(){
		if(!sess_token_check( 'app_rbac_user_roles_add', $_POST['form_token'] ) ){
			output( 4, $this -> lang[2] );
		}
		$data['u_id'] = $_POST['u_id'];
		$data['r_id'] = $_POST['r_id'];
		$m = new \app\rbac\module\UserRoles();
		$re = $m -> addOne( $data );
		if( $re[0] == 2 ){
			output( 5, $this -> lang[1] );
		}else{
			output( 4, $this -> lang[2] );
		}
	}
	public function del(){
		$m = \app\rbac\module\UserRoles::instance();
		$data['u_id'] = req( 0,'uid' );
		$data['r_id'] = req( 0,'rid' );
		$re = $m -> delOne( $data );
		var_dump( $re );
	}
	public function get(){
		$m = new \app\rbac\module\UserRoles();
		$data['u_id'] = req( 0,'uid' );
		$data['r_id'] = req( 0,'rid' );
		$re = $m -> getOne( $data );
		var_dump( $re );
	}

	


}


?>
