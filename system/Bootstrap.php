<?php

class Bootstrap {

private $consoleRequest;
    
    public function __construct($consoleRequest){

        $this->consoleRequest = $consoleRequest;
    }

    public function displayError($err){
         error_reporting(E_ALL & ~E_NOTICE);
          ini_set('display_errors', $err);
    }
    
    public function BootstrapSystem(){

            if(!empty($this->consoleRequest) && count($this->consoleRequest) > 1){

            $rs = ConsoleArgSplitter::getInstance();
            $args=$rs->parseRequest($this->consoleRequest);
            
            if($args['ctrl']!="" || !empty($args['ctrl'])){

                   require APP_PATH_CONTROLLER."/".ucfirst($args['ctrl'])."Controller.php";
                   $al = AutoLoad::getInstance();
                   $param = (empty($args['param']) ? null : $args['param']);
                   $al->run_object($args,$param);

               }
               
           } else {
               
              require APP_PATH_CONTROLLER."/HomeController.php"; 
              $al = AutoLoad::getInstance();
              $args['ctrl'] = "Home";
              $args['action'] = "indexAction";
              $param = null;
              $al->run_object($args,$param);

      }
      
    }
}
?>