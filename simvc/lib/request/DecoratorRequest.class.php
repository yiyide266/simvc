<?php
namespace simvc\lib\request;
abstract class DecoratorRequest extends ProcessRequest{
    protected $request;
	public function __construct( ProcessRequest $request ){
		$this -> request = $request;
	}
}

?>
