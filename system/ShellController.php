<?php

class ShellController {
	protected $load;
	protected $model;
	protected $uses;
	protected $helpers;
	
	public function __construct() {
	
		$this->load = new Load();
		//$this->model = new BaseModel(DB_CONFIG_PATH . "/database.php");
	}
	
}
?>