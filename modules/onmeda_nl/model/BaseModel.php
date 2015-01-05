<?php

class BaseModel extends Model {

	public function __construct($param) {
		parent::__construct($param);
	}

	public function importHealthCareData($values = array()) {
		//$sql = "INSERT INTO books (title,author) VALUES (:title,:author)";

		$sql = "INSERT INTO health_care_infos (";
		$sql .= "sex,title, alias,years,frequency,add_year,link)";
		$sql .= " VALUES ";
		$sql .= "(:sex, :title, :alias, :years, :frequency, :add_year, :link)";

		$stmt = $this->db_link->prepare($sql);
		$stmt->bindParam(':sex', $values['sex']);
		$stmt->bindParam(':title', $values['title']);

		$stmt->bindParam(':alias', $values['alias']);

		$stmt->bindParam(':years', $values['years']);

		$stmt->bindParam(':frequency', $values['frequency']);

		$stmt->bindParam(':add_year', $values['add_year']);

		$stmt->bindParam(':link', $values['link']);

		//$stmt->execute();
		echo $stmt->errorCode() . "\n";
		//$result->execute();
	}

}

