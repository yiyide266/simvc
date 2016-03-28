<?php
namespace simvc;

class simvc{
    const EXT = ".class.php";


	public function run(){
		spl_autoload_register('simvc\simvc::autoload');
		//var_dump($_SERVER);exit;
		/*var_dump(req_get_all());
		echo '<br>';
		var_dump(a_uri());
		echo '<br>';
		var_dump(c_uri());
		echo '<br>';
		var_dump(m_uri());
		echo '<br>';
		var_dump(f_uri());
		echo '<br>';*/
		$c = "\\"._APP."\\".req(0,"a")."\\controller\\".urlchar_up(req(0,"c"))."Controller";
		//var_dump($c);
		$run = new lib\controller\CacheController(  new lib\controller\ControllerHandle()  );
		$run -> process( new $c , $run);
		
	}

	public static function autoload( $class ){
		require_once( strtr($class.self::EXT, "\\","/") );
	}

}
?>
