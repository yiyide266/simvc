<?php
namespace app\product\controller;
class ProdSpropvalController extends \simvc\lib\controller\C{
	

	public function addPage(){
		$token = sess_token_set( 'app_product_spropval_add' );
		$this -> assign( 'token', $token );
		$this -> display();
	}
	public function add(){
		if(!sess_token_check( 'app_product_spropval_add', $_POST['form_token'] ) ){
			output( 4, $this -> lang[2] );
		}
		$data['sppv_type'] = $_POST['sppv_type'];
		$data['sppv_val'] = $_POST['sppv_val'];
		$data['sppv_spid'] = $_POST['sppv_spid'];
		$data['sppv_pid'] = $_POST['sppv_pid'];
		$data['sppv_apt'] = $_POST['sppv_apt'];
		$data['sppv_ap'] = $_POST['sppv_ap'];
		$data['sppv_st'] = $_POST['sppv_st'];
		$data['sppv_s'] = $_POST['sppv_s'];
		$data['sppv_sku'] = $_POST['sppv_sku'];
		$data['sppv_t_s'] = $_POST['sppv_t_s'];
		//var_dump($data);exit;
		$m = \app\product\module\ProdSpropval::instance();
		$re = $m -> addOne( $data );
		var_dump($re);exit;
		if( $re[0] == 3 ){
			output( 5, $this -> lang[1] );
		}else{
			output( 4, $this -> lang[2] );
		}
	}
	public function del(){
		$m = \app\article\module\ArtTag::instance();
		$data['t_id'] = req( 0,'id' );
		$re = $m -> delOne( $data['t_id'] );
		//var_dump( $re );
		if( $re ){
			output( 5, '', $re);
		}else{
			output( 4, '', '');
		}
	}

	public function get(){
		$m = \app\article\module\ArtTag::instance();
		$id = req( 0,'id' );
		$re = $m -> getOne( $id );
		if( $re ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}

	public function getAll(){
		$m = \app\article\module\ArtTag::instance();
		$re = $m -> getAll();
		if( $re ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}



}


?>
