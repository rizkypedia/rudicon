<?php

define('APP_PATH', dirname(__FILE__));
//echo dirname(dirname(APP_PATH));

define('APP_MODULE_NAME', 'funke_mailing');
define('APP_PATH_VIEW', APP_PATH . "/view");
define('APP_PATH_MODEL', APP_PATH . "/model");
/*DB COnfig*/
define('DB_CONFIG_PATH', APP_PATH . "/model/config/database.php");
//require DB_CONFIG_PATH;
define('APP_CONFIG', APP_PATH . "/module.config.json");
define('APP_PATH_CONTROLLER', APP_PATH . "/controller");
define('CSV_FILE', APP_PATH . "/user_files");
define('FILE_ENDING', '.csv');