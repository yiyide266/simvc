<?php
function conf( $key,$value = null ){
    $config = 'simvc\lib\config\\'._CONFIG.'Config';
	$config = $config::instance();
	if( is_null( $value ) ){
		return $config -> get( $key );
	}else{
		$config -> set( $key,$value );
	}
}
/*URLo¡¥?¦ÌSTART*/
function req( $method ,$key,$value = null ){
	$r = simvc\lib\request\Request::instance();
	if( is_null( $value ) ){
		return $r -> get( $method ,$key );
	}else{
		$r -> set( $method ,$key,$value );
	}
}
function f_uri(){
	$r = simvc\lib\request\Request::instance();
	return $r -> fUri();
}
function a_uri(){
	$r = simvc\lib\request\Request::instance();
	return $r -> aUri();
}
function c_uri(){
	$r = simvc\lib\request\Request::instance();
	return $r -> cUri();
}
function m_uri(){
	$r = simvc\lib\request\Request::instance();
	return $r -> mUri();
}
function assem_p(){
	$r = simvc\lib\request\Request::instance();
	return $r -> assemP();
}
function assem_a(){
	$r = simvc\lib\request\Request::instance();
	return $r -> assemA();
}
function assem_c(){
	$r = simvc\lib\request\Request::instance();
	return $r -> assemC();
}
function assem_m(){
	$r = simvc\lib\request\Request::instance();
	return $r -> assemM();
}
function req_get_all(){
	$r = simvc\lib\request\Request::instance();
	return $r -> getAllGet();
}

function req_post_all(){
	$r = simvc\lib\request\Request::instance();
	return $r -> getAllPost();
}

function del_null_key($arr){
	foreach( $arr as $k=>$v ){
		if(!$k){unset($arr[$k]);}
	}
	return $arr;
}
function urlchar_up( $str ){
	$arr = explode( '_', $str );
	$str = '';
	if( count($arr) > 1 ){
		foreach( $arr as $k => $v ){
			$str .= ucfirst( strtolower($v) );
		}
	}else{
		$str = ucfirst($arr[0]);
	}
	return $str;
}
/*URLo¡¥?¦ÌEND*/
function _crc32( $str ){
	return sprintf( '%u', crc32( $str ) );
}
function mkPath( $path ){
	$_1 = explode('/',$path);
	$_2 = "";
	foreach( $_1 as $v ){
		$_2 .= $v.'/';
		if( !file_exists( $_2 ) ){
			mkdir($_2,0777);
		}
	}
}
function set_http_header($type){
	switch ($type){
		case "json":
			header("Content-type: application/json");
		break;
		case "xml":
			header("Content-type: application/xml");
		break;
		case "text":
			header("Content-type: text/html");
		break;
	}
}
?>
