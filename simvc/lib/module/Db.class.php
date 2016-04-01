<?php
namespace simvc\lib\module;
class Db{
	private static $instance = array();
	
	public static function instance( $db , $dsn ){
		//var_dump(self::$instance);
		if( !isset(self::$instance[$db]) ){
			$dbm = "\\simvc\\lib\\module\\".$db;
			self::$instance[$db] = new $dbm( $dsn );
		}
		return self::$instance[$db];
	}
	
	public static function init(){
		self::$instance = array();
	}
}

?>
