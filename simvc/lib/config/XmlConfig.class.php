<?php
namespace PEngine\Libarary\Config;
class XmlConfig extends Config{
    public static $instance = null;
	private static $path = "PEngine/Config/Config.xml";
	private $config = array();
	public function __construct(){
		//echo "config initialize";
		$this -> config = \PEngine\Libarary\Util\XML::parse( file_get_contents(self::$path) );
	}
	public static function instance(){
		if( is_null( self::$instance ) ){
			self::$instance = new self();
		}
		return self::$instance;
	}
	public function get( $key ){
		return empty($this -> config[$key])?null:$this -> config[$key];
	}
	public function set( $key,$value ){
		$this -> config[$key] = $value;
	}
}
?>
