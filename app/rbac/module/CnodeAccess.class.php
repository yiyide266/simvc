<?php
namespace app\rbac\module;
class CnodeAccess extends \simvc\lib\module\Module{
	protected $tab_name = 'cnode_access';

	public static function who(){
		return __CLASS__;
	}

	public function addOne( $data ){
		if( filter_sql_array( $data ) ){ return array(0); }
		if( $this -> checkDuplicate( $data ) ){ return array(1); }
		//if( $this -> checkPid( $data ) ){ return array(2); }
		$m = \app\rbac\module\Cnode::instance();
		$re = $m -> getFathers( $data['n_id'] );
		if( $re[0] == 0 ){ return array(2);  }
		if( !empty($re[1]) ){
			foreach ($re[1] as $v) {
				$p = array( 'r_id' => $data['r_id'], 'n_id' => $v );
				if( !$this -> checkDuplicate( $p ) ){
					$this -> add( $p );
				}
			}
		}
		$instId = $this -> add( $data );
		if($instId){
			return array(3,$instId);
		}else{
			return array(4);
		}
	}
	public function addMulti( $data ){}
	public function alterOne( $data ){}
	public function alterMulti( $data ){}
	public function delOne( $data ){
		$m = \app\rbac\module\Cnode::instance();
		$re = $m -> getChilds( $data['n_id'] );
		if( $re[0] == 0 ){
			$n_id = '\''.$re[1]['n_id'].'\'';
		}elseif(  $re[0] == 1  ){
			return array(0);
		}elseif ( $re[0] == 2 ) {
			$n_id = '';
			foreach ($re[1] as $k => $val) {
				$n_id .= '\''.$val['n_id'].'\',';
			}
			$n_id = substr( $n_id, 0, -1 );
		}
		$re = $this -> where( array( 'r_id' => $data['r_id'], 'n_id' => array( 'in', $n_id ) ) ) -> delete();
		if( $re ){ return array(1,$re); }
		else{ return array(2); }
	}
	public function delMulti( $data ){}
	public function getOne( $data ){
		//$data = intval($data);
		if( filter_sql_array( $data ) ){ return array(0); }
		$re = $this -> where( $data ) -> find();
		if( !empty( $re ) ){
			 return array(1,$re);
		}else{
			 return array(2);
		}

	}
	public function getMulti( $data ){}

	public function getUserPermit( $data ){
		$sql = 'SELECT `c`.`n_id`,`c`.`n_name`,`c`.`n_spec`,`c`.`n_type`,`c`.`n_pid` FROM `sim_users` AS `u`'.
		'RIGHT JOIN `sim_user_roles` AS `ur` ON `u`.`u_id` = `ur`.`u_id` '.
		'RIGHT JOIN `sim_cnode_access` AS `ca` ON `ur`.`r_id` = `ca`.`r_id` '.
		'RIGHT JOIN `sim_cnode` AS `c` ON `ca`.`n_id` = `c`.`n_id` '.
		'WHERE `u`.`u_id` = \'%d\'';
		return  $this -> getRows( sprintf( $sql, $data ) );
	}

	public function checkDuplicate( $data ){
		$re = $this -> where( $data ) -> find();
		return empty($re)?false:true;
	}
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
		$id = 'n_id';
		$pid = 'n_pid';
		$name = 'n_name';
		$spec = 'n_spec';
		$type = 'n_type';
		foreach($data as $k=>$v){
			$items[$v[$id]] = $v;
		}
		$tree = array(); //格式化好的树
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
	    $tree = array(); //格式化好的树
	    foreach ($items as $item)
	        if (isset($items[$item[$pid]]))
	            $items[$item[$pid]]['children'][] = &$items[$item[$id]];
	        else
	            $tree[] = &$items[$item[$id]];
	    return $tree;

	}
}
?>
