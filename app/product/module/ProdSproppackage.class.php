<?php
namespace app\product\module;
/**
 * prodSproppackage database touch layer
 * @category   rbac
 * @package  rbac
 * @subpackage  lib.module
 * @author    kimmy
 */
class ProdSproppackage extends \simvc\lib\module\Module{
	/**
	 * declare table name in this module 
	 * @attribute  protected
	 * @type string
	 */
	protected $tab_name = 'prod_sproppackage';
	/**
	 * declare parameter filter
	 * @attribute  protected
	 * @type array
	 */
	protected $params_filter = array(
			'sppp_id' => array( '/^[\d]+$/' ),
			'sppp_type' => array( '/^[\d]+$/' ),
			'sppp_name' => array( '/^[\x{4e00}-\x{9fa5}\w\W]{1,16}$/u' ),//this pattern meanning : accept unicode (\x{4e00}-\x{9fa5}) and \w and \W chat between 3 and 16 lenght
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
	 *        				1:success(bring back last insert id)
	 *        				2:false(insert false,bring back void)
	 *   				   [1]=>dependent on [0],last insert id or void
	 */
	public function addOne( $data ){
		$re = $this -> filter( array( 'sppp_type', 'sppp_name' ), $data );
		//var_dump($re);
		if( $re[0]!=3 ){ return $re[0]==0?array(0):array(0, $re[1]); }
		$re = $this -> add( $data );
		return $re?array(1,$re):array(2);
	}
	/**
	 * delete a sproppackage
	 * @param  int   $data   r_id
	 * @return array       return effect row count
	 */
	public function delOne( $data ){
		$data = intval($data);
		return $this -> where(array( 'sppp_id' => $data ) ) -> delete();
	}
	/**
	 * get a sproppackage return it
	 * @param  int   $data   n_id
	 * @return mixed       return node row or false when row is not exsist
	 */
	public function getOne( $data ){
		$data = intval($data);
		return $this -> where( array( 'sppp_id' => $data ) ) -> find();
	}
	/**
	 * get all sproppackage return it
	 * @param  int   $data   n_id
	 * @return mixed       return node row or false when row is not exsist
	 */
	public function getAll(){
		return $this -> select();
	}
}
?>
