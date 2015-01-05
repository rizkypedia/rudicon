<?php
class ImportController extends ShellController {

	private $__healthCareDataMale;

	private $__healthCareDataFemale;

	public function __construct() {
		parent::__construct();
		require DB_CONFIG_PATH;
		require HEALTHCARE_INFO;
		$this->__healthCareDataMale = $date_array_m;
		$this->__healthCareDataFemale = $date_array_w;

		$this->uses = array("base");

		$this->models = $this->load->dbModels(APP_PATH_MODEL, $this->uses, $db_connect_params);
	}

	public function healthcareinfoAction($sex = "m") {
		$dataValues = ($sex == "m" ? $this->__healthCareDataMale : $this->__healthCareDataFemale);
		$inputData = array();
		foreach ($dataValues as $title => $value) {

			$inputData['sex'] = $sex;
			$inputData['title'] = $title;
			$inputData['alias'] = $value['title'];
			$inputData['years'] = $value['years'];
			$inputData['frequency'] = $value['frequency'];
			$inputData['add_year'] = $value['add_year'];
			$inputData['link'] = $value['link'];
			$this->models['Base']->importHealthCareData($inputData);
		}
		$data['msg'] = "HealthcareImport";
		$this->load->view(__METHOD__, $data);
	}
	
	public function ImportUserAction() {
		
	}
	
}

