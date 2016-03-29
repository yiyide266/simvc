<?php
namespace simvc\lib\controller;
abstract class Controller{
	//supposing each controller have its own propertys
	protected $m_prop;
	//abstract public function getMethodProperty( $method );
	abstract function run( $method );
}


?>
