<?php

class ImportController extends ShellController {
    
    private $__replicationFile;
    
    public function infoAction($t) {
        $this->printLine("Controller: ImportController: " . $t) ;
    }
	public function aspFilesAction () {
            $this->__replicationFile = "replication.txt";
            $this->__removeFile(REPLICATION_FILE . "/" . $this->__replicationFile);
            $data['headerTitle'] = "Asp Import";
            $data['msg'] = "";

		$checkFile = file_exists(JSONFILENAME);
                //echo JSONFILENAME;
                //var_dump($checkFile);
		if ($checkFile) {
			//Import and PArse here
			$jsonObject = new stdClass();
			$jsonObject->obj = json_decode(file_get_contents(JSONFILENAME));
			$allSites = $jsonObject->obj->sites;
			
			//var_dump($jsonObject->obj->sites->gofeminin->de);
			$this->__parse($allSites);

		}

		$this->load->view(__METHOD__, $data);
	}
        
        private function __removeFile($file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
        
	private function __parse($obj) {
            //echo "Start import ..." . "\n";
          
            $content = "";
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
                                                $param['IVW'] = $values->{"IVW"};
                                                 $param['OGSHORT'] = $values->{"OGSHORT"};
                                                 $param['OGLONG'] = $values->{"OGLONG"};
                                                 $param['OGID'] = $values->{"OGID"};
                                                 $param['PAGETITLE'] = $values->{"PAGETITLE"};
                                                $param['NOADREFRESH'] = $values->{"NOADREFRESH"};
                                                 $param['SMARTPAGEID'] = $values->{"SMARTPAGEID"};
                                                 $this->printLine("Importing: " . $values->{"URL"});
                                               
						$this->__createAspFiles($param);
                                               
						//true if create mobile asp file
						$this->__createAspFiles($param, true);
						

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
                $existFile = false;
                $fileCopied = false;
                $files = array();
                $output = "";
		if (file_exists($pathToCopy)) {
                    $existFile = true;
                    //create 
                        if ($param['HOST'] !== "http://www.bildderfrau.de") {
                            $source = (!$mobileFile ? ASP_DEFAULT_FILE : ASP_MOB_DEFAULT_FILE);
                        } else {
                            $source = (!$mobileFile ? ASP_BDF_DEFAULT_FILE : ASP_BDF_MOB_DEFAULT_FILE);
                        }
			//$source = (!$mobileFile ? ASP_DEFAULT_FILE : ASP_MOB_DEFAULT_FILE);
			$wholeFile = file_get_contents($source);
			$search = array("##TYPE##", "##SECTION##", "##TOOLNAME##", "##FILENAME##", "##HOST##", "##URL##", "##IVW##", "##OGSHORT##", "##OGLONG##", "##OGID##", "##PAGETITLE##", "##NOADREFRESH##", "##SMARTPAGEID##");
			$replace = array($param['TYPE'], $param['SECTION'], $param['TOOLNAME'], $param['FILENAME'], $param['HOST'], $param['URL'], $param['IVW'], $param['OGSHORT'], $param['OGLONG'], $param['OGID'], $param['PAGETITLE'], $param['NOADREFRESH'], $param['SMARTPAGEID']);
			$fileName = $param['FILENAME'];
			if ($mobileFile) {
				//array_push($search, "##HOST##");
				//array_push($replace, $param['HOST']);
				$fileName = "mobile/" . $param['FILENAME'];
			}
			$newFile = str_replace($search, $replace, $wholeFile);
			$fileCopied = $this->__writeFile($newFile, $pathToCopy, $fileName);                       
		}
                
                if ($existFile && $fileCopied) {
                    if ($mobileFile) {
                       $this->printLine("Corresponding Files:") ;
                       $content = "##" . $param['HOST'] . "\n";
                       $content .= $param['SECTION'] . "/" . $param['TOOLNAME'] . "\n";
                       $this->__writeFile($content, REPLICATION_FILE, $this->__replicationFile, "a+");
                       $this->__walkDirectory($pathToCopy, $pathToCopy ,  $param['SECTION'] . "/" . $param['TOOLNAME']);
                       
                       $dblNewLine = "\n\n";
                       $this->__writeFile($dblNewLine, REPLICATION_FILE, $this->__replicationFile, "a+");
                       $this->printLine("\n");
                    }
                }
	}    

	private function __writeFile($fileAsString, $path, $fileName = "default5.asp", $mode = "w+") {
		$handler = fopen($path . "/" . $fileName, $mode);
		$success = false;
		if ($handler) {
			fwrite($handler, $fileAsString);
			fclose($handler);
			$success = true;
		}

		return $success;
	}
        
        private function __walkDirectory($directory, $origDirectory = "", $rplDirectory = ""){            
            $current = $directory;
            $files = array();
            $strFileContent = "";
            if (is_dir($directory)){
                $objects = scandir($directory);
                foreach ($objects as $object) {
                    
                    if ($object != "." && $object != ".." && $object !== "TMP_scripts") {
                       
                        $files[] = $directory . "/" . $object ."\n";
                        if (filetype($directory . "/" . $object) == "dir"){
                            
                             $this->__walkDirectory($directory . "/" . $object, $origDirectory, $rplDirectory);
                        } else {
                            //$directory . "/" . $object ."\n";
                            $tmp = $directory . "/" . $object ."\n";
                            $newPath = str_replace($origDirectory, $rplDirectory, $tmp);
                            $this->pprint($newPath);                 
                            $strFileContent .= $newPath;
                            
                            
                        }                        
                    } 
                }
            }
           
           $this->__writeFile($strFileContent, REPLICATION_FILE, $this->__replicationFile, "a+");
            
        }
        
        private function __repairArray($files, $src ,$dest) {
            $output = "";
            
           // echo "\n\n";
            if (is_array($files)) {
                foreach ($files as $file) {
                    //echo $file . "\n";
                    $output .= str_replace($src, $dest, $file);
                    $output .= "\n";
                }
            }
            
            return $output;
        }
	
}
