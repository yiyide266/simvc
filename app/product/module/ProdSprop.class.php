<?php
namespace app\product\module;
/**
 * prodSprop database touch layer
 * @category   rbac
 * @package  rbac
 * @subpackage  lib.module
 * @author    kimmy
 */
class ProdSprop extends \simvc\lib\module\Module{
	/**
	 * declare table name in this module 
	 * @attribute  protected
	 * @type string
	 */
	protected $tab_name = 'prod_sprop';
	/**
	 * declare parameter filter
	 * @attribute  protected
	 * @type array
	 */
	protected $params_filter = array(
			'spp_id' => array( '/^[\d]+$/' ),
			'spp_name' => array( '/^[\x{4e00}-\x{9fa5}\w\W]{1,16}$/u' ),//this pattern meanning : accept unicode (\x{4e00}-\x{9fa5}) and \w and \W chat between 3 and 16 lenght
			'spp_pid' => array( '/^[\d]+$/' ),
			'spp_fid' => array( '/^[\d]+$/' ),
			'spp_t_s' => array( '/^[\d]+$/' ),
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
		$re = $this -> filter( array( 'spp_name', 'spp_pid', 'spp_fid' ), $data );

		//var_dump($re);
		if( $re[0]!=3 ){ return $re[0]==0?array(0):array(0, $re[1]); }
		//father node must be exists
		if( $data['spp_fid'] != 0 ){
			$sprop = $this -> where( array( 'spp_id' => $data['spp_fid'] ) ) -> find();
			if( empty($sprop) ){ return array(1); }
			//only current father node have no spropval can append node
			$spropval_m = \app\product\module\ProdSpropval::instance();
			$spropvals = $spropval_m -> where( array( 'sppv_spid' => $data['spp_fid'] ) ) -> find();
			if( empty($spropvals) ){ return array(2); }
		}
		$sprop = $this -> where( array( 'spp_pid' => $data['spp_pid'], 'spp_fid' => $data['spp_fid'] ) ) -> find();
		if( !empty($sprop) ){ return array(3); }
		$re = $this -> add( $data );
		return $re?array(4,$re):array(5);
	}
	/**
	 * delete a sprop
	 * @param  int   $data   r_id
	 * @return array       return effect row count
	 */
	public function delOne( $data ){
		$data = intval($data);
		$re = $this -> where( array( 'spp_fid' => $data ) ) -> find();
		if( !empty( $re ) ){ return array(0); }
		$spropval_m = \app\product\module\ProdSpropval::instance();
		$spropvals = $spropval_m -> where( array( 'sppv_spid' => $data ) ) -> find();
		if( !empty($spropvals) ){ return array(1); }
		$re = $this -> where(array( 'spp_id' => $data ) ) -> delete();
		return array(2,$re);
	}
	/**
	 * get a sprop return it
	 * @param  int   $data   n_id
	 * @return mixed       return node row or false when row is not exsist
	 */
	public function getOne( $data ){
		$data = intval($data);
		return $this -> where( array( 'spp_id' => $data ) ) -> find();
	}
	/**
	 * get all sprop return it
	 * @param  int   $data   n_id
	 * @return mixed       return node row or false when row is not exsist
	 */
	public function getAll(){
		return $this -> select();
	}
}
?>
