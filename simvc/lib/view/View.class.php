<?php
namespace simvc\lib\view;
use Exception;
class View{
	
	public $val = array(); 
	
	
	public function __construct(){}
	
	
	public function assgin( $k ,$v ){
		$this -> val[$k] = $v;
	}
	
	
	public function display( $tpl = null ){
		$file = is_null($tpl)?"App/".urlchar_trans(request(0,"app"))."/View/".urlchar_trans(request(0,"controller"))."/".request(0,"action").".php":"App/".urlchar_trans(request(0,"app"))."/View/".$tpl;
		if( !is_file($file) ){
			throw new Exception("View file not exits");
		}else{
			require_once( $file );
		}
	}

}

?>
