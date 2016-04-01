<?php
namespace app\test\module;
class Test extends \simvc\lib\module\Module{

	public function addOne( $data ){
		var_dump($this -> getRow( "call test_7( 'i', 9, 9, 'f', 6 );" ));
	}
	public function addMulti( $data ){}
	public function alterOne( $data ){}
	public function alterMulti( $data ){}
	public function delOne( $data ){}
	public function delMulti( $data ){}
	public function getOne( $data ){}
	public function getMulti( $data ){}


}
?>
