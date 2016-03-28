<?php
namespace simvc\lib\request;
class StructrueRequest extends DecoratorRequest{

    public function process( Request $rq ){
        //var_dump( $rq -> request["get"] );
        $rq -> r["get"] = del_null_key($rq -> r["get"]);
        $rq -> r["post"] = del_null_key($rq -> r["post"]);
        

        $rq -> r["get"]["a"] = !empty($rq -> r["get"]["a"])?$rq -> r["get"]["a"]:DEFAULT_APP;
        $rq -> r["get"]["c"] = !empty($rq -> r["get"]["c"])?$rq -> r["get"]["c"]:DEFAULT_CONTROLLER;
        $rq -> r["get"]["m"] = !empty($rq -> r["get"]["m"])?$rq -> r["get"]["m"]:DEFAULT_ACTION;
        $rq -> r["get"]["l"] = !empty($rq -> r["get"]["l"])?$rq -> r["get"]["l"]:DEFAULT_LANG;
        ksort($rq -> r["get"]);
        ksort($rq -> r["post"]);
        return $this -> request -> process( $rq );
    }
}

?>
