<?php

class ImportController extends ShellController {
	
	public function __construct() {
		parent::__construct();
		require DB_CONFIG_PATH;
		
		$this->uses = array("base");
		$this->models = $this->load->dbModels(APP_PATH_MODEL, $this->uses, $db_connect_params);

	}
	
	public function placeholdersAction($type = "questit") {
		$data['headerTitle'] = "Placeholder Import";
		$data['msg'] = "Import for " . $type;
		
		$this->models['Base']->updateContentPlaceholder($type);
		$this->load->view(__METHOD__, $data);
	}
	
}