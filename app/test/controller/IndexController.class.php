<?php
namespace app\test\controller;
class IndexController extends \simvc\lib\controller\C{
	protected $m_prop = array(
		'index' => array( true,'text' ),
		'page' => array( false,'text' ),
		'get' => array( true,'json' ),
	);

	public function index(){
		echo '->index';
		echo '<br>';
	}
	public function page(){
		echo '->page';
		echo '<br>';
	}
	public function get(){
		echo '->get';
		echo '<br>';
	}

}


?>
