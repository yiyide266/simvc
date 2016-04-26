<?php
namespace app\rbac\module;
/**
 * Roles database touch layer
 * @category   rbac
 * @package  rbac
 * @subpackage  lib.module
 * @author    kimmy
 */
class Roles extends \simvc\lib\module\Module{
	/**
	 * declare table name in this module 
	 * @attribute  protected
	 * @type string
	 */
	protected $tab_name = 'roles';
	/**
	 * declare parameter filter
	 * @attribute  protected
	 * @type array
	 */
	protected $params_filter = array(
		'r_name' => array( '/.+/' ),
		'r_des' => array( '/.+/' ),
		);
	/**
	 * declare this module name
	 * @param  void
	 * @return string
	 */
	public static function who(){
		return __CLASS__;
	}
	/**
	 * insert 
	 * @param  array   $data	   db field array
	 * @return array       status
	 *   				   [0]=>
	 *        				0:false(parameter detect false)
	 *        				1:false(r_name detect false)
	 *        				2:success(bring back last insert id)
	 *        				3:false(insert false)
	 *   				   [1]=>dependent on [0],last insert id or unset
	 */
	public function addOne( $data ){
		$filter = $this -> filter( array( 'r_name','r_des' ), $data );
		if( $filter[0] != 3 ){ return array(0,$filter); }
		//if( filter_sql_array( $data ) ){ return array(0); }
		if( empty( $data['r_name'] ) ){ return array(1); }
		$instId = $this -> add( $data );
		if($instId){
			return array(2,$instId);
		}else{
			return array(3);
		}
	}
	
	/**
	 * delete a role
	 * @param  int   $data   r_id
	 * @return array       return effect row count
	 */
	public function delOne( $data ){
		$data = intval($data);
		return $this -> where(array( 'r_id' => $data ) ) -> delete();
	}
	
	/**
	 * get a role return it
	 * @param  int   $data   n_id
	 * @return mixed       return node row or false when row is not exsist
	 */
	public function getOne( $data ){
		$data = intval($data);
		return $this -> where( array( 'r_id' => $data ) ) -> find();
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
