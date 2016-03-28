<?php
namespace simvc\lib\request;
class MainRequest extends ProcessRequest{
    public function process( Request $rq ){
		return $rq;
	}
}

?>
