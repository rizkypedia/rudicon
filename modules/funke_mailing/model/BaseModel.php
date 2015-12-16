<?php

class BaseModel extends Model {

	public function __construct($param) {
            
		parent::__construct($param);
	}
	
	public function getBookings() {
            $sql = 'SELECT * from bookings';
            $results = array();
            foreach ($this->db_link->query($sql) as $row) {
                $results[] = array(
                    "id" => $row['id'],
                    "booking_id" => $row['booking_id'],
                    "email" => $row['email'],
                    "ip" => $row['ip_addr'],
                    "timestamp" => $row['generated_on']
                );
                
            }
            
            return $results;
	}
	
}

?>