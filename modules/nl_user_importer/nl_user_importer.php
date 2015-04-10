<?php
define('APP_PATH', dirname(__FILE__));
define('APP_PATH_VIEW', APP_PATH . "/view");
define('APP_PATH_MODEL', APP_PATH . "/model");
/*DB COnfig*/
define('DB_CONFIG_PATH', APP_PATH . "/model/config/database.php");
//require DB_CONFIG_PATH;
define('APP_CONFIG', APP_PATH . "/module.config.json");
define('APP_PATH_CONTROLLER', APP_PATH . "/controller");
define('JSON_FILE_HCR', APP_PATH . "/model/hcr_users.txt");
define('JSON_FILE_FTR', APP_PATH . "/model/ftr_users.txt");
define('JSON_FILE_INDINL', APP_PATH . "/model/indinl_users.txt");