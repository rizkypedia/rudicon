<?php

class Model {

    public $db_link;
    
    public function __construct($database) {
        
        if ($database instanceof database) {
            $dbName = $database->dbCredentials['database'];
            $host = $database->dbCredentials['host'];
            $userName = $database->dbCredentials['user'];
            $password = $database->dbCredentials['password'];
        
            $dsn = "mysql:dbname=".$dbName.";host=" . $host;
        
            
            try {
                   $dbh = new PDO($dsn, $userName, $password);
		} catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
             }
                $this->db_link = $dbh;
           }
          
    }
	
	public function insertQuery($data,$tablename){
		
		$complete_query = "";
		
		   $str_fields="";
		   $str_val="(NULL ,";
		   $c=0;
		
		if(is_array($data)){
			  $size=sizeof($data)-1;
             $str.="INSERT INTO ".$tablename." (id, ";
             
              while(list($key,$val)=each($data)){
                  
                    $str_fields.=$key . ($c < $size ? "," : ")");
                    $str_val.="'".$val."'" .($c < $size ? "," : ")");
                    $c++;
              }
              
              $complete_query = $str .$str_fields ." VALUES ". $str_val;
		}
		$this->db_link->query(complete_query);
	}
	
	public function count_rows($tablename,$keyname, $where = array()){
		$sql = "SELECT count(*) AS " . $keyname . " FROM " . $tablename;
		
		
		if(!empty($where)){ 
			$sql .=" WHERE ";  
			$sz = sizeof($where) - 1;
			$counter = 0;
			
			while(list($field,$condition) = each($where)){
				
				$sql .= $field."=".$condition;
				$sql .= ($counter < $sz ? " AND " : "");
				$counter++;
				
			}
		}
		
		$row = $this->db_link->query($sql);
		$result = $row->fetch(PDO::FETCH_OBJ);
		return $result->$keyname;
		
	}
	
	public function delete_record($id = array(),$tablename){
		
		$success = false;
		
		if(!empty($id)){
			list($key,$val) = each($id);
			$del =" DELETE FROM " . $tablename . " WHERE ". $key ."=" . $val . "";
		}
	
		$this->db_link->query($del);

	}
	
	public function update_single_record($condition=array(),$sets=array(),$tablename){
		
		$success = false;
		$update = "UPDATE " . $tablename. " SET ";
		
		/*loop through set array*/
		$sz_sets = sizeof($sets) - 1;
		$counter = 0;
		
		while(list($key,$val)=each($sets)){
			
			
			 $update .= $key."=".(is_string($val) ? "'".$val."'" : $val);
			 $update .=($counter < $sz_sets ? "," : "");
			 $counter++;
		}
		
		$update .=" WHERE ";
		
		$counter = 0;
		
		/*loop through condition*/
		$sz_condition = sizeof($condition) - 1;
		
		while(list($where,$to)=each($condition)){
			$update .=$where. "=" . $to;
			$update .=($counter < $sz_condition ? " AND " : "");
			$counter++;
		}
		
		$update.="";
		
		$this->db_link->query($update);
		
	
		
	}
}
?>
