<?php
namespace app\article\controller;
class ArtTagLinkController extends \simvc\lib\controller\C{
	

	public function addPage(){
		$token = sess_token_set( 'app_article_taglink_add' );
		$this -> assign( 'token', $token );
		$this -> display();
	}
	public function add(){
		if(!sess_token_check( 'app_article_taglink_add', $_POST['form_token'] ) ){
			output( 4, $this -> lang[2] );
		}
		$data['t_id'] = $_POST['t_id'];
		$data['a_id'] = $_POST['a_id'];
		$m = \app\article\module\ArtTagLink::instance();
		$re = $m -> addOne( $data );
		if( $re[0] == 1 ){
			output( 5, $this -> lang[1] );
		}else{
			output( 4, $this -> lang[2],$re[1] );
		}
	}
	public function del(){
		$m = \app\article\module\ArtTagLink::instance();
		$data['tl_id'] = req( 0,'id' );
		$re = $m -> delOne( $data['tl_id'] );
		//var_dump( $re );
		if( $re ){
			output( 5, '', $re);
		}else{
			output( 4, '', '');
		}
	}

	public function get(){
		$m = \app\article\module\ArtTagLink::instance();
		$id = req( 0,'id' );
		$re = $m -> getOne( $id );
		if( $re ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}

	public function getAll(){
		$m = \app\article\module\ArtTagLink::instance();
		$re = $m -> getAll();
		if( $re ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}



}


?>
