<?php

class HelpController extends ShellController {
	
	public function __construct() {
		parent::__construct();
		
	}
	
	public function indexAction() {
		$controllersPath = APP_PATH_CONTROLLER;
		$allClasess = array();
		if ($handle = opendir($controllersPath)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != "..") {
					$pathParts = pathinfo(APP_PATH_CONTROLLER . "/" . $file);
					if ($pathParts['extension'] == "php" && $file !== "HelpController.php") {
						
						require APP_PATH_CONTROLLER . "/" . $file;
						$controllerName = str_replace(".php", "", $file);
						$class = new ReflectionClass($controllerName);
						$allClasess[$controllerName] = $class->getMethods(ReflectionMethod::IS_PUBLIC);
					}
						
				}
						
			}
		}
		closedir($handle);
		$data['controllerData'] = $allClasess;
		$data['cleanfunction'] = $this->load->viewHelper("CleanStrings");
		$this->load->view(__METHOD__, $data);
			
	}
	
	private function __printControllers($controllerData = array()) {
		
	}
	
}
?>