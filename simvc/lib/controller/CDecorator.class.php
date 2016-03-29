<?php
namespace simvc\lib\controller;
abstract class CDecorator extends Controller{
	//ÒÀÈ»ÊÇ³éÏóÀà£¬ËùÒÔ²»ÓÃÊµÏÖ¸¸ÀàµÄ³éÏó·½·¨
	//´´½¨Ò»¸ö±£´ætileÊµÀýµÄ¶ÔÏó
	protected $c;
	//´´½¨Ò»¸ö¹¹Ôìº¯Êý£¬Ö»½ÓÊÜÀ´×ÔTileµÄÊµÀý²ÎÊý
	public function __construct( Controller $c ){
		$this -> c = $c;
	}

}


?>
