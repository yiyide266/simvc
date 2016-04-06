<?php
namespace simvc\lib\cache;
class FileCache {
	public static $instance = null;

	protected $f_name;
	protected $f_path;
	protected $f_pn;
	protected $c_time;
	protected $fileContent;


	public static function instance(){
		if( is_null( self::$instance ) ){
			//var_dump('FileCache newing');
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct(){
		$this -> init();
	}
	
	public function init(){
		$this -> c_time = conf( 'file_cache_life_time' );
		$p = req_get_all();
		$this -> f_name = _crc32(implode('', $p)).'.dat';
		$this -> f_path = _APP_.'/'.req(0,'a').'/cache/'.req(0,'c').'/'.req(0,'m');
		$this -> f_pn = $this -> f_path.'/'.$this -> f_name;
	}

	public function run( $c, $method, $type ){
		if( $this -> isAlive() ){
			//$debug = 'old<br>';
			$this -> get();
		}else{
			//$debug = 'new<br>';
			$this -> catchFile(  $c , $method  );
			$this -> set();
		}
		set_http_header( $type );
		//echo $debug;
		$this -> display();
	}

	public function get(){
		touch( $this -> f_pn );
		$this -> fileContent = file_get_contents( $this -> f_pn );
	} 

	public function set(){
		if( !is_dir( $this -> f_path ) ){
			mkPath( $this -> f_path );
		}
	    $fw = fopen( $this -> f_pn , "w");
	    fputs($fw,$this -> fileContent, strlen($this -> fileContent));
	    fclose($fw);
	}

	public function catchFile(  $c , $method  ){
		//ob_start();
		$c -> $method();
	    $content = ob_get_contents();
	    ob_end_clean();
		$this -> fileContent = $content;
	}
	
	public function isAlive(){
		return ( is_file( $this -> f_pn ) && ( filemtime( $this -> f_pn ) + $this -> c_time > time() ) );
	}

	public function display(){
		echo $this -> fileContent;
	}
}
?>
