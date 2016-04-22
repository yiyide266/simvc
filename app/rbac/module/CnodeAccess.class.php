<?php
namespace app\rbac\module;
/**
 * Cnode database touch layer
 * @category   rbac
 * @package  rbac
 * @subpackage  lib.module
 * @author    kimmy
 */
class CnodeAccess extends \simvc\lib\module\Module{
	/**
	 * declare table name in this module 
	 * @attribute  protected
	 * @type string
	 */
	protected $tab_name = 'cnode_access';
	/**
	 * declare this module name
	 * @param  void
	 * @return string
	 */
	public static function who(){
		return __CLASS__;
	}
	/**
	 * insert include its fathers and childs automatic
	 * @param  array   $data	   db field array
	 * @return array       status
	 *   				   [0]=>
	 *        				0:false(parameter detect false)
	 *        				1:false(duplicate row)
	 *        				2:false(get fathers route fasle)
	 *        				3:success(bring back last insert id in array)
	 *        				4:false(insert false)
	 *   				   [1]=>dependent on [0],last insert id or unset
	 */
	public function addOne( $data ){
		if( filter_sql_array( $data ) ){ return array(0); }
		if( $this -> getOne( $data ) ){ return array(1); }
		$m = \app\rbac\module\Cnode::instance();
		$re = $m -> getFathers( $data['n_id'] );
		if( $re === false ){ return array(2);  }
		$instId = array();
		if( !empty($re) ){
			foreach ($re as $v) {
				$p = array( 'r_id' => $data['r_id'], 'n_id' => $v );
				if( !$this -> getOne( $p ) ){
					$instId[] = $this -> add( $p );
				}
			}
		}
		$re = $m -> getChilds( $data['n_id'] );
		foreach ($re as $v) {
			$p = array( 'r_id' => $data['r_id'], 'n_id' => $v['n_id'] );
			if( !$this -> getOne( $p ) ){
				$instId[] = $this -> add( $p );
			}
		}
		if($instId){
			return array(3,$instId);
		}else{
			return array(4);
		}
	}
	
	/**
	 * delete include its childs automatic
	 * @param  string  $data    n_id
	 * @return array       status
	 *   				   [0]=>
	 *        				0:false(parameter detect false)
	 *        				1:success(bring back effect row count)
	 *        				2:false(excute false)
	 *   				   [1]=>dependent on [0],effect row count or unset
	 */
	public function delOne( $data ){
		$m = \app\rbac\module\Cnode::instance();
		$re = $m -> getChilds( $data['n_id'] );
		//var_dump( $re );
		if( $re === false ){
			return array(0);
		}elseif(  empty($re)  ){
			$n_id = '\''.$re[1]['n_id'].'\'';
		}else {
			$n_id = '';
			foreach ($re as $k => $val) {
				$n_id .= '\''.$val['n_id'].'\',';
			}
			$n_id = substr( $n_id, 0, -1 );
		}
		//var_dump($n_id);exit;
		$re = $this -> where( array( 'r_id' => $data['r_id'], 'n_id' => array( 'in', $n_id ) ) ) -> delete();
		if( $re ){ return array(1,$re); }
		else{ return array(2); }
	}
	
	/**
	 * get one
	 * @param  int   $data   n_id
	 * @return mixed       return node row or false when row is not exsist
	 */
	public function getOne( $data ){
		return $this -> where( $data ) -> find();
	}
	
	/**
	 * get user permit
	 * @param  int   $data   u_id
	 * @return mixed       return node row or false when row is not exsist
	 */
	public function getUserPermit( $data ){
		$sql = 'SELECT `c`.`n_id`,`c`.`n_name`,`c`.`n_spec`,`c`.`n_type`,`c`.`n_pid` FROM `'.conf( 'sys_db_prefix' ).'users` AS `u`'.
		'RIGHT JOIN `'.conf( 'sys_db_prefix' ).'user_roles` AS `ur` ON `u`.`u_id` = `ur`.`u_id` '.
		'RIGHT JOIN `'.conf( 'sys_db_prefix' ).'cnode_access` AS `ca` ON `ur`.`r_id` = `ca`.`r_id` '.
		'RIGHT JOIN `'.conf( 'sys_db_prefix' ).'cnode` AS `c` ON `ca`.`n_id` = `c`.`n_id` '.
		'WHERE `u`.`u_id` = \'%d\'';
		//var_dump(sprintf( $sql, $data ));
		return  $this -> getRows( sprintf( $sql, $data ) );
	}

	/*public function checkDuplicate( $data ){
		$re = $this -> where( $data ) -> find();
		return empty($re)?false:true;
	}*/
	public function checkPid( $data ){
		$m = \app\rbac\module\Cnode::instance();
		$re = $m -> getOne( $data['n_id'] );
		if( $re[0] == 0 ){
			if( $re[1]['n_pid'] != 0 ){
				$re = $this -> getOne( array( 'r_id' => $data['r_id'], 'n_id' => $re[1]['n_pid'] ) );
				return $re[0] == 1?false:true;
			}else{
				return false;
			}
		}
		return true;
	}

	public function arrTotree( $data ){
		if( empty($data) ){return array();}
		$id = 'n_id';
		$pid = 'n_pid';
		$name = 'n_name';
		$spec = 'n_spec';
		$type = 'n_type';
		foreach($data as $k=>$v){
			$items[$v[$id]] = $v;
		}
		$tree = array(); //¸ñÊ½»¯ºÃµÄÊ÷
		foreach ($items as $item){
			if (isset($items[$item[$pid]])){
				$items[$item[$pid]][$item[$name]] = &$items[$item[$id]];
				unset($items[$item[$pid]][$item[$name]][$id]);
				unset($items[$item[$pid]][$item[$name]][$pid]);
				unset($items[$item[$pid]][$item[$name]][$name]);
				unset($items[$item[$pid]][$item[$name]][$spec]);
				unset($items[$item[$pid]][$item[$name]][$type]);
			}else{
				$tree[$item[$name]] = &$items[$item[$id]];
				unset($tree[$item[$name]][$id]);
				unset($tree[$item[$name]][$pid]);
				unset($tree[$item[$name]][$name]);
				unset($tree[$item[$name]][$spec]);
				unset($tree[$item[$name]][$type]);
			}
			//unset();
		}
		return $tree;
	}

	public function arrTotree_2( $data ){
		$id = 'n_id';
		$pid = 'n_pid';
		foreach($data as $k=>$v){
			$items[$v[$id]]['id'] = $v[$id];
			$items[$v[$id]]['name'] = $v['n_name'];
			$items[$v[$id]]['text'] = $v['n_spec'];
			$items[$v[$id]]['pid'] = $v[$pid];
		}
		//var_dump($items);exit;
		$id='id';
		$pid='pid';
	    $tree = array(); //¸ñÊ½»¯ºÃµÄÊ÷
	    foreach ($items as $item)
	        if (isset($items[$item[$pid]]))
	            $items[$item[$pid]]['children'][] = &$items[$item[$id]];
	        else
	            $tree[] = &$items[$item[$id]];
	    return $tree;

	}
}
?>
