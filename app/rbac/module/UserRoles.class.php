<?php
namespace app\rbac\module;
class UserRoles extends \simvc\lib\module\Module{
	protected $tab_name = 'sim_user_roles';

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
		$data['u_id'] = intval($data['u_id']);
		$data['r_id'] = intval($data['r_id']);
		$re = $this -> where( $data ) -> delete();
		if( $re == 1 ){ return array(1); }
		else{ return array(2); }
	}
	public function delMulti( $data ){}
	public function getOne( $data ){}
	public function getMulti( $data ){}

	

}
?>
