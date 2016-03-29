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
		$c = "\\"._APP."\\".req(0,"a")."\\controller\\".req(0,"c")."Controller";
		//var_dump($c);
		$handler = new lib\controller\CacheDecorator(  new $c()  );
		$handler -> run( req(0,"m") );
		
	}

	public static function autoload( $class ){
		require_once( strtr($class.self::EXT, "\\","/") );
	}

}
?>
