<?php
namespace app\rbac\controller;
class RolesController extends \simvc\lib\controller\C{
	

	public static function who(){
		return __CLASS__;
	}
	
	public function addPage(){
		$token = sess_token_set( 'app_rbac_role_add' );
		$this -> assign( 'token', $token );
		$this -> display();
	}
	public function add(){
		if(!sess_token_check( 'app_rbac_role_add', $_POST['form_token'] ) ){
			output( 4, $this -> lang[2] );
		}
		$data['r_name'] = $_POST['r_name'];
		$data['r_des'] = $_POST['r_des'];
		$m = new \app\rbac\module\Roles();
		$re = $m -> addOne( $data );
		if( $re[0] == 2 ){
			output( 5, $this -> lang[1] ,array( 'r_id' => $re[1] ) );
		}else{
			output( 4, $this -> lang[2] );
		}
	}
	public function del(){
		$m = \app\rbac\module\Roles::instance();
		$id = req( 0,'id' );
		$re = $m -> delOne( $id );
		var_dump( $re );
	}

	public function get(){
		$m = new \app\rbac\module\Roles();
		$id = req( 0,'id' );
		$re = $m -> getOne( $id );
		if( $re[0] == 1 ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}

	public function pagin(){
		$m = new \app\rbac\module\Roles();
		$page = req( 0, 'p' );
		$size = req( 0, 's' );
		$re = $m -> pagination( array(), $page, $size, array('u_id','u_account') );
		var_dump( $re );
	}


}


?>
