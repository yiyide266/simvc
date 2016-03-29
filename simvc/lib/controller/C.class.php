<?php
namespace simvc\lib\controller;
class C extends Controller{
	
	protected $m_prop = array(

	);
	protected $view;

	public function __construct(){
		$this -> view = new \simvc\lib\view\View();
	}

	public function getMethodProperty( $method ){
		return $this -> m_prop[$method];
	}
	//ÊµÏÖ¸¸Ïµ·½·¨
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
