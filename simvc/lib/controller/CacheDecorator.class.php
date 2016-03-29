<?php
namespace simvc\lib\controller;
class CacheDecorator extends CDecorator{
	

	public function run( $method ){
		
		$prop = $this -> c -> getMethodProperty( $method );

		if( $prop[0] ){
			$f = \simvc\lib\cache\FileCache::instance();
			$f -> run( $this -> c, $method, $prop[1] );
		}else{
			$this -> c -> run( $method );
		}
	}


}


?>
