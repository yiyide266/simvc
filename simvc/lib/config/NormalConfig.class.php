<?php
namespace simvc\lib\config;
class NormalConfig extends Config{

    private static $path = "simvc/conf/global.php";
	public static function instance(){
		if( is_null( self::$instance ) ){
			self::$instance = new self();
		}
		return self::$instance;
	}
	public function __construct(){
		//echo "config initialize<br>";
		$this -> config =  include(  _DIR_.'/'.self::$path  );
		//var_dump( $this -> config );
	}
	
	public function get( $key ){
		return !isset($this -> config[$key])?null:$this -> config[$key];
	}
	public function set( $key,$value ){
		$this -> config[$key] = $value;
	}
	public function merge( $conf ){
		$this -> config = array_merge_recursive ( $this -> config ,  $conf );
	}
}
?>
