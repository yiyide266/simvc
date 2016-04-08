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
function conf_merge( $conf ){
    $config = 'simvc\lib\config\\'._CONFIG.'Config';
	$config = $config::instance();
	$config -> merge( $conf );
}
/*URLo?¡ê¡è?|¡§?START*/
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
function assem_p( $p ){
	$r = simvc\lib\request\Request::instance();
	return $r -> assemP( $p );
}
function assem_a( $a ){
	$r = simvc\lib\request\Request::instance();
	return $r -> assemA( $a );
}
function assem_c( $c ){
	$r = simvc\lib\request\Request::instance();
	return $r -> assemC( $c );
}
function assem_m( $m ){
	$r = simvc\lib\request\Request::instance();
	return $r -> assemM( $m );
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
/*URLo?¡ê¡è?|¡§?END*/
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

function handle_err( $type, $status ){
	switch ($type) {
		case 0:
			$status['status'] = 0;
		break;
		case 1:
			$status['status'] = 1;
		break;
		case 2:
			$status['status'] = 2;
		break;
		case 3:
			$status['status'] = 3;
		break;
		
	}
	ob_end_clean();
	if( IS_AJAX ){
		set_http_header('json');
		require_once( _ERROR_TEMPLATE_JSON );
	}else{
		require_once( _ERROR_TEMPLATE_HTML );
	}
	//ob_end_flush();
	//ob_flush();
	//ob_clean();
	exit;
}

/**
 * URL???¡§?¨°
 * @param string $url ???¡§?¨°¦Ì?URL¦Ì??¡¤
 * @param integer $time ???¡§?¨°¦Ì?¦Ì¨¨¡äy¨º¡À??¡ê¡§??¡ê?
 * @param string $msg ???¡§?¨°?¡ã¦Ì?¨¬¨¢¨º?D??¡é
 * @return void
 */
function redirect($url, $time=0, $msg='') {
    //?¨¤DDURL¦Ì??¡¤?¡ì3?
    $url        = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg))
        $msg    = "?¦Ì¨ª3???¨²{$time}????o¨®¡Á??¡¥¨¬?¡Áa¦Ì?{$url}¡ê?";
    if (!headers_sent()) {
        // redirect
        if (0 === $time) {
            header('Location: ' . $url);
        } else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    } else {
        $str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0)
            $str .= $msg;
        exit($str);
    }
}


function send($url, $params = array() , $headers = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!empty($params)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        if (!empty($headers)) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $txt = curl_exec($ch);
        if (curl_errno($ch)) {
            //trace(curl_error($ch) , '¨¦y??¨ª¡§?a3?¡ä¨ª', 'NOTIC', true);
            
            return false;
        }
        curl_close($ch);
        $ret = json_decode($txt, true);
        if (!$ret) {
            //trace('?¨®?¨²[' . $url . ']¡¤¦Ì????¨º?2??y¨¨¡¤', '¨¦y??¨ª¡§?a3?¡ä¨ª', 'NOTIC', true);
            
            return false;
        }
        
        return $ret;
    }

function cookie_get( $key ){
    $config = 'simvc\lib\cookie\Cookie';
	$config = $config::instance();
	return $config -> get( $key );
}
function cookie_set( $name, $value, $expire, $path = '/' ){
    $config = 'simvc\lib\cookie\Cookie';
	$config = $config::instance();
	$config -> set( $name, $value, $expire, $path = '/' );
}
function cookie_del(  $name, $path = '/'  ){
    $config = 'simvc\lib\cookie\Cookie';
	$config = $config::instance();
	return $config -> del( $name, $path = '/' );
}
function sess( $k, $v = '' ){
	$s = new \PEngine\Libarary\Session\FileSession();
	if( empty($v) ){
		return $s -> get( $k );
	}else{
		$s -> set( $k, $v );
	}
}
function sess_del( $k ){
	$s = new \PEngine\Libarary\Session\FileSession();
	$s -> del( $k );
}
function sess_destroy(){
	$s = new \PEngine\Libarary\Session\FileSession();
	$s -> destroy();
}
?>
