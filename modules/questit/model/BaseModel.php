<?php

class BaseModel extends Model {

	public function __construct($param) {
		parent::__construct($param);
	}
	
	public function updateContentPlaceholder($type = "questit") {

		$querycond = ($type == "questit" ? "'%include \"questit/qt_general.php\"%'" : "'%include \"quiz/javascript.php\";%'");

		$sqlQuery = "SELECT ac.id,acp.id as acp, ac.article_id as article_id,ac.prio,
					acp.article_chapter_id, acp.content 
					FROM article_chapters ac, article_chapter_pages acp
					WHERE ac.id = acp.article_chapter_id
					 ";
		//$sqlQuery .= " AND ac.id = 127195";
		$sqlQuery .= " AND acp.content LIKE ";
		$sqlQuery .= $querycond;
		//$sqlQuery .= "'%include \"quiz/javascript.php\";%'";
		print "id" . "\t";
		print "content" . "\n";

		foreach ($this->db_link->query($sqlQuery) as $row) {
			print $row['id'] . "\t";
			print $row['acp'] . "\t";
			print $row['article_id'] . "\t";
			$this->__writeIdToFile($type, $row['article_id']);
			//print $row['content'] . "\n";
			$content = preg_replace("/(\<\?|\?\>)/", "", $row['content']);
			//var_dump($content);
			list($quizId, $questitId, $path) = explode(";", $content);
			$idToCheck = ($type === "questit" ? $questitId : $quizId);
			//var_dump($idToCheck);
			list($varName, $oTestId) = explode("=", $idToCheck);

			echo trim($oTestId) . "\n";
			$testId = trim($oTestId);
			if (preg_match("/[0-9]+/", $testId)) {
				$this->__updateQuery(array("qId" => trim($testId), "recordId" => $row['acp']), $type);
			}
			//echo "<br />";
		}
	}

	private function __updateQuery($param, $type = "questit") {
		$placeHolders = array();
		$placeHolders['questit'] = "<onmeda:questit id=\"##ID##\"></onmeda:questit>";
		$placeHolders['quiz'] = "<onmeda:quiz id=\"##ID##\"></onmeda:quiz>";
		$tag = $placeHolders[$type];
		$qId = $param['qId'];
		/*Check if exists first*/
		$query = "SELECT id FROM quizzes WHERE original_quest_id = " . $qId;
		if ($type == "quiz") {
			$query = "SELECT id FROM quizzes WHERE id = " . $qId;
		}

		//$result = $this->db_link->query($query, PDO::FETCH_ASSOC);
		$result = $this->db_link->prepare($query);
		$result->execute();
		$row = $result->fetch();

		if ($row) {

			$qId = $row['id'];
			$replaceTag = str_replace("##ID##", $qId, $tag);
			$strSql = "UPDATE article_chapter_pages SET content = '" . $replaceTag . "' WHERE id = " . $param['recordId'];
			echo $strSql . "\n";
			//$q = $this->db_link ->prepare($strSql);
			//var_dump($q);
			//$q->execute(array($replaceTag, $id));
		}
	}

	private function __writeIdToFile($fileName, $id) {
		$mode = "a+";
		if (file_exists(APP_PATH . "/" . $fileName . '.txt')) {			
			//unlink(APP_PATH . "/" . $fileName . '.txt');
		}
		$fp = fopen(APP_PATH . "/" . $fileName . '.txt', $mode);
		fwrite($fp, $id . "\n");
		fclose($fp);
	}
	
}

?>