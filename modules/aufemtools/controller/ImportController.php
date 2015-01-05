<?php

class ImportController extends ShellController {

	public function aspFilesAction () {
		$data['headerTitle'] = "Asp Import";
		$data['msg'] = "";

		$checkFile = file_exists(JSONFILENAME);

		if ($checkFile) {
			//Import and PArse here
			$jsonObject = new stdClass();
			$jsonObject->obj = json_decode(file_get_contents(JSONFILENAME));
			$allSites = $jsonObject->obj->sites;
			//var_dump($allSites->wewomen[0]);
			//var_dump($jsonObject->obj->sites);
			$this->__parse($allSites);

		}

		$this->load->view(__METHOD__, $data);
	}

	private function __parse($obj) {

		foreach ($obj as $siteName => $value) {
			$param = array();

				//echo $siteName . "\n";
				while (list($domain, $values) = each($value)) {

					if (property_exists($values, 'DOMAIN') && !is_array($value)) {
						$param['DOMAIN'] = $values->{"DOMAIN"};
						$param['SECTION'] = $values->{"SECTION"};
						$param['TOOLNAME'] = $values->{"TOOLNAME"};
						$param['FILENAME'] = $values->{"FILENAME"};
						$param['URL'] = $values->{"URL"};
						//$param['FILENAME'] = "default6.asp";
						$param['TYPE'] = $values->{"TYPE"};
						$param['SITENAME'] = $values->{"SITENAME"};
						$param['HOST'] = "http://www." . $values->{"SITENAME"} . "." . $values->{"DOMAIN"};
						$this->__createAspFiles($param);
						//true if create mobile asp file
						$this->__createAspFiles($param, true);
						echo $values->{"DOMAIN"} . "\n";

					} else {
						//var_dump($values);
						$val = new stdClass();
						$val->subobj = $values;
						//var_dump($val->subobj->{"be"});
						$this->__parse($val);
					}
				}
		}
	}

	private function __createAspFiles($param = array(), $mobileFile = false) {
		$pathToCopy = TOOLPATHDIST . $param['SITENAME'] . "." . $param['DOMAIN'];
		if (file_exists($pathToCopy)) {
			$source = (!$mobileFile ? ASP_DEFAULT_FILE : ASP_MOB_DEFAULT_FILE);
			$wholeFile = file_get_contents($source);
			$search = array("##TYPE##", "##SECTION##", "##TOOLNAME##", "##FILENAME##", "##HOST##", "##URL##");
			$replace = array($param['TYPE'], $param['SECTION'], $param['TOOLNAME'], $param['FILENAME'], $param['HOST'], $param['URL']);
			$fileName = $param['FILENAME'];
			if ($mobileFile) {
				//array_push($search, "##HOST##");
				//array_push($replace, $param['HOST']);
				$fileName = "mobile/default2.asp";
			}
			$newFile = str_replace($search, $replace, $wholeFile);
			$this->__writeFile($newFile, $pathToCopy, $fileName);
		}
	}

	private function __writeFile($fileAsString, $path, $fileName = "default5.asp") {
		$handler = fopen($path . "/" . $fileName, "w+");
		$success = false;
		if ($handler) {
			fwrite($handler, $fileAsString);
			fclose($handler);
			$success = true;
		}

		return $success;
	}
	
}