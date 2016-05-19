<?php
namespace app\product\module;
/**
 * prodSpropval database touch layer
 * @category   rbac
 * @package  rbac
 * @subpackage  lib.module
 * @author    kimmy
 */
class ProdSpropval extends \simvc\lib\module\Module{
	/**
	 * declare table name in this module 
	 * @attribute  protected
	 * @type string
	 */
	protected $tab_name = 'prod_spropval';
	/**
	 * declare parameter filter
	 * @attribute  protected
	 * @type array
	 */
	protected $params_filter = array(
			'sppv_id' => array( '/^[\d]+$/' ),
			'sppv_type' => array( '/^[\d]{1,1}$/' ),
			'sppv_val' => array( '/^[\x{4e00}-\x{9fa5}\w\W]{1,16}$/u' ),
			'sppv_spid' => array( '/^[\d]+$/' ),
			'sppv_pid' => array( '/^[\d]+$/' ),
			'sppv_apt' => array( '/^[\d]{1,1}$/' ),
			'sppv_ap' => array( '/^[\d]+([.]?[\d]+)?$/' ),//only accept integer or decimal
			'sppv_st' => array( '/^[\d]{1,1}$/' ),
			'sppv_s' => array( '/^[\x{4e00}-\x{9fa5}\w\W]{0,255}$/u' ),//this pattern meanning : accept unicode (\x{4e00}-\x{9fa5}) and \w and \W chat between 3 and 16 lenght
			'sppv_sku' => array( '/^[\d]+$/' ),
			'sppv_t_s' => array( '/^[\d]+$/' ),
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
		$re = $this -> filter( array( 'sppv_type', 'sppv_val', 'sppv_spid', 'sppv_pid', 'sppv_apt', 'sppv_ap', 'sppv_st', 'sppv_s', 'sppv_sku', 'sppv_t_s' ), $data );
		if( $re[0]!=3 ){ return $re[0]==0?array(0):array(0, $re[1]); }
		$this -> startTrans();
		$sprop_m = \app\product\module\ProdSprop::instance();
		//father node of sprop must be exists
		$sprop_1 = $sprop_m -> getOne( $data['sppv_spid'] );
		if( empty($sprop_1) ){ return array(1); }
		//lock up when this sprop has its childs
		$sprop_2 = $sprop_m -> where( array( 'spp_pid' => $sprop_1['spp_pid'], 'spp_fid' => $sprop_1['spp_id'] ) ) -> find();
		if( !empty($sprop_2) ){ return array(2); }

		if( $sprop_1['spp_fid'] != 0 ){
			//
			$sprop_vals = $this -> where( array( 'sppv_spid' => $sprop_1['spp_fid'] ) ) -> select();
			//var_dump( $sprop_vals );exit;
			$insert_arr = array( 0 => array( 'sppv_type','sppv_val','sppv_spid','sppv_pid','sppv_apt','sppv_ap','sppv_st','sppv_s','sppv_sku','sppv_t_s' ) );
			foreach ($sprop_vals as $k => $v) {
				$insert_arr[1][$k][] = $data['sppv_type'];
				$insert_arr[1][$k][] = $data['sppv_val'];
				$insert_arr[1][$k][] = $data['sppv_spid'];
				$insert_arr[1][$k][] = $v['sppv_id'];
				$insert_arr[1][$k][] = $data['sppv_apt'];
				$insert_arr[1][$k][] = $data['sppv_ap'];
				$insert_arr[1][$k][] = $data['sppv_st'];
				$insert_arr[1][$k][] = $data['sppv_s'];
				$insert_arr[1][$k][] = $data['sppv_sku'];
				$insert_arr[1][$k][] = $data['sppv_t_s'];
			}
			$re = $this -> add( $insert_arr, 1 );
			//var_dump( $this -> db -> getLastSql() );

		}else{
			//var_dump($re);
			//if( $re[0]!=3 ){ return $re[0]==0?array(0):array(0, $re[1]); }
			$re = $this -> add( $data );
		}
		var_dump( $this -> db -> getLastSql() );
		if( $re ){
			$this -> commit();
			return array(3,$re);
		}else{
			$this -> rollBack();
			return array(4);
		}
	}
	/**
	 * delete a sprop
	 * @param  int   $data   r_id
	 * @return array       return effect row count
	 */
	public function delOne( $data ){
		$data = intval($data);
		return $this -> where(array( 'spp_id' => $data ) ) -> delete();
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
