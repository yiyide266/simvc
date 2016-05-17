<?php
namespace app\article\controller;
class ArticleController extends \simvc\lib\controller\C{
	

	public function addPage(){
		$token = sess_token_set( 'app_article_add' );
		$this -> assign( 'token', $token );
		$this -> display();
	}
	public function add(){
		if(!sess_token_check( 'app_article_add', $_POST['form_token'] ) ){
			output( 4, $this -> lang[2] );
		}
		$data['a_title'] = $_POST['a_title'];
		$data['a_content'] = $_POST['a_content'];
		$data['a_pub_time'] = $_POST['a_pub_time'];
		$data['a_pub_dpt'] = $_POST['a_pub_dpt'];
		$data['a_pub_author'] = $_POST['a_pub_author'];
		$data['a_creat_time'] = $_POST['a_creat_time'];
		$data['a_creat_uid'] = $_POST['a_creat_uid'];
		$data['a_update_time'] = $_POST['a_update_time'];
		$data['a_cid'] = $_POST['a_cid'];
		$data['a_sort'] = $_POST['a_sort'];
		$m = \app\article\module\Article::instance();
		$re = $m -> addOne( $data );
		if( $re[0] == 1 ){
			output( 5, $this -> lang[1] );
		}else{
			output( 4, $this -> lang[2],$re[1] );
		}
	}
	public function del(){
		$m = \app\article\module\Article::instance();
		$data['a_id'] = req( 0,'id' );
		$re = $m -> delOne( $data['a_id'] );
		if( in_array($re[0], array(1))){
			output( 5, '', $re[1]);
		}else{
			output( 4, '', $re[1]);
		}
	}

	public function get(){
		$m = \app\article\module\Article::instance();
		$id = req( 0,'id' );
		$re = $m -> getOne( $id );
		if( $re ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}

	public function pagina(){
		$m = \app\article\module\Article::instance();
		$re = $m -> pagination( array(), req( 0,'p' ) );
		if( $re ){
			output( 5, '', $re);
		}else{
			output( 4, '' );
		}
	}



}


?>
