<?php
namespace app\article\module;
/**
 * ArtComment database touch layer
 * @category   rbac
 * @package  rbac
 * @subpackage  lib.module
 * @author    kimmy
 */
class ArtComment extends \simvc\lib\module\Module{
	/**
	 * declare table name in this module 
	 * @attribute  protected
	 * @type string
	 */
	protected $tab_name = 'art_comment';
	/**
	 * declare parameter filter
	 * @attribute  protected
	 * @type array
	 */
	protected $params_filter = array(
			'c_id' => array( '/^[\d]+$/' ),
			'c_aid' => array( '/^[\d]+$/' ),
			'c_uid' => array( '/^[\d]+$/' ),
			'c_content' => array( '/^[\x{4e00}-\x{9fa5}\w\W]{1,512}$/u' ),//this pattern meanning : accept unicode (\x{4e00}-\x{9fa5}) and \w and \W chat between 1 and 512 lenght
			'c_comment_time' => array( '/^[\d]+$/' ),
			'c_status' => array( '/^[\d]+$/' ),
			'c_agree' => array( '/^[\d]+$/' ),
			'c_disagree' => array( '/^[\d]+$/' ),
			'c_pid' => array( '/^[\d]+$/' ),
			'c_t_s' => array( '/^[\d]+$/' ),
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
	 * call 'insert_art_comment' procedures to insert
	 * @param  array   $data	   db field array
	 * @return array       status
	 *   				   [0]=>
	 *        				0:false(parameter detect false)
	 *        				1:success(bring back last insert id)
	 *        				2:false(insert false,bring back sql status)
	 *   				   [1]=>dependent on [0],last insert id or sql status
	 */
	public function addOne( $data ){
		$re = $this -> filter( array( 'c_aid', 'c_uid', 'c_content', 'c_comment_time', 'c_status', 'c_pid', 'c_t_s' ), $data );
		//var_dump($re);
		if( $re[0]!=3 ){ return $re[0]==0?array(0):array(0, $re[1]); }
		//if( filter_sql_array( $data ) ){ return array(0); }
		$sql = sprintf( 'call insert_art_comment(\'%d\', \'%d\', \'%s\', \'%d\', \'%d\', \'%d\', \'%d\')',$data['c_aid'], $data['c_uid'], $data['c_content'], $data['c_comment_time'], $data['c_status'], $data['c_pid'], $data['c_t_s'] );
		$re = $this -> getRow( $sql );
		if( in_array($re['status'], array( 1,4 )) ){ return array(1,$re['c_id']); }
		else{ return array(2,$re['status']); }
	}
	/**
	 * call 'drop_art_category' procedures to delete a node include its childs
	 * @param  string  $data    n_id
	 * @return array       status
	 *   				   [0]=>
	 *        				0:false(parameter detect false)
	 *        				1:success(bring back effect row count)
	 *        				2:false(excute false,bring back sql status)
	 *   				   [1]=>dependent on [0],effect row count or sql status
	 */
	public function delOne( $data ){
		$re = $this -> filter( array( 'c_id' ), $data );
		if( $re[0]!=3 ){ return $re[0]==0?array(0):array(0, $re[1]); }
		//if( filter_sql_array( $data ) ){ return array(0); }
		$sql = sprintf( 'call drop_art_comment( \'%d\' )',$data['c_id']  );
		//var_dump($sql);
		$re = $this -> getRow( $sql );
		if( $re['status'] == 2 ){ return array(1,$re['effect']); }
		else{ return array(2,$re['status']); }
	}
	/**
	 * get a art_category return it
	 * @param  int   $data   n_id
	 * @return mixed       return node row or false when row is not exsist
	 */
	public function getOne( $data ){
		$data = intval($data);
		return $this -> where( array( 'c_id' => $data ) ) -> find();
	}
	/**
	 * get all art_category return it
	 * @param  int   $data   n_id
	 * @return mixed       return node row or false when row is not exsist
	 */
	public function getAll(){
		return $this -> select();
	}
}
?>
