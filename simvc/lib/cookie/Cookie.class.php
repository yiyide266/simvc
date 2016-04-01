<?php
namespace simvc\lib\cookie;
class Cookie{
	public static $instance = null;
	
	public static function instance(){
		if( is_null( self::$instance ) ){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public static function get( $name ){
		return $_COOKIE[$name];
	}
	
	public static function set( $name, $value, $expire, $path = '/' ){
		setcookie($name, $value, time()+$expire, $path );
	}

	public static function del( $name, $path = '/'  ){
		setcookie($name, '', time()-3600, $path);
	}
}
