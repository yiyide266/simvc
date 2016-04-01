<?php
namespace simvc\lib\Session;
abstract class Session{
	public static $instance = null;
	
	
	public static function instance( $type = 0 ){
		if( is_null( self::$instance ) ){
			switch ($type){
				case 0:
					self::$instance = new FileSession();
				break;
			
			}
		}
		return self::$instance;
	}
	
	public function __construct(){
		if(!session_id()) {session_start();}
		//echo "ok";
	}
	
	
	abstract public function get( $key );
	
	abstract public function set( $key, $val );
	
	abstract public function del( $key );

	abstract public function destroy();
}
?>
