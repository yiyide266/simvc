<?php
namespace app\article\controller;
class ArtCommentController extends \simvc\lib\controller\C{
	

	public function addPage(){
		$token = sess_token_set( 'app_article_comment_add' );
		$this -> assign( 'token', $token );
		$this -> display();
	}
	public function add(){
		if(!sess_token_check( 'app_article_comment_add', $_POST['form_token'] ) ){
			output( 4, $this -> lang[2] );
		}
		$data['c_aid'] = $_POST['c_aid'];
		$data['c_uid'] = $_POST['c_uid'];
		$data['c_content'] = $_POST['c_content'];
		$data['c_comment_time'] = $_POST['c_comment_time'];
		$data['c_status'] = $_POST['c_status'];
		$data['c_pid'] = $_POST['c_pid'];
		$data['c_t_s'] = $_POST['c_t_s'];
		$m = \app\article\module\ArtComment::instance();
		$re = $m -> addOne( $data );
		if( $re[0] == 1 ){
			output( 5, $this -> lang[1] );
		}else{
			output( 4, $this -> lang[2],$re[1] );
		}
	}
	public function del(){
		$m = \app\article\module\ArtComment::instance();
		$data['c_id'] = req( 0,'id' );
		$re = $m -> delOne( $data );
		//var_dump( $re );
		if( in_array($re[0], array(1))){
			output( 5, '', $re[1]);
		}else{
			output( 4, '', $re[1]);
		}
	}

	public function get(){
		$m = \app\article\module\ArtComment::instance();
		$id = req( 0,'id' );
		$re = $m -> getOne( $id );
		if( $re ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}

	public function getAll(){
		$m = \app\article\module\ArtComment::instance();
		$re = $m -> getAll();
		if( $re ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}



}


?>
