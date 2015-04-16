<?php

class AutoLoad {
    private static $instance=null;
    private $ctrl_suffix="Controller";
    private $mdl_suffix="Model";
    
    public static function getInstance(){
         if (null === self::$instance) {
             self::$instance = new self;
         }
         return self::$instance;
    }
    
    public function run_object($args,$param=null){
        //$arg[0]=Controllername (Classname)
        //$arg[1]=Action name
        //$arg[2] ... $arg[n] Parameters
        $str_obj=ucfirst($args['ctrl']).$this->ctrl_suffix;
        $ins=new $str_obj();
        
        if(!empty($args['action'])){
            $action = $args['action'];
        }else{
            $action = "indexAction";
        }
        
        
        if(empty($param)){
            call_user_func(array(&$ins,$action)); 
        }else{
            call_user_func_array(array(&$ins,$action), $param);
        }
        
        
        
    }   

}
?>