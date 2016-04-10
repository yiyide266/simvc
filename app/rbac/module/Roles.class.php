<?php
namespace app\rbac\module;
class Roles extends \simvc\lib\module\Module{
	protected $tab_name = 'roles';

	public static function who(){
		return __CLASS__;
	}

	public function addOne( $data ){
		if( filter_sql_array( $data ) ){ return array(0); }
		$instId = $this -> add( $data );
		if($instId){
			return array(1,$instId);
		}else{
			return array(2);
		}
	}
	public function addMulti( $data ){}
	public function alterOne( $data ){}
	public function alterMulti( $data ){}
	public function delOne( $data ){
		$data = intval($data);
		$re_1 = $this -> where(array( 'r_id' => $data ) ) -> delete();
		 
		if( $re_1 == 1 ){ return array(1); }
		else{ return array(2); }
	}
	public function delMulti( $data ){}
	public function getOne( $data ){
		$data = intval($data);
		$re = $this -> where( array( 'r_id' => $data ) ) -> find();
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
