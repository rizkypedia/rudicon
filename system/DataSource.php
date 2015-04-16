<?php

/**
 * Description of DataSource
 *
 * @author hal_jordan
 */
class DataSource {
    //put your code here
    private $sourcePath;
    public $fileExtensions;
    public $credentials;
    public $files;
    
    public function __construct($files) {
        $this->files = $files;
    }
    
    public function setCredentials($crendetials) {
        
         $this->credentials = $crendetials;

    }
    
    public function getSourcePath() {
        return $this->credentials->fileCredentials['path'] . "/" . $this->credentials->fileCredentials['filename'];
    }
}
