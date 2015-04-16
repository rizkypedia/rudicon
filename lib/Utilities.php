<?php

class Utilities {
    
    public function __construct() {
        
    }
    
    public function pc_process_dir($dirName, $maxDepth = 10, $depth = 0) {
        if ($depth >= $maxDepth) {
            error_log("Reached max depth " . $maxDepth . "in " . $dirName);
            return false;
        }
        $subdirectories = array();
        $files = array();
        
        if (is_dir($dirName) && is_readable($dirName)) {
            $d = dir($dirName);
            while (false !== ($f = $d->read())) {
                //skip . and ..
                if (('.' == $f) || ('..' == $f)) {
                    continue;
                }
                
                if (is_dir("$dirName/$f")) {
                    //array_push($subdirectories, "$dirName/$f");
              
                    $subdirectories[] = array(
                        "lastmode" => filemtime("$dirName/$f"),
                        "filename" => "$dirName/$f"
                    );
                    
                } else {
                    //array_push($files, "$dirName/$f");
                    //$files[]['lastmode'] = filemtime("$dirName/$f");
                    //$files[]['filename'] = "$dirName/$f";
                    $files[] = array(
                        "lastmode" => filemtime("$dirName/$f"),
                        "filename" => "$dirName/$f"
                    );
                }
            } // END WHILE
             $d->close();
            foreach ($subdirectories as $subdirectory) {
                $files = array_merge($files, $this->pc_process_dir($subdirectory,$maxDepth, $depth));
            }
        } 
        return $files;
    }
    
}
