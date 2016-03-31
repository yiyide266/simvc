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
		echo 'sdfdfgdfgfdgfdg';
		echo _PURL_;
		/*$a = 1;
		foreach ($a as $key => $value) {
			echo $value;
		}*/
		throw new \Exception("Error Processing Request111", 1);
		$this -> display();
		
	}
	public function page(){
		echo '->page';
		echo '<br>';
	}
	public function get(){
		echo '->get';
		echo '<br>';
		throw new \Exception("Error Processing Request111", 1);
	}
	public function error(){
		
	}

}


?>
