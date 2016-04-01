<?php
namespace simvc\lib\module;
abstract class DbInterface{
	public $PDO = null;
	
	abstract public function query( $sql );
	abstract public function exec( $sql );
	abstract public function getRows( $sql );
	abstract public function getRow( $sql );
	abstract public function insert( $sql );
	abstract public function update( $sql );
	abstract public function delete( $sql );
	abstract public function startTrans();
	abstract public function commit();
	abstract public function rollBack();
	abstract public function onError();
	abstract public function log();
}




?>
