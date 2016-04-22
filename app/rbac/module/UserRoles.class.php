<?php
namespace app\rbac\module;
/**
 * UserRoles database touch layer
 * @category   rbac
 * @package  rbac
 * @subpackage  lib.module
 * @author    kimmy
 */
class UserRoles extends \simvc\lib\module\Module{
	/**
	 * declare table name in this module 
	 * @attribute  protected
	 * @type string
	 */
	protected $tab_name = 'user_roles';
	/**
	 * declare this module name
	 * @param  void
	 * @return string
	 */
	public static function who(){
		return __CLASS__;
	}
	/**
	 * insert a user_role
	 * @param  array   $data	   db field array
	 * @return array       status
	 *   				   [0]=>
	 *        				0:false(parameter detect false)
	 *        				1:false(duplicate row)
	 *        				2:success(bring back last insert id)
	 *        				3:false(insert false,bring back sql status)
	 *   				   [1]=>dependent on [0],last insert id or sql status
	 */
	public function addOne( $data ){
		if( filter_sql_array( $data ) ){ return array(0); }
		if( $this -> getOne( $data ) ){ return array(1); }
		$instId = $this -> add( $data );
		if($instId){
			return array(2,$instId);
		}else{
			return array(3);
		}
	}
	
	/**
	 * delete a user_role
	 * @param  int  $data    n_id
	 * @return int     effect row count
	 */
	public function delOne( $data ){
		return $this -> where( $data ) -> delete();
	}
	public function delMulti( $data ){}
	/**
	 * get a user_role return it
	 * @param  array   $data   query params
	 * @return mixed       return node row or false when row is not exsist
	 */
	public function getOne( $data ){
		return $this -> where( $data ) -> find();
	}
	public function getMulti( $data ){}
	

}
?>
