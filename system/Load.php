<?php
class Load {
	
	private $test;
	public function __construct() {
		$this->test = "test";
	}
	
	public function view($classname, $data = array()) {
		$args = explode("::",$classname);
    	$folderview=str_replace("Controller","",$args[0]);
    	$viewfile=str_replace("Action","",$args[1]);
    	
    	if(is_array($data)){
            extract($data);
		}
        include APP_PATH_VIEW . "/" . strtolower(trim($folderview)) . "/" . trim($viewfile) . ".php";
	}
	
	public function dbModels($path, $models = array(), $dbConfig) {
		$modelInstances = array();
		
		if (!empty($models)) {

			foreach ($models as $model) {
				require $path . DS . ucfirst($model) . "Model.php";				
		
				$markupModelName = ucfirst($model) . "Model";
				$ins = new $markupModelName($dbConfig);
			
				$modelInstances[ucfirst($model)] = $ins;
			}
		}
			return $modelInstances;
	}
		
		
	
}

?>