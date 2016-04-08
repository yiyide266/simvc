<?php
namespace simvc\lib\config;
abstract class Config{
    protected static $instance = null;
    protected $config = array();
    
    abstract public function get( $key );
    abstract public function set( $key,$value );
    abstract public function merge( $conf );
}
?>
