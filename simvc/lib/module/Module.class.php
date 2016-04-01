<?php
namespace simvc\lib\module;
abstract class Module{
	protected $db;
	protected $filter = array();
	protected $tab_name;
	
	/*Óï¾ä½âÎö*/
	protected $lastSql;
	protected $condition;
	protected $symbol = array(
				'eq' => '=',
				'neq' => '<>',
				'gt' => '>',
				'egt' => '>=',
				'lt' => '<',
				'elt' => '<=',
				'like' => 'LIKE',
				'between' => 'BETWEEN',
				'not between' => 'NOT BETWEEN',
				'in' => 'IN',
				'not in' => 'NOT IN',
			);
	/*protected $where;
	protected $order;
	protected $limit;
	protected $field;
	protected $alias;
	protected $join;
	protected $group;
	protected $having;*/

	abstract public function addOne( $data );
	abstract public function addMulti( $data );
	abstract public function alterOne( $data );
	abstract public function alterMulti( $data );
	abstract public function delOne( $data );
	abstract public function delMulti( $data );
	abstract public function getOne( $data );
	abstract public function getMulti( $data );
	
	public function __construct( ){
		$this -> db = Db::instance('Mysql' , array( 'dsn' => 'mysql:host='.conf( 'sys_db_host' ).';dbname='.conf( 'sys_db_name' ), 'user' => conf( 'sys_db_user' ) , 'pass' => conf( 'sys_db_pass' ) , 'charset' => conf( 'sys_db_charset' ) ));
	}
	
	/*·â×°Óï¾ä*/
	public function where( $data ){
		$this -> condition['where'] = '';
		if(empty($data)){ 
			return $this; 
		}
		$sql = 'WHERE ';
		if( is_array( $data ) ){
			//$data_off = count( $data ) - 1;
			foreach( $data as $k => $v ){
				if( is_array($v) ){
					if( strtolower($v[0]) == 'between' ){
						$sql .= '`'.$k.'` BETWEEN \''.$v[1][0].'\' AND \''.$v[1][1].'\'';
					}elseif( strtolower($v[0]) == 'in' ){
						$sql .= '`'.$k.'` IN ('.$v[1].')';
					}else{
						$sql .= '`'.$k.'` '.$this -> symbol[strtolower($v[0])].' \''.$v[1].'\'';
					}
				}else{
					$sql .= '`'.$k.'` ='.' \''.$v.'\'';
				}
				$sql .= ' AND ';
			}
			$sql = substr( $sql, 0, -5 );
		}else{
			$sql .= $data;
		}
		//return $sql;
		//var_dump($sql);
		$this -> condition['where'] = $sql;
		return $this;
	}
	public function order( $arr ){
		$this -> condition['order'] = '';
		$sql = 'ORDER BY';
		if( is_array( $data ) ){
			foreach( $data as $k => $v ){
				$sql .= ' `'.$k.'` '.strtoupper($v).',';
			}
			$sql = substr( $sql, 0, -1 );
		}else{
			$sql .= ' '.$data;
		}
		//return $sql;
		$this -> condition['order'] = $sql;
		return $this;
	}
	public function limit( $data ){
		$this -> condition['limit'] = '';
		$sql = 'LIMIT ';
		if( is_array( $data ) ){
			$sql .= $data[0].','.$data[1];
		}else{
			$sql .= $data;
		}
		//return $sql;
		$this -> condition['limit'] = $sql;
		return $this;
	}
	public function field( $data ){
		$sql = '';
		if( is_array( $data ) ){
			foreach( $data as $k => $v ){
				$sql .= '`'.$v.'`,';
			}
			$sql = substr( $sql, 0, -1 );
		}else{
			$sql .= $data;
		}
		//return $sql;
		$this -> condition['field'] = $sql;
		return $this;
	}
	
	public function assem_insert( $data ){
		$data_key = '';
		$data_val = '';
		foreach( $data as $k => $v ){
			$data_key .= '`'.$k.'`,';
			$data_val .= '\''.$v.'\',';
		}
		$data_key = substr( $data_key, 0, -1 );
		$data_val = substr( $data_val, 0, -1 );
		$sql = 'INSERT INTO `'.$this -> tab_name.'` ('.$data_key.')VALUES('.$data_val.')';
		return $sql;
	}
	
	public function assem_update( $data ){
		$sql = 'UPDATE `'.$this -> tab_name.'` SET ';
		//var_dump($data);
		if( is_array( $data ) ){
			foreach( $data as $k => $v ){
				$sql .= '`'.$k.'` ='.' \''.$v.'\', ';
			}
			$sql = substr( $sql, 0, -2 );
		}else{
			$sql .= $data;
		}
		$sql .= isset( $this -> condition['where'] )?' '.$this -> condition['where']:'';
		$this -> cond_reset();
		return $sql;
	}
	
	public function assem_setInc( $data ){
		$sql = 'UPDATE `'.$this -> tab_name.'` SET ';
		//var_dump($data);
		if( is_array( $data ) ){
			foreach( $data as $k => $v ){
				$symbol = $v>0?'+':'-';
				$sql .= '`'.$k.'` = `'.$k.'` '.$symbol.'  \''.abs($v).'\', ';
			}
			$sql = substr( $sql, 0, -2 );
		}else{
			$sql .= $data;
		}
		$sql .= isset( $this -> condition['where'] )?' '.$this -> condition['where']:'';
		$this -> cond_reset();
		return $sql;
	}
	
	public function assem_select(){
		$sql = 'SELECT';
		$sql .= isset( $this -> condition['field'] )?' '.$this -> condition['field']:' *';
		$sql .= ' FROM `'.$this -> tab_name.'`';
		$sql .= isset( $this -> condition['where'] )?' '.$this -> condition['where']:'';
		$sql .= isset( $this -> condition['order'] )?' '.$this -> condition['order']:'';
		$sql .= isset( $this -> condition['limit'] )?' '.$this -> condition['limit']:'';
		$this -> cond_reset();
		return $sql;
	}
	
	public function assem_delete(){
		$sql = 'DELETE';
		$sql .= ' FROM `'.$this -> tab_name.'`';
		$sql .= isset( $this -> condition['where'] )?' '.$this -> condition['where']:'';
		$sql .= isset( $this -> condition['order'] )?' '.$this -> condition['order']:'';
		$sql .= isset( $this -> condition['limit'] )?' '.$this -> condition['limit']:'';
		$this -> cond_reset();
		return $sql;
	}
	
	public function cond_reset(){
		$this -> condition = array();
	}
	
	/*
	Ð´Èë·½·¨
	*/
	public function add( $data ){
		
		$this -> lastSql = $this -> assem_insert( $data );
		return $this -> db -> insert( $this -> lastSql );
	}
	/*
	ÐÞ¸Ä·½·¨
	*/
	public function update( $data ){
		
		return $this -> db -> run( $this -> assem_update( $data ), 1 );
	}
	/*
	µÝÔö£¨¼õ£©·½·¨
	*/
	public function setInc( $data ){
		
		return $this -> db -> run( $this -> assem_setInc( $data ), 1 );
	}
	
	/*·µ»ØÒ»ÐÐ·½·¨*/
	public function find(){
		$this -> limit( '1' );
		
		return $this -> db -> getRow( $this -> assem_select() );
	}
	/*·µ»Ø¶àÐÐ·½·¨*/
	public function select(){
		
		return $this -> db -> getRows( $this -> assem_select() );
	}
	/*É¾³ý·½·¨*/
	public function delete(){
		
		return $this -> db -> run( $this -> assem_delete(), 1 );
	}
	/*count·½·¨*/
	public function count(){
		$this -> field( 'count(*) AS count' );
		
		$re = $this -> db -> getRow( $this -> assem_select() );
		
		return $re['count'];
	}
	/*Ö´ÐÐÓï¾ä*/
	public function run( $sql , $type = 0 ){
		return $this -> db -> run( $sql , $type );
	}
	/*«@È¡Ò»ÁÐ*/
	public function getRow( $sql ){
		return $this -> db -> getRow( $sql );
	}
	/*«@È¡¶àÁÐ*/
	public function getRows( $sql ){
		return $this -> db -> getRows( $sql );
	}
	
	/*¿ªÆôÊÂÎñ*/
	public function startTrans(){
		$this -> db -> startTrans();
	}
	/*»Ø¹öÊÂÎñ*/
	public function rollBack(){
		$this -> db -> rollBack();
	}
	/*Ìá½»ÊÂÎñ*/
	public function commit(){
		$this -> db -> commit();
	}
	
}



?>
