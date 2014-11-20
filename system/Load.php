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
	
	 public function viewHelper($fileName, $pathToHelper = "", $type = "INSTANCE") {
		
		$class_type = array("INSTANCE","STATIC");
		$Instance = null;
		
        if(!empty($fileName) && in_array(trim($type), $class_type)){
            	
			if($type == "INSTANCE"){
                            
                if(empty($pathToHelper)){
					include APP_PATH_VIEW.'/helper/'.$fileName.".php";
                }else{
                    include $pathToHelper."/".$fileName.".php";
                }
				$ins_string = $fileName;
				$Instance = new $ins_string();    

			}else{
                                    
                if(empty($pathToHelper)){
					include APP_PATH_VIEW.'/helper/'.$fileName.".php";
                }else{
                    include $pathToHelper."/".$fileName.".php";
                }
				//include APP_PATH_VIEW.'/helper/'.$fileName.".php";
				
			}
        }
		
		return $Instance;
		
    }
    
    public function library($classname){
    	
    	$lib = LIB_PATH . "/".ucfirst($classname).".php";

    	
    	if(!empty($classname)){
    		if(file_exists($lib)){
    			include_once $lib;	
    			$ins_string = ucfirst($classname);
    			$Instance = new $ins_string();
    			return $Instance;
    		
    		}
    	}
    	
    }
		
		
	
}

?>