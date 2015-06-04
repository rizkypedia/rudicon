<?php

class ConsoleArgSplitter {


     private static $instance=null;
     
      public static function getInstance(){
         if (null === self::$instance) {
             self::$instance = new self;
         }
         return self::$instance;
    }
    
/**
 * New Console argument parser
 * @param string $request the console arguments
 * @return array
 */
    public function parseRequest($request) {
        $args = $request;
        $rest = array();
        //parse first argument
        list($moduleName, $moduleComponents) = explode(".", $args[1]);
        
        //explode contoller and action by /
        if (strpos($moduleComponents, "/") !== false) {
            $components = explode("/", $moduleComponents);
            if (count($components) === 2) {
                $rest['ctrl'] = $components[0];
                $rest['action'] = $components[1]."Action";
                $params = array();
                if (count($args) > 2) {
                    for ($i = 2; $i<sizeof($args);$i++) {
                        if(!empty($args[$i])){
                            $params[] = $args[$i];
                        }
                    }
                }
                $rest['param'] = $params;
            } else {
                die("Wrong Syntax! Correct call syntax: controller/action");
            }
        } else {
            die("Wrong Syntax! Correct call syntax: controller/action");
        }
        
        return $rest;
        
    }

/**
 * deprecated Console argument parser
 * @param String $request
 * @return array
 */    
    public function split_request($request){
        //pa
        
        if(!empty($request)){         
            
            $args = $request;
            $rest['ctrl'] = $args[2];
            $rest['action'] = (empty($args[3]) ? "indexAction" : $args[3]."Action");
            
			$params = array();
			if (count($args) > 4 && isset($args[4])) {
				for ($i = 4; $i<sizeof($args); $i++) {
                                    if(!empty($args[$i])){
                                        $params[] = $args[$i];
                                    }
				}
			}

            
            $rest['param'] = $params;
            
            return $rest;
        }
        
    }
	
}
?>