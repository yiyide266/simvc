<?php
namespace simvc\lib\request;
class Request{
    public static $instance = null;
    protected $type = null;
    protected $entr = '';
    public $r = array(
            "get" => array(),
            "post" => array()
    );
    const NORMAL = 0;
    const PATHINFO = 1;
    const REWRITE = 2;
    
    
    public static function instance( $type = null ){
        if( is_null( self::$instance ) ){
            $structrueRequest = new StructrueRequest( new MainRequest() );
            self::$instance = $structrueRequest -> process( new self( $type ) );
        }
        return self::$instance;
    }

    public function __construct( $type ){
        //var_dump('init request <br>');
        $this -> entr = conf( 'url_entr' );
        if( is_null( $type ) ){
            $type = conf( 'url_type' );
        }
        $this -> type = $type;
        if ($type == 0){
                $this -> r["get"] = $_GET;
                $this -> r["post"] = $_POST;
        }else{
                $path = explode("/",empty($_SERVER["PATH_INFO"])?substr($_SERVER['PHP_SELF'],stripos($_SERVER['PHP_SELF'],'.php')+4):$_SERVER["PATH_INFO"]);
                if( !is_null($path) ){
                    array_shift($path);
                    
                    $this -> r["get"]["a"] = !empty($path[0])?$path[0]:null;
                    $this -> r["get"]["c"] = !empty($path[1])?$path[1]:null;
                    $this -> r["get"]["m"] = !empty($path[2])?$path[2]:null;
                    
                    $this -> r["get"] = array_merge($this -> r["get"],$_GET);
                    
                    $len = count($path);
                    for($i=3;$i<$len;$i=$i+2){
                        if(isset($path[$i])){
                            $this -> r["get"][$path[$i]] = isset($path[$i+1])?$path[$i+1]:null;
                        }
                    }
                    $this -> r["post"] = $_POST;
                    
                }
        }
    }

    public function get( $method = 0 , $key ){
            return $method == 0 ? (empty($this -> r["get"][$key])?null:$this -> r["get"][$key]) : ( empty($this -> r["post"][$key])?null:$this -> r["post"][$key] );
    }
    
    public function set( $method = 0 ,$key , $value ){
        if( $method == 0 ){
            $this -> r["get"][$key] = $value;
        }
        if( $method == 1 ){
            $this -> r["post"][$key] = $value;
        }
    }

    public function getAllGet(){
        return $this -> r["get"];
    }
    
    public function getAllPost(){
        return $this -> r["post"];
    }
    //?0?0@?0?6?0?3?0?6?0?0Uri
    public function fUri(){
        switch ($this -> type){
            case self::NORMAL:
                $uri = $_SERVER['REQUEST_URI'];
            break;
            case self::PATHINFO:
                $uri = $_SERVER['REQUEST_URI'];
            break;
            case self::REWRITE:
                $uri = $_SERVER['REQUEST_URI'];
            break;
        }
        return $uri;
    }
    //?0?0@?0?6?0?3app?0?8?0?1?0?0¡¤
    public function aUri(){
        switch ($this -> type){
            case self::NORMAL:
                $uri = $_SERVER['SCRIPT_NAME'].'?a='.$this -> r["get"]["a"];
            break;
            case self::PATHINFO:
                $uri = $_SERVER['SCRIPT_NAME'].'/'.$this -> r["get"]["a"];
            break;
            case self::REWRITE:
                $uri = $this -> entr.'/'.$this -> r["get"]["a"];
            break;
        }
        return $uri;
    }
    //?0?0@?0?6?0?3?0?7?0?1?0?0?0?4?0?4¡Â?0?8?0?1?0?0¡¤
    public function cUri(){
        switch ($this -> type){
            case self::NORMAL:
                $uri = $_SERVER['SCRIPT_NAME'].'?a='.$this -> r["get"]["a"].'&c='.$this -> r["get"]["c"];
            break;
            case self::PATHINFO:
                $uri = $_SERVER['SCRIPT_NAME'].'/'.$this -> r["get"]["a"].'/'.$this -> r["get"]["c"];
            break;
            case self::REWRITE:
                $uri = $this -> entr.'/'.$this -> r["get"]["a"].'/'.$this -> r["get"]["c"];
            break;
        }
        return $uri;
    }
    //?0?0@?0?6?0?3¡¤?0?5¡¤¡§?0?8?0?1?0?0¡¤
    public function mUri(){
        switch ($this -> type){
            case self::NORMAL:
                $uri = $_SERVER['SCRIPT_NAME'].'?a='.$this -> r["get"]["a"].'&c='.$this -> r["get"]["c"].'&m='.$this -> r["get"]["m"];
            break;
            case self::PATHINFO:
                $uri = $_SERVER['SCRIPT_NAME'].'/'.$this -> r["get"]["a"].'/'.$this -> r["get"]["c"].'/'.$this -> r["get"]["m"];
            break;
            case self::REWRITE:
                $uri = $this -> entr.'/'.$this -> r["get"]["a"].'/'.$this -> r["get"]["c"].'/'.$this -> r["get"]["m"];
            break;
        }
        return $uri;
    }
    //?0?5M?0?2?0?3?0?5?0?4?0?0?0?8
    public function assemP( $params ){
        switch ($this -> type){
            case self::NORMAL:
                $uri = '&';
                foreach( $params as $k => $v ){
                    $uri .= $k.'='.$v.'&';
                }
                $uri = substr( $uri, 0, -1 );
            break;
            case self::PATHINFO:
                $uri = '/';
                foreach( $params as $k => $v ){
                    $uri .= $k.'/'.$v.'/';
                }
                $uri = substr( $uri, 0, -1 );
            break;
            case self::REWRITE:
                $uri = '/';
                foreach( $params as $k => $v ){
                    $uri .= $k.'/'.$v.'/';
                }
                $uri = substr( $uri, 0, -1 );
            break;
        }
        return $uri;
    }
    //?0?5M?0?2?0?3APPUri
    public function assemA( $a ){
        switch ($this -> type){
            case self::NORMAL:
                $uri = '?a='.$a;
            break;
            case self::PATHINFO:
                $uri = '/'.$a;
            break;
            case self::REWRITE:
                $uri = '/'.$a;
            break;
        }
        return $_SERVER['SCRIPT_NAME'].$uri;
    }
    //?0?5M?0?2?0?3?0?7?0?1?0?0?0?4?0?4¡ÂUri
    public function assemC( $c ){
        switch ($this -> type){
            case self::NORMAL:
                $uri = '&c='.$c;
            break;
            case self::PATHINFO:
                $uri = '/'.$c;
            break;
            case self::REWRITE:
                $uri = '/'.$c;
            break;
        }
        return $this -> aUri().$uri;
    }
    //?0?5M?0?2?0?3¡¤?0?5¡¤¡§Uri
    public function assemM( $a ){
        switch ($this -> type){
            case self::NORMAL:
                $uri = '&m='.$a;
            break;
            case self::PATHINFO:
                $uri = '/'.$a;
            break;
            case self::REWRITE:
                $uri = '/'.$a;
            break;
        }
        return $this -> cUri().$uri;
    }
}
