<?php
class HomeController extends ShellController {

	public $models;
	
	public function __construct() {
		
		parent::__construct();
		require DB_CONFIG_PATH;
		
		$this->uses = array("base");
		//$this->models = $this->load->dbModels(APP_PATH_MODEL, $this->uses, $db_connect_params);

	}
	
	public function indexAction() {
		$data['msg'] = "This is a message";
		$data['headerTitle'] = "This is a title";
		
		$this->load->view(__METHOD__, $data);
	}
	
	public function quoteAction($param) {
	
		if (!isset($param)) {
			die("SYSTEM ERROR!");
		}
		$data['msg'] = $param;

		 $this->models['Base']->getQuotes();

		$this->load->view(__METHOD__, $data);
	}
        
        public function goAction() {
            echo "blablabla ";
        }
}
?>