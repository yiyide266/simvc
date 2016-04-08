<?php
namespace app\rbac\module;
class Users extends \simvc\lib\module\Module{
	protected $tab_name = 'sim_users';

	public function addOne( $data ){
		if( filter_sql_array( $data ) ){ return array(0); }
		$sql = sprintf( 'call insert_user(\'%s\', \'%s\', \'%s\', \'%d\', \'%d\')',_crc32($data['u_account']), $data['u_account'], md5($data['u_pass']), $data['u_pid'], $data['u_t_s']  );
		$re = $this -> getRow( $sql );
		if( $re['status'] == 1 ){ return array(1,$re['u_id']); }
		else{ return array(2); }
	}
	public function addMulti( $data ){}
	public function alterOne( $data ){}
	public function alterMulti( $data ){}
	public function delOne( $data ){
		if( filter_sql( $data ) ){ return array(0); }
		$sql = sprintf( 'call drop_user( \'%d\' )',$data  );
		$re = $this -> getRow( $sql );
		if( $re['status'] == 2 ){ return array(1,$re['effect']); }
		else{ return array(2); }
	}
	public function delMulti( $data ){}
	public function getOne( $data ){
		$data = intval($data);
		$re = $this -> where( array( 'u_id' => $data ) ) -> find();
		if( !empty( $re ) ){
			 return array(1,$re);
		}else{
			 return array(2);
		}

	}
	public function getMulti( $data ){}

	public function pagination( $data, $page, $size = 5, $field = '*' ){
		$page = empty($page)?1:$page;
		$size = empty($size)?10:$size;
		//var_dump($page);
		//Í³¼Æ×ÜÊý
		$count = $this -> where( $data ) -> count();
		//var_dump($size);
		//¼ÆËã×ÜÒ³Êý
		$totalpage = ceil( $count/$size );
		//var_dump($total);exit;
		//ÏÞ¶¨µ±Ç°Ò³Êý
		$page = $page<=0?1:($page>$totalpage?$totalpage:$page);
		//Éè¶¨Æ«ÒÆÖµ
		$offset = ($page-1)*$size;
		//var_dump(array($offset,$size));
		//È¡»ØÁÐ
		$re = $this -> field( $field ) -> where( $data ) -> limit( array($offset,$size) ) -> select();
		return array( $count,$totalpage, $page, $size, $re );
	}

}
?>
