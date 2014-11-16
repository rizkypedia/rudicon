<?php 

class Model {

  public $db_link;
    
    public function __construct($db_connect_params) {
		
          if(!empty($db_connect_params)){  
             
              //include_once $db_config_file;
			  $dsn = "mysql:dbname=" . $db_connect_params['database'] . ";host=127.0.0.1";
				$user = $db_connect_params['user'];
				$password = $db_connect_params['password'];
            try {
				$dbh = new PDO($dsn, $user, $password);
			} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
			}
		
			$this->db_link = $dbh;
           
          }
    }

}
?>