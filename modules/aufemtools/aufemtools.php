<?php

define('APP_PATH', dirname(__FILE__));
define('APP_PATH_VIEW', APP_PATH . "/view");
define('APP_PATH_MODEL', APP_PATH . "/model");
/*DB COnfig*/
define('DB_CONFIG_PATH', APP_PATH . "/model/config/database.php");
//require DB_CONFIG_PATH;
define('APP_CONFIG', APP_PATH . "/module.config.json");
define('APP_PATH_CONTROLLER', APP_PATH . "/controller");

define('MAINPATH', "D:/xampplive/htdocs/www/html5/");
//bubbleshooter/bubbleshooter-html5/gofeminin/
define('TOOLPATH', MAINPATH . "bubbleshooter/bubbleshooter-html5/gofeminin/");
//define('TOOLPATH', MAINPATH . "osterkalender-2015/");
define('TOOLPATHDIST', TOOLPATH . "dist/");
define('JSONFILENAME', TOOLPATH . 'aufemtools.json');
define('REPLICATION_FILE', TOOLPATH . "");
define('ASP_DEFAULT_FILE', TOOLPATH . "/main-asp/default2.asp");
define('ASP_MOB_DEFAULT_FILE', TOOLPATH . "/main-asp/default2_mobile.asp");
define('ASP_BDF_DEFAULT_FILE', TOOLPATH . "/main-asp/bdf/default2.asp");
define('ASP_BDF_MOB_DEFAULT_FILE', TOOLPATH . "/main-asp/bdf/default2_mobile.asp");



?>