<?php
namespace app\rbac\controller;
class CnodeAccessController extends \simvc\lib\controller\C{
	

	public function addPage(){
		$token = sess_token_set( 'app_rbac_cnode_access_add' );
		$this -> assign( 'token', $token );
		$this -> display();
	}
	public function add(){
		if(!sess_token_check( 'app_rbac_cnode_access_add', $_POST['form_token'] ) ){
			output( 4, $this -> lang[2] );
		}
		$data['r_id'] = $_POST['r_id'];
		$data['n_id'] = $_POST['n_id'];
		$m = \app\rbac\module\CnodeAccess::instance();
		$re = $m -> addOne( $data );
		if( $re[0] == 3 ){
			output( 5, $this -> lang[1] );
		}else{
			output( 4, $this -> lang[2] );
		}
	}

	public function get(){
		$m = \app\rbac\module\CnodeAccess::instance();
		$id = req( 0,'id' );
		$re = $m -> getOne( $id );
		if( $re[0] == 1 ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}

	public function pagin(){
		$m = \app\rbac\module\CnodeAccess::instance();
		$page = req( 0, 'p' );
		$size = req( 0, 's' );
		$re = $m -> pagination( array(), $page, $size, array('n_id','n_name','n_spec') );
		var_dump( $re );
	}

	public function getPermit(){
		$m = \app\rbac\module\CnodeAccess::instance();
		$uid = req( 0, 'uid' );
		$re = $m -> getUserPermit( $uid );
		if( !empty( $re ) ){
			var_dump( $m -> arrTotree_2($re) );
		}
		//var_dump( $re );
	}

	public function del(){
		$m = \app\rbac\module\CnodeAccess::instance();
		$rid = req( 0, 'rid' );
		$nid = req( 0, 'nid' );
		$m -> delOne( array( 'r_id' => $rid, 'n_id' => $nid ) );
	}


}


?>
