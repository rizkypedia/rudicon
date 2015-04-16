<?php

class HomeController extends ShellController {

    public function indexAction() {
        $util = new Utilities();
        $files = $util->pc_process_dir("/home/wallywest/devs/test");
        var_dump($files);
        $msg = "Hello";
        $this->printLine($msg);
    }
    
    public function interactiveAction() {
        $fh = fopen('php://stdin', 'r');
        while ($s = fgets($fh,1024)) {
            $this->printLine("You typed " . $s);
        }
        fclose($fh);
    }
}