<?php
namespace app\article\module;
/**
 * Article database touch layer
 * @category   rbac
 * @package  rbac
 * @subpackage  lib.module
 * @author    kimmy
 */
class Article extends \simvc\lib\module\Module{
	/**
	 * declare table name in this module 
	 * @attribute  protected
	 * @type string
	 */
	protected $tab_name = 'article';
	/**
	 * declare parameter filter
	 * @attribute  protected
	 * @type array
	 */
	protected $params_filter = array(
			'a_id' => array( '/^[\d]+$/' ),
			'a_title' => array( '/^[\x{4e00}-\x{9fa5}\w\W]{3,16}$/u' ),//this pattern meanning : accept unicode (\x{4e00}-\x{9fa5}) and \w and \W chat between 3 and 16 lenght
			'a_pub_time' => array( '/^[\d]+$/' ),
			'a_pub_dpt' => array( '/^[\x{4e00}-\x{9fa5}\w\W]{3,16}$/u' ),
			'a_pub_author' => array( '/^[\x{4e00}-\x{9fa5}\w\W]{3,16}$/u' ),
			'a_creat_time' => array( '/^[\d]+$/' ),
			'a_creat_uid' => array( '/^[\d]+$/' ),
			'a_update_time' => array( '/^[\d]+$/' ),
			'a_cid' => array( '/^[\d]+$/' ),
			'a_sort' => array( '/^[\d]+$/' ),
			'a_click' => array( '/^[\d]+$/' ),
			'a_comment_count' => array( '/^[\d]+$/' ),
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
	 * insert an aticle
	 * @param  array   $data	   db field array
	 * @return array       status
	 *   				   [0]=>
	 *        				0:false(parameter detect false)
	 *        				1:success(bring back last insert id)
	 *        				2:false(insert false,bring back void)
	 *   				   [1]=>dependent on [0],last insert id or void
	 */
	public function addOne( $data ){
		$re = $this -> filter( array( 'a_title','a_content','a_pub_time','a_pub_dpt','a_pub_author','a_creat_time','a_creat_uid','a_update_time','a_cid','a_sort' ), $data );
		if( $re[0]!=3 ){ return $re[0]==0?array(0):array(0, $re[1]); }
		$re = $this -> add( $data );
		return $re?array(1,$re):array(2);
	}
	/**
	 * delete an aticle
	 * @param  int   $data   r_id
	 * @return array       return effect row count
	 */
	public function delOne( $data ){
		$data = intval($data);
		return $this -> where(array( 'a_id' => $data ) ) -> delete();
	}
	/**
	 * delete aticle by multiple
	 * @param  int   $data   r_id
	 * @return array       return effect row count
	 */
	public function delMulti( $data ){
		if( filter_sql_array( $data ) ){ return array(0); }
		return $this -> where(array( 'a_id' => array( 'in', explode_quo( $data, false ) ) ) ) -> delete();
	}
	/**
	 * get an aticle return it
	 * @param  int   $data   n_id
	 * @return mixed       return node row or false when row is not exsist
	 */
	public function getOne( $data ){
		$data = intval($data);
		return $this -> where( array( 'a_id' => $data ) ) -> find();
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
