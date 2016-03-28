<?php
define('simvc',true);
define('_DIR_',dirname(__FILE__));
include_once("./simvc/inc/init.php");
include_once("./simvc/simvc.php");
include_once("./simvc/inc/func.php");


define( 'DEFAULT_APP','web' );
define( 'DEFAULT_CONTROLLER','index' );
define( 'DEFAULT_ACTION','index' );
define( 'DEFAULT_LANG','ch' );
$simvc = new simvc\simvc();
$simvc -> run();
?>
