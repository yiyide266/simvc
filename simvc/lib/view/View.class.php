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
		$file = is_null($tpl)?_APP_.'/'.req(0,"a")."/view/".req(0,"c")."/".req(0,"m").".php":_APP_.'/'.req(0,"a")."/view/".$tpl;
		//var_dump($file);exit;
		if( !is_file($file) ){
			throw new Exception("View file not exits");
		}else{
			require_once( $file );
		}
	}

}

?>
