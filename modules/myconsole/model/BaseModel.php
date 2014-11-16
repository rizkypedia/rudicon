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
	
}

?>