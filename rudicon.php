<?php
/*
MAIN CONSOLE CLASS
*/
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
define('START_PATH', dirname(__DIR__) . "/rudicon/modules/");


/*Systems Settings*/
define('ROOT_PATH', dirname(__DIR__) . "/rudicon");
define('SYS_PATH', ROOT_PATH . "/system");
define('CONFIG_PATH', ROOT_PATH . "/config");
define('LIB_PATH', ROOT_PATH . "/lib");
/**/ 

/*Module Settings*/


/*System Classes*/
include_once SYS_PATH . "/Model.php";
include_once SYS_PATH . "/Load.php";
//include_once APP_PATH . "/model/BaseModel.php";
include_once SYS_PATH . "/ShellController.php";

include_once SYS_PATH . "/AutoLoad.php";
include_once SYS_PATH . "/ConsoleArgSplitter.php";
include_once SYS_PATH . "/Bootstrap.php";
include_once SYS_PATH . "/SystemShellController.php";

$console = $argv;

if ($argv[0] !== "rudicon.php") {
	die ("UNKNOWN SCRIPTS");
}
//define('VARPATH', APP_PATH ."/" . $argv[1]);
$systemCheck = new SystemShellController($argv);
$systemCheck->checkArgs();
$moduleName = $systemCheck->getCleanModuleName();
$uri = $systemCheck->getArguments();
require START_PATH . $moduleName . "/" . $moduleName . ".php";

$bos = new Bootstrap($uri);
$bos->displayError("1");
$bos->BootstrapSystem();



/**/

?>