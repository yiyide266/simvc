<?php
namespace app\rbac\module;
class Cnode extends \simvc\lib\module\Module{
	protected $tab_name = 'cnode';

	public static function who(){
		return __CLASS__;
	}

	public function addOne( $data ){
		if( filter_sql_array( $data ) ){ return array(0); }
		$sql = sprintf( 'call insert_cnode(\'%s\', \'%s\', \'%s\', \'%d\', \'%d\', \'%d\')',$data['n_name'], $data['n_spec'], $data['n_icon'], $data['n_type'], $data['n_pid'], $data['n_t_s']  );
		$re = $this -> getRow( $sql );
		if( in_array($re['status'], array( 1,5 )) ){ return array(1,$re['u_id']); }
		else{ return array(2); }
	}
	public function addMulti( $data ){}
	public function alterOne( $data ){}
	public function alterMulti( $data ){}
	public function delOne( $data ){
		if( filter_sql( $data ) ){ return array(0); }
		$sql = sprintf( 'call drop_cnode( \'%d\' )',$data  );
		$re = $this -> getRow( $sql );
		if( $re['status'] == 2 ){ return array(1,$re['effect']); }
		else{ return array(2); }
	}
	public function delMulti( $data ){}
	public function getOne( $data ){
		$data = intval($data);
		$re = $this -> where( array( 'n_id' => $data ) ) -> find();
		if( !empty( $re ) ){
			 return array(0,$re);
		}else{
			 return array(1);
		}

	}
	public function getMulti( $data ){}

	public function getChilds( $data ){
		$re = $this -> getOne( $data );
		if( $re[0] == 0 && ($re[1]['n_t_r_r']-$re[1]['n_t_r_l']) != 1 ){
			$re = $this -> where( array( 'n_t_r_l' => array( 'gt', ($re[1]['n_t_r_l']-1) ), 'n_t_r_r' => array( 'lt', $re[1]['n_t_r_r']+2 ) ) ) -> select();
			return array(2,$re);
		}
		return $re;
	}

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
