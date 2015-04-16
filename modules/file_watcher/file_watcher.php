<?php


define('APP_PATH', dirname(__FILE__));
define('APP_MODULE_NAME', 'file_watcher');

define('APP_PATH_VIEW', APP_PATH . "/view");
define('APP_PATH_MODEL', APP_PATH . "/model");

/*DB COnfig*/
define('DB_CONFIG_PATH',APP_PATH."/model/config");
/*FILE location*/
define('FILE_SOURCE_PATH',APP_PATH."/model/files");

//require DB_CONFIG_PATH;
define('APP_CONFIG', APP_PATH . "/module.config.json");
define('APP_PATH_CONTROLLER', APP_PATH . "/controller");
define('FOLDER_TO_WATCH','');
require LIB_PATH ."/Utilities.php";
include_once DB_CONFIG_PATH . "/files.php";
include_once DB_CONFIG_PATH . "/database.php";