<?php
namespace simvc;

class simvc{
    const EXT = ".class.php";


	public function run(){
		//register_shutdown_function('simvc\simvc::fatalError');
		set_error_handler ('simvc\simvc::error');
		set_exception_handler ( 'simvc\simvc::exception' );
		spl_autoload_register('simvc\simvc::autoload');
		
		$c = "\\"._APP."\\".req(0,"a")."\\controller\\".req(0,"c")."Controller";
		//var_dump($c);
		
		$handler = new lib\controller\CacheDecorator(  new $c()  );
		
		$handler -> run( req(0,"m") );
		
	}

	public static function autoload( $class ){
		require_once( strtr($class.self::EXT, "\\","/") );
	}

	/*public static function fatalError() {
		$status['error_get_last'] = error_get_last();
		handle_err( 0, $status );
    }*/

	public static function error( $errno ,  $errstr ,  $errfile ,  $errline  ){
		
		$status['errno'] = $errno;
		$status['errstr'] = $errstr;
		$status['errfile'] = $errfile;
		$status['errline'] = $errline;
		handle_err( 1, $status );
	}

	public static function exception( $e ){
		
		$status['message'] = $e -> getMessage ();
		$status['code'] = $e -> getCode ();
		$status['file'] = $e -> getFile ();
		$status['line'] = $e -> getLine ();
		$status['trace'] = $e -> getTraceAsString ();
		handle_err( 2, $status );
	}

}
?>
