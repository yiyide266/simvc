<?php
namespace app\rbac\module;
/**
 * user database touch layer
 * @category   rbac
 * @package  rbac
 * @subpackage  lib.module
 * @author    kimmy
 */
class Users extends \simvc\lib\module\Module{
	/**
	 * declare table name in this module 
	 * @attribute  protected
	 * @type string
	 */
	protected $tab_name = 'users';
	/**
	 * declare this module name
	 * @param  void
	 * @return string
	 */
	public static function who(){
		return __CLASS__;
	}
	/**
	 * call 'insert_user' procedures to insert
	 * @param  array   $data	   db field array
	 * @return array       status
	 *   				   [0]=>
	 *        				0:false(parameter detect false)
	 *        				1:success(bring back last insert id)
	 *        				2:false(insert false,bring back sql status)
	 *   				   [1]=>dependent on [0],last insert id or sql status
	 */
	public function addOne( $data ){
		if( filter_sql_array( $data ) ){ return array(0); }
		$sql = sprintf( 'call insert_user(\'%s\', \'%s\', \'%s\', \'%d\', \'%d\')',_crc32($data['u_account']), $data['u_account'], md5($data['u_pass']), $data['u_pid'], $data['u_t_s']  );
		$re = $this -> getRow( $sql );
		if( in_array($re['status'], array( 1,4 )) ){ return array(1,$re['u_id']); }
		else{ return array(2,$re['status']); }
	}
	
	/**
	 * call 'drop_user' procedures to delete a user include its childs
	 * @param  int  $data    u_id
	 * @return array       status
	 *   				   [0]=>
	 *        				0:false(parameter detect false)
	 *        				1:success(bring back effect row count)
	 *        				2:false(excute false,bring back sql status)
	 *   				   [1]=>dependent on [0],effect row count or sql status
	 */
	public function delOne( $data ){
		if( filter_sql( $data ) ){ return array(0); }
		$sql = sprintf( 'call drop_user( \'%d\' )',$data  );
		$re = $this -> getRow( $sql );
		if( $re['status'] == 2 ){ return array(1,$re['effect']); }
		else{ return array(2,$re['status']); }
	}
	
	/**
	 * get a user return it
	 * @param  int   $data   u_id
	 * @return mixed       return user row or false when row is not exsist
	 */
	public function getOne( $data ){
		$data = intval($data);
		return $this -> where( array( 'u_id' => $data ) ) -> find();
	}
	/**
	 * get a user with u_name
	 * @param  string   $data   u_name
	 * @return mixed       return user row or false when row is not exsist
	 */
	public function getOne_2( $data ){
		$u_account_hash = _crc32($data);
		//var_dump( $u_account_hash );
		return $this -> where( array( 'u_account_hash' => $u_account_hash,'u_account' => $data ) ) -> find();
	}
	
	/**
	 * pagination
	 * @param  array  	$data    query params
	 * @param  int  	$page    page num
	 * @param  int  	$size    size num
	 * @param  string  	$field   fields sql
	 * @return array       [[int] total row num][[int] total page num][[int] current page num][[int] current size num][[array] rows]
	 */
	public function pagination( $data, $page, $size = 5, $field = '*' ){
		$page = empty($page)?1:$page;
		$size = empty($size)?10:$size;
		$count = $this -> where( $data ) -> count();
		$totalpage = ceil( $count/$size );
		$page = $page<=0?1:($page>$totalpage?$totalpage:$page);
		$offset = ($page-1)*$size;
		$re = $this -> field( $field ) -> where( $data ) -> limit( array($offset,$size) ) -> select();
		return array( $count,$totalpage, $page, $size, $re );
	}

}
?>
