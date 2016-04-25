<?php
namespace app\article\controller;
class ArtCategoryController extends \simvc\lib\controller\C{
	

	public function addPage(){
		$token = sess_token_set( 'app_article_user_add' );
		$this -> assign( 'token', $token );
		$this -> display();
	}
	public function add(){
		if(!sess_token_check( 'app_article_user_add', $_POST['form_token'] ) ){
			output( 4, $this -> lang[2] );
		}
		$data['c_name'] = $_POST['c_name'];
		$data['c_spec'] = $_POST['c_spec'];
		$data['c_type'] = $_POST['c_type'];
		$data['c_pid'] = $_POST['c_pid'];
		$data['c_t_s'] = $_POST['c_t_s'];
		$m = \app\article\module\ArtCategory::instance();
		$re = $m -> addOne( $data );
		if( $re[0] == 1 ){
			output( 5, $this -> lang[1] );
		}else{
			output( 4, $this -> lang[2],$re[1] );
		}
	}
	public function del(){
		$m = \app\article\module\ArtCategory::instance();
		$data['c_id'] = req( 0,'id' );
		$re = $m -> delOne( $data );
		if( in_array($re[0], array(1))){
			output( 5, '', $re[1]);
		}else{
			output( 4, '', $re[1]);
		}
	}

	public function get(){
		$m = \app\article\module\ArtCategory::instance();
		$id = req( 0,'id' );
		$re = $m -> getOne( $id );
		if( $re ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}

	public function getAll(){
		$m = \app\article\module\ArtCategory::instance();
		$re = $m -> getAll();
		if( $re ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}



}


?>
