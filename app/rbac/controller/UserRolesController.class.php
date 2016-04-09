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

	public function get(){
		$m = new \app\rbac\module\UserRoles();
		$id = req( 0,'id' );
		$re = $m -> getOne( $id );
		if( $re[0] == 1 ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}

	public function pagin(){
		$m = new \app\rbac\module\UserRoles();
		$page = req( 0, 'p' );
		$size = req( 0, 's' );
		$re = $m -> pagination( array(), $page, $size, array('u_id','u_account') );
		var_dump( $re );
	}


}


?>
