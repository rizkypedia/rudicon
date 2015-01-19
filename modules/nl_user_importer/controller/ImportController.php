<?php

class ImportController extends ShellController {	
	
	public function __construct() {

		parent::__construct();
		require DB_CONFIG_PATH;
		
		$this->uses = array("base");
		
		$this->models = $this->load->dbModels(APP_PATH_MODEL, $this->uses, $db_connect_params);
		
	}
	
	public function indexAction($nlType = 'hcr') {
		
	}
	
	public function hcrAction() {
		$this->printLine("Import for health_care_reminder");
		//var_dump(file_exists(JSON_FILE));
		if (file_exists(JSON_FILE_HCR)) {
			$fileToRead = file_get_contents(JSON_FILE_HCR);
			$data = json_decode($fileToRead);
			//var_dump($data->data[1]->{"name"});
			foreach ($data->data as $value) {
				$insert = array();				
				$insert['user_id'] = $value->{"user_id"};
				$insert['ukey'] = $value->{"ukey"};
				$insert['gender'] = (int)$value->{"gender"};
				$insert['name'] = $value->{"name"};
				$insert['firstname'] = $value->{"firstname"};
				$insert['email'] = $value->{"email"};
				$insert['birthday'] = $value->{"birthday"};
				$insert['user_status'] = (int)$value->{"user_status"};
				$insert['user_add_dt'] = $value->{"user_add_dt"};
				$insert['user_activation_dt'] = $value->{"user_activation_dt"};
				$insert['user_unsubscribe_dt'] = $value->{"user_unsubscribe_dt"};
				$insert['user_change_dt'] = $value->{"user_change_dt"};
				$insert['customer_fid'] = $value->{"customer_fid"};
				
				$this->models['Base']->addData($insert, "health_care_reminders");
				
				$this->printLine($value->{"email"});
			}
		}
	}

	public function ftrAction() {
		$this->printLine("Import for fertility_reminder");
		if (file_exists(JSON_FILE_FTR)) {
			$fileToRead = file_get_contents(JSON_FILE_FTR);
			$data = json_decode($fileToRead);
				foreach ($data->data as $value) {
					$insert = array();
					$insert['user_id'] = (int)$value->{"user_id"};
					$insert['ukey'] = $value->{"ukey"};
					$insert['gender'] = (int)$value->{"gender"};
					$insert['name'] = $value->{"name"};
					$insert['firstname'] = $value->{"firstname"};
					$insert['email'] = $value->{"email"};
					$insert['periode_last'] = $value->{"periode_last"};
					$insert["periode_zyklus"] = $value->{"periode_zyklus"};
					$insert['user_status'] = (int)$value->{"user_status"};
					$insert['user_add_dt'] = $value->{"user_add_dt"};
					$insert['user_activation_dt'] = $value->{"user_activation_dt"};
					$insert['user_unsubscribe_dt'] = $value->{"user_unsubscribe_dt"};
					$insert['user_change_dt'] = $value->{"user_change_dt"};
					$this->models['Base']->addData($insert, "fertility_reminders");
					$this->printLine($value->{"email"});
				}
		}
	}
	
	public function indinlAction() {
		$this->printLine("Import for indinl_user");
		if (file_exists(JSON_FILE_INDINL)) {
			$fileToRead = file_get_contents(JSON_FILE_INDINL);
			$data = json_decode($fileToRead);
			
			foreach ($data->data as $key => $value) {
				
				$insert = array();
				$this->printLine($value->{"email"});
				$insert["user_id"] = (int)$value->{'user_id'};
				$insert["nwl_type_fk"] = (int)$value->{'nwl_type_fk'};
				$insert["unique_key"] = $value->{'unique_key'};
				$insert["name"] = $value->{'name'};
				$insert["firstname"] = $value->{'firstname'};
				$insert["gender"] = (int)$value->{'gender'};			
				$insert["email"] = $value->{'email'};
				$insert["birthdate"] = $value->{'birthdate'};
				$insert["startdate"] = $value->{'startdate'};
				$insert["enddate"] = $value->{'enddate'};
				$insert["status"] = (int)$value->{'status'};
				
				$this->models['Base']->addData($insert, "indinl_users");
				$this->printLine($value->{'email'});
			}
		}
	}

}