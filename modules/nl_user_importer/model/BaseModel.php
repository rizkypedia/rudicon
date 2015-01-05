<?php

class BaseModel extends Model {

	public function __construct($param) {
		parent::__construct($param);
	}
	
	public function getQuotes() {
		$sql = 'SELECT id, quote FROM all_quotes ORDER BY id ASC';

    foreach ($this->db_link->query($sql) as $row) {
			print $row['id'] . "\t";
			print $row['quote'] . "\t\n";
    
		}
	}
	
	public function addData($data, $tableName) {
		$insertStr = "";
		if (is_array($data)) {
			$preparedData = array();
			$insertStr .= "INSERT INTO " . $tableName . " ";
			$fields = "(";
			$fieldValues = " VALUES (";
			
			$amount = count($data) - 1;
			$s = 0;

			foreach ($data as $key => $value) {
				$fields .= $key;
				$fields .= ($s < $amount ? "," : ")");
				
				$fieldValues .= $this->__verifyInput($value);
				//$fieldValues .= ":" . $key;
				$fieldValues .= ($s < $amount ? "," : ")");
				//$preparedData[":" . $key] = $this->__verifyInput($value);
				$s++;
			}
			
			$insertStr .= $fields . "" . $fieldValues;
			
		}

		if (!empty($insertStr)) {
			$q = $this->db_link->prepare($insertStr);
			$q->execute($preparedData);
			echo $insertStr;
			//var_dump($preparedData);
			//var_dump($q);
		}
		//
	}
	
	private function __verifyInput($strInput) {		
		$str = 'NULL';
		if (!is_null($strInput)) {
			if (is_string($strInput)) {
				$str = "'" . utf8_decode($strInput) . "'";
			} else {
				$str = $strInput;
			}
		}
		return $str;
		
	}
	
}
