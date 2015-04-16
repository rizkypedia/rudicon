<?php

class ShellController {
	protected $load;
	protected $model;
	protected $uses;
	protected $helpers;
	public $models;
        private $usage;
	public function __construct() {
	
		$this->load = new Load();
		//$this->model = new BaseModel(DB_CONFIG_PATH . "/database.php");
	}

	public function printLine($msg = "") {
		echo $msg . "\n";
	}
       
        public function pprint($msg = "") {
            echo $msg;
        }
       
        private function uses() {
        
            $this->usage = array();

            if (is_array($this->models) && !empty($this->models)) {
                foreach ($this->models as $src) {
                    require APP_PATH_MODEL . "/" . $src . ".php";
                    $data = new $src();
                    if ($data instanceof Model) {
                        $this->usage[$src] = $data;
                    } else {                   

                        $this->usage[$src] = $data;
                        //check file type
                    }
                }
            }
        
        //return $usage;
        }
        protected function getModels() {
            return $this->usage;
        }
        
	
}
?>