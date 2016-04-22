<?php
namespace app\rbac\module;
/**
 * Cnode database touch layer
 * @category   rbac
 * @package  rbac
 * @subpackage  lib.module
 * @author    kimmy
 */
class Cnode extends \simvc\lib\module\Module{
	/**
	 * declare table name in this module 
	 * @attribute  protected
	 * @type string
	 */
	protected $tab_name = 'cnode';
	/**
	 * declare this module name
	 * @param  void
	 * @return string
	 */
	public static function who(){
		return __CLASS__;
	}
	/**
	 * call 'insert_cnode' procedures to insert
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
		$sql = sprintf( 'call insert_cnode(\'%s\', \'%s\', \'%s\', \'%d\', \'%d\', \'%d\')',$data['n_name'], $data['n_spec'], $data['n_icon'], $data['n_type'], $data['n_pid'], $data['n_t_s']  );
		$re = $this -> getRow( $sql );
		if( in_array($re['status'], array( 1,5 )) ){ return array(1,$re['n_id']); }
		else{ return array(2,$re['status']); }
	}
	
	/**
	 * call 'drop_cnode' procedures to delete a node include its childs
	 * @param  string  $data    n_id
	 * @return array       status
	 *   				   [0]=>
	 *        				0:false(parameter detect false)
	 *        				1:success(bring back effect row count)
	 *        				2:false(excute false,bring back sql status)
	 *   				   [1]=>dependent on [0],effect row count or sql status
	 */
	public function delOne( $data ){
		if( filter_sql( $data ) ){ return array(0); }
		$sql = sprintf( 'call drop_cnode( \'%d\' )',$data  );
		$re = $this -> getRow( $sql );
		if( $re['status'] == 2 ){ return array(1,$re['effect']); }
		else{ return array(2,$re['status']); }
	}
	public function delMulti( $data ){}
	/**
	 * get a node return it
	 * @param  int   $data   n_id
	 * @return mixed       return node row or false when row is not exsist
	 */
	public function getOne( $data ){
		$data = intval($data);
		return $this -> where( array( 'n_id' => $data ) ) -> find();
	}
	public function getMulti( $data ){}
	/**
	 * get a node return it and its all childs
	 * @param  int  	$data    n_id
	 * @return mixed       return  node rows or false when row is not exsist
	 */
	public function getChilds( $data ){
		$re = $this -> getOne( $data );
		if( $re && ($re['n_t_r_r']-$re['n_t_r_l']) != 1 ){
			$re = $this -> where( array( 'n_t_f' =>$re['n_t_f'], 'n_t_r_l' => array( 'gt', ($re['n_t_r_l']-1) ), 'n_t_r_r' => array( 'lt', $re['n_t_r_r']+2 ) ) ) -> select();
			return $re;
		}else{
			if( $re == false ){
				return false;
			}else{
				return array($re);
			}
		}
	}
	/**
	 * get a node return it and its all childs with out getOne
	 * @param  int  	$data    n_id
	 * @return mixed       return  node rows or false when row is not exsist
	 */
	public function getChilds_2( $data ){
		if( $data['n_t_r_r']-$data['n_t_r_l'] != 1 ){
			$re = $this -> where( array( 'n_t_f' =>$data['n_t_f'], 'n_t_r_l' => array( 'gt', ($data['n_t_r_l']-1) ), 'n_t_r_r' => array( 'lt', $data['n_t_r_r']+2 ) ) ) -> select();
			return $re;
		}else{
			return array($data);
		}
	}
	/**
	 * get a node pid route path consist of its father's n_id
	 * @param  int  	$data    n_id
	 * @return mixed       route path or false when row is not exsist
	 */
	public function getFathers( $data, $fa=array() ){
		$cat = $this -> getOne( $data );
		if( $cat ){
			//var_dump($cat);
			if($cat['n_pid']!=0){
				$fa[] = $cat['n_pid'];
				return $this -> getFathers($cat['n_pid'], $fa);
			}else{
				return $fa;
			}
		}else{
			return false;
		}
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
