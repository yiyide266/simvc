<?php
namespace app\rbac\controller;
class UsersController extends \simvc\lib\controller\C{
	

	public function addPage(){
		$token = sess_token_set( 'app_rbac_user_add' );
		$this -> assign( 'token', $token );
		$this -> display();
	}
	public function add(){
		if(!sess_token_check( 'app_rbac_user_add', $_POST['form_token'] ) ){
			output( 4, $this -> lang[2] );
		}
		$data['u_account'] = $_POST['u_account'];
		$data['u_pass'] = $_POST['u_pass'];
		$data['u_pid'] = $_POST['u_pid'];
		$data['u_t_s'] = $_POST['u_t_s'];
		$m = new \app\rbac\module\Users();
		$re = $m -> addOne( $data );
		if( $re[0] == 1 ){
			output( 5, $this -> lang[1] );
		}else{
			output( 4, $this -> lang[2] );
		}
	}

	public function get(){
		$m = new \app\rbac\module\Users();
		$id = req( 0,'id' );
		$re = $m -> getOne( $id );
		if( $re[0] == 1 ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}

	public function pagin(){
		$m = new \app\rbac\module\Users();
		$page = req( 0, 'p' );
		$size = req( 0, 's' );
		$re = $m -> pagination( array(), $page, $size, array('u_id','u_account') );
		var_dump( $re );
	}


}


?>
