<?php
class HomeController extends ShellController {

	public $models;
	private $__defaultFileName = "funke_mailing";
        
        
	public function __construct() {
		
		parent::__construct();
		require DB_CONFIG_PATH;
		
		$this->uses = array("base");
                
		$this->models = $this->load->dbModels(APP_PATH_MODEL, $this->uses, new database());
                

	}
	
	public function indexAction() {
		$this->printLine("test");
                $bookings = $this->models['Base']->getBookings();
                $header = array(
                    "id", "booking_id", "email", "ip", "generated_on"
                );
                array_unshift($bookings, $header);
                $count = 0;
                $fileName = $this->__defaultFileName . "_" . $this->__getTimeStamp() . "" . FILE_ENDING;
                $fp = fopen(CSV_FILE . "/" . $fileName, "w");
                
                
                foreach ($bookings as $bk => $booking) {
                    
                    fputcsv($fp, $booking, ";");
                    $count++;
                }
                
                $this->printLine($count . " recordset counted");
                $this->printLine("File saved as " . $fileName);
                fclose($fp);
	}
	
	public function quoteAction() {
	
	
	}
        
        public function goAction() {
            echo "blablabla ";
        }
        
        private function __getTimeStamp() {
            $dt = date("YmdHis") . $this->__microtimeFloat();
            return $dt;
        }
        
        private function __microtimeFloat() {
            list($usec, $sec) = explode(" ", microtime());
            $complete = $usec . $sec;
            $strSec = str_replace(".", "", $complete);
            return ($strSec);
        }
        
}
?>