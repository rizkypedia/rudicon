<?php

class SystemShellController {
	
	private $__consoleArgs;
	private $__localMethods = array("help", "version", "create_modules");
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
		$versionsMsg .="A Simple Rudimentary Console App by Rizky RIdwan";
		$versionsMsg .="\n";
		$versionsMsg .="Contact Me @ dragonclaw79@googlemail.com";
		$versionsMsg .="\n";
		$versionsMsg .="Version0.1beta";
		$versionsMsg .="\n";
		echo $versionsMsg;
	}
	
	private function __moduleExists() {
		$moduleName = $this->__extractModuleName();
		if (in_array($moduleName, $this->__localMethods)) {
			if (strtolower($moduleName) === "version") {
				$this->showVersion();
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
		return str_replace("-", "", $this->__consoleArgs[1]);
	}
	
	public function getCleanModuleName() {
		return $this->__extractModuleName();
	}
	
	public function getArguments() {
		$this->__consoleArgs[1] = str_replace("-", "", $this->__consoleArgs[1]);
		return $this->__consoleArgs;
	}
	public function help() {
		echo "help";
		echo "\n";
	}
	
	

	
}