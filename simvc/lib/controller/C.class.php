<?php
namespace simvc\lib\controller;
class C extends Controller{
	
	protected $m_prop = array(

	);
	protected $view;
	public $lang;

	public function __construct(){
		$this -> view = new \simvc\lib\view\View();
		$file = _APP_.'/'.req(0,'a').'/lang/'.req(0,'l').'.php';
		$this -> lang = include( $file );
	}

	public function getMethodProperty( $method ){
		if( isset($this -> m_prop[$method]) ){
			return $this -> m_prop[$method];
		}else{
			return array( false,'text' );
		}
	}
	//¨º¦Ì?????¦Ì¡¤?¡¤¡§
	public function run( $method ){
		if( method_exists( $this , $method ) ){
			$this -> $method();
		}else{
			throw new Exception("no such method");
		}
	}

	public function assign( $k, $v ){
		$this -> view -> assign( $k, $v );
	}

	public function display(){
		$this -> view -> display();
	}
}

?>
