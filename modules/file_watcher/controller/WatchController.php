<?php

class WatchController extends ShellController {
    private $util;
    
    public function indexAction() {
        $this->util = new Utilities();
        $folder ="/home/wallywest/textfiles";
        $this->printLine("Watch Folder" . $folder);
        $f = $this->util->pc_process_dir($folder);
        while (true) {
            foreach ($f as $key => $file) {
                //secho filemtime($file['filename']) . " " ;
                //echo $file['lastmode'] . "\n";
                //echo $file['filename']."\n";
                if (file_exists($file['filename'])) {
                   
                    $current = filemtime($file['filename']) ;
                    //echo $current ." = " . $file['lastmode'];
                    //echo "\n";
                    if ($current !== $file['lastmode']) {
                        echo "file: " . $file['filename'] . " was changed" ."\n";
                        $f[$key]['lastmode'] = filemtime($file['filename']);
                    }
                }
            }
        }
        
    }
    
}