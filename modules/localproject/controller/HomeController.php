<?php

class HomeController extends ShellController {
    public function indexAction($t, $x) {
        $this->printLine("test" . "=>" . $t.$x);
    }
}