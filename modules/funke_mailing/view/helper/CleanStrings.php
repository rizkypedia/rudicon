<?php
class CleanStrings {
	
	public function __construct() {
	}
	
	public function cleanFileName($fileName) {
		$strFilename = str_replace("Action","", $fileName);
		return $strFilename;
	}
	
}
?>