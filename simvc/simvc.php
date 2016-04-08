<?php
namespace simvc;

class simvc{


	public function run(){
		register_shutdown_function('simvc\simvc::fatalError');
		set_error_handler ('simvc\simvc::error');
		set_exception_handler ( 'simvc\simvc::exception' );
		spl_autoload_register('simvc\simvc::autoload');
		$a_f = _APP_.'/'.req(0,'a').'/config/'.'conf.php';
		if( is_file($a_f) ){
			$a_f = include(  $a_f  );
			conf_merge( $a_f );
		}
		ob_start();
		$c = "\\"._APP."\\".req(0,"a")."\\controller\\".req(0,"c")."Controller";
		$handler = new lib\controller\CacheDecorator(  new $c()  );
		$handler -> run( req(0,"m") );
	}

	public static function autoload( $class ){
		require_once( strtr($class._EXT, "\\","/") );
	}

	public static function fatalError() {
		$error = error_get_last();
		if( $error ){
			handle_err( 0, $error );
		}
    }

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
