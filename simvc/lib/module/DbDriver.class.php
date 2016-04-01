<?php
namespace simvc\lib\module;
use PDO;
abstract class DbDriver extends DbInterface{
	protected $lastSql;

	public function __construct( $dsn ){
		try {
			//var_dump($dsn);
			$this -> PDO = new PDO( $dsn["dsn"], $dsn["user"], $dsn["pass"]);
			$this -> PDO -> exec( 'SET NAMES \''.$dsn["charset"].'\'' );
		} catch (PDOException $e) {
			$status['message'] = $e -> getMessage ();
			$status['code'] = $e -> getCode ();
			$status['file'] = $e -> getFile ();
			$status['line'] = $e -> getLine ();
			$status['trace'] = $e -> getTraceAsString ();
			handle_err( 3, $status );
		}
	}
	
	public function run( $sql , $type = 0 ){
		$this -> setLastSql( $sql );
		switch( $type ){
			case 0:
				$ps = $this -> PDO -> query( $sql );
			break;
			case 1:
				$ps = $this -> PDO -> exec( $sql );
			break;
		}
		
		if( $ps!==false ){
			return $ps;
		}else{
			$this -> onError();
		}
	}
	
	public function query( $sql ){
		return $this -> PDO -> query( $sql );
	}
	public function exec( $sql ){
		return $this -> PDO -> exec( $sql );
		
	}
	public function getRows( $sql ){
		$ps = $this -> run( $sql );
		return $ps -> fetchAll( PDO::FETCH_ASSOC );
	}
	public function getRow( $sql ){
		$ps = $this -> run( $sql );
		return $ps -> fetch( PDO::FETCH_ASSOC );
	}
	public function insert( $sql ){
		$ps = $this -> run( $sql , 1 );
		return $this -> PDO -> lastInsertId();
	}
	//·µ»ØÓ°ÏìÐÐÊý
	public function update( $sql ){
		return $this -> run( $sql , 1);
	}
	//·µ»ØÓ°ÏìÐÐÊý
	public function delete( $sql ){
		return $this -> run( $sql , 1);
	}
	public function startTrans(){
		return $this -> PDO -> beginTransaction();
	}
	public function commit(){
		return $this -> PDO -> commit();
	}
	public function rollBack(){
		return $this -> PDO -> rollBack();
	}
	public function inTrans(){
		return $this -> PDO -> inTransaction();
	}
	public function onError(){
		
		$err = $this -> PDO -> errorInfo();
		$status['code'] = $err[0];
		$status['err_code'] = $err[1];
		$status['message'] = $err[2];
		$status['sql'] = $this -> lastSql;
		handle_err( 3, $status );

	}
	public function log(){
	
	}
	
	public function setLastSql( $sql ){
		$this -> lastSql = $sql;
	}
	
	public function getLastSql(){
		return $this -> lastSql;
	}
	
	abstract public function getDbType();
	
}




?>
