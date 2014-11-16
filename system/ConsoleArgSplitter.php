<?php

class ConsoleArgSplitter {


     private static $instance=null;
     
      public static function getInstance(){
         if (null === self::$instance) {
             self::$instance = new self;
         }
         return self::$instance;
    }
    
    public function split_request($request){
        
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