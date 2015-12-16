<?php

class SystemShellController {
	
	private $__consoleArgs;
	private $__localMethods = array("help", "version", "createModules", "showModules");
	public function __construct($args) {
			$this->__consoleArgs = $args;
	}
	
	public function checkArgs() {
		
		$sizeOfArgs = count($this->__consoleArgs);
		
		if ($sizeOfArgs > 1) {
	
			$check = $this->__argSpellCheck($this->__consoleArgs[1]);
			if (!$check) {
				die("Syntax Error! The second argument must lead by -\n");
			}
			$this->__moduleExists();
		} else {
	
			$this->showVersion();
			exit(0);
		}
		
	}
	
	private function __argSpellCheck($spell) {
		$posOfMinus = strpos($spell, "-");
		$approved = false;
		if ($posOfMinus !== false && $posOfMinus === 0) {
			$approved = true;
		}
		
		return $approved;
	}
	
	public function showVersion() {
		$versionsMsg = "";
		$versionsMsg .="Welcome to Rudicon" . "\n";
		$versionsMsg .="A Simple Rudimentary Console App by Rizky Ridwan";
		$versionsMsg .="\n";
		$versionsMsg .="Contact Me @ dragonclaw79@googlemail.com";
		$versionsMsg .="\n";
		$versionsMsg .="Version 1.1";
		$versionsMsg .="\n";
		echo $versionsMsg;
	}
	
	private function __moduleExists() {
		$module = $this->__extractModuleName();
                
                $moduleName = $module['modulename'];
                
		if (in_array($moduleName, $this->__localMethods)) {
                    if (strtolower($moduleName) === "version") {
                        $this->showVersion();
                        exit(0);
                    } else {
                        $this->{strtolower($moduleName)}();
                        exit(0);
                    }
                        
		} else {
                    if (!file_exists(START_PATH . "/" . $moduleName)) {
                        die("ERROR! Module " . $moduleName . " ist nicht bekannt\n");
                    }
		}
		
	}
	
	private function __extractModuleName() {
            
            
            $param = str_replace("-","",$this->__consoleArgs[1]);
            $parts = array();
            if (strpos($param, ".") !== false) {
                list($moduleName, $moduleComponent) = explode(".", $param);
                $parts['modulename'] = $moduleName;
                $parts['moduleComponent'] = $moduleComponent;
            } else {
                  $moduleName = $param;
                   $parts['modulename'] = $param;
                   $parts['moduleComponent'] = "";
               /*if (in_array($param, $this->__localMethods)) {
                   $moduleName = $param;
               } else {
                   die("Pleae use Object Notation for calling a module app: modulename.controller/action [param]");
               }*/
                
            }
            
            return $parts;
	}
	
	public function getCleanModuleName() {
            $module = $this->__extractModuleName();
            return $module['modulename'];
	}
	
	public function getArguments() {
		$this->__consoleArgs[1] = str_replace("-", "", $this->__consoleArgs[1]);
		return $this->__consoleArgs;
            
	}
	public function help() {
		echo "help";
		echo "\n";
	}
	public function showModules() {
		$msg = "";
		$msg .= "Available Modules:\n";
                echo $msg;
		if ($handle = opendir(START_PATH)) {
			 while (false !== ($file = readdir($handle))) {
			   if ($file != "." && $file != "..") {
				echo "$file\n";
			   }
				
			}
		}
		closedir($handle);
		exit(0);
	}
	
	public function createModules() {
		if (isset($this->__consoleArgs[2])) {
			$moduleName = $this->__consoleArgs[2];
			mkdir(START_PATH . $moduleName);
			mkdir(START_PATH . $moduleName . "/config");
			mkdir(START_PATH . $moduleName . "/controller");
			mkdir(START_PATH . $moduleName . "/model");
			mkdir(START_PATH . $moduleName . "/model/config");
			mkdir(START_PATH . $moduleName . "/view");
			$this->__createFile(START_PATH . $moduleName . "/" . $moduleName, ".php");
			$srcConfigDb = START_PATH . "myconsole/model/config/database.php";
			$dstConfigDb = START_PATH . $moduleName . "/model/config/database.php";
			$this->__copyFiles($srcConfigDb, $dstConfigDb);
			$srcBaseModel = START_PATH . "myconsole/model/BaseModel.php";
			$dstBaseModel = START_PATH . $moduleName . "/model/BaseModel.php";
			$this->__copyFiles($srcBaseModel, $dstBaseModel);
			echo "Project " . $moduleName . " created\n";
			exit();
		}
	}
	
	private function __createFile($fileName = "default", $ext = ".php") {
	
		$handle = fopen($fileName . $ext, "w+");
		if (!$handle) {
			die("Cannot create " . $fileName . $ext);
			fclose($handle);
		} else {
			$text = "\xEF\xBB\xBF";
			$text .= "<?php";
			$text .= "\n\n";
			$text .= "?>";
			fputs($handle, $text);
		}
		fclose($handle);
	}
	

	
	private function __copyFiles($src, $dest) {
		$cp = copy($src, $dest);
		if (!$cp) {
			die("Copy Error!");
		}
	}
	
	
	

	
}