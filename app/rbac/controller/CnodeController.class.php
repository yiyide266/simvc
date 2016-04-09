<?php
namespace app\rbac\controller;
class CnodeController extends \simvc\lib\controller\C{
	

	public function addPage(){
		$token = sess_token_set( 'app_rbac_cnode_add' );
		$this -> assign( 'token', $token );
		$this -> display();
	}
	public function add(){
		if(!sess_token_check( 'app_rbac_cnode_add', $_POST['form_token'] ) ){
			output( 4, $this -> lang[2] );
		}
		$data['n_name'] = $_POST['n_name'];
		$data['n_spec'] = $_POST['n_spec'];
		$data['n_icon'] = $_POST['n_icon'];
		$data['n_type'] = $_POST['n_type'];
		$data['n_pid'] = $_POST['n_pid'];
		$data['n_t_s'] = $_POST['n_t_s'];
		$m = new \app\rbac\module\Cnode();
		$re = $m -> addOne( $data );
		if( $re[0] == 1 ){
			output( 5, $this -> lang[1] );
		}else{
			output( 4, $this -> lang[2] );
		}
	}

	public function get(){
		$m = new \app\rbac\module\Cnode();
		$id = req( 0,'id' );
		$re = $m -> getOne( $id );
		if( $re[0] == 1 ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}

	public function pagin(){
		$m = new \app\rbac\module\Cnode();
		$page = req( 0, 'p' );
		$size = req( 0, 's' );
		$re = $m -> pagination( array(), $page, $size, array('n_id','n_name','n_spec') );
		var_dump( $re );
	}


}


?>
