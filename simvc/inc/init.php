<?php
define( '_CONFIG', 'Normal' );

define( '_APP', 'app' );
define( '_APP_', _DIR_.'/'._APP );
define( '_PUBLIC_', _DIR_.'/public' );
define( '_ERROR_TEMPLATE_HTML', _PUBLIC_.'/templates/error_template_html.html' );
define( '_ERROR_TEMPLATE_JSON', _PUBLIC_.'/templates/error_template_json.html' );

define( '_PURL_', '/public' );

define('IS_AJAX',       ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ) ? true : false);
?>
