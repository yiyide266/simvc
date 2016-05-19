<?php
namespace app\product\controller;
class ProdSpropController extends \simvc\lib\controller\C{
	

	public function addPage(){
		$token = sess_token_set( 'app_product_sprop_add' );
		$this -> assign( 'token', $token );
		$this -> display();
	}
	public function add(){
		if(!sess_token_check( 'app_product_sprop_add', $_POST['form_token'] ) ){
			output( 4, $this -> lang[2] );
		}
		$data['spp_name'] = $_POST['spp_name'];
		$data['spp_pid'] = $_POST['spp_pid'];
		$data['spp_fid'] = $_POST['spp_fid'];
		$m = \app\product\module\ProdSprop::instance();
		$re = $m -> addOne( $data );
		if( $re[0] == 4 ){
			output( 5, $this -> lang[1] );
		}else{
			output( 4, $this -> lang[2] );
		}
	}
	public function del(){
		$m = \app\product\module\ProdSprop::instance();
		$id = req( 0,'id' );
		$re = $m -> delOne( $id );
		var_dump( $re );
		if( $re[0] == 2 ){
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
