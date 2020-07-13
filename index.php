<?php




class Institution {
	
	public $name;
	public $control;
	public $stateCode;
	public $combinePolicySource
	public $policyType;
	public $sourceLink;
	
	public function __construct( $databaseArray ) {
		$this->name = $databaseArray[0];
		$this->control = $databaseArray[1];
		$this->stateCode = $databaseArray[2];
		$this->combinePolicySource = $databaseArray[3];
	}
	
	
}



class Tracker {
	
	public $fullData;
	public $fullDataArray;
	
	public function getData() {
		$myfile = fopen("data-w8lLG.csv", "r") or die("Unable to open file!");
		$myData = fread($myfile,filesize("data-w8lLG.csv"));
		fclose($myfile);
		$this->fullData = $myData;
	}
	
	public function parseData() {
		$fullDataArrayCommas = explode(PHP_EOL, $this->fullData);
		$this->fullDataArray = array();
		foreach ($fullDataArrayCommas as $record) {
			$recordArray = explode(',', $record);
			$myInstitution  = new Institution($recordArray);
			$this->fullDataArray[] = $myInstitution;
		}
	}
	
	public function __construct() {
		$this->getData();
		$this->parseData();
		$this->displayData();
		
	}
	
	public function displayData() {
		$myHTML = <<<'EOT'
	<html>
		<head>
			<title>Tarot Card Learner</title>
			<script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
			<script src='./learnTarot.js'></script>
			<link rel="stylesheet" type="text/css" href="learnTarot.css">
		</head>
		<body>
EOT;

		foreach ($this->fullDataArray as $institution) {
			$myHTML .= "<p>".$institution->name." ".$institution->control." ".$institution->stateCode." ".$institution->combinePolicySource."</p>";
		}
		
		$myHTML = "</body></html>";
		
		echo $myHTML;
	}

}

$myPage = new Tracker();

?>