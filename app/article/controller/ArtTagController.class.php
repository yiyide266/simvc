<?php
namespace app\article\controller;
class ArtTagController extends \simvc\lib\controller\C{
	

	public function addPage(){
		$token = sess_token_set( 'app_article_tag_add' );
		$this -> assign( 'token', $token );
		$this -> display();
	}
	public function add(){
		if(!sess_token_check( 'app_article_tag_add', $_POST['form_token'] ) ){
			output( 4, $this -> lang[2] );
		}
		$data['t_name'] = $_POST['t_name'];
		$m = \app\article\module\ArtTag::instance();
		$re = $m -> addOne( $data );
		if( $re[0] == 1 ){
			output( 5, $this -> lang[1] );
		}else{
			output( 4, $this -> lang[2],$re[1] );
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
