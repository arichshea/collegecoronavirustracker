<?php




class Institution {
	
	public $name;
	public $control;
	public $stateCode;
	public $combinePolicySource;
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
	public $HTML;
	
	public function getData() {
		$myfile = fopen("data-w8lLG.csv", "r") or die("Unable to open file!");
		$myData = fread($myfile,filesize("data-w8lLG.csv"));
		fclose($myfile);
		$this->fullData = $myData;
	}
	
	public function parseData() {
		$fullDataArrayCommas = explode("\n", $this->fullData);
		$this->fullDataArray = array();
		foreach ($fullDataArrayCommas as $record) {
			$recordArray = explode(",",$record);
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
		$myHTML = "
	<html>
		<head>
			<title>College Coronavirus Tracker</title>
		</head>
		<body>";
		foreach ($this->fullDataArray as $institution) {
			$myHTML .= "<p>".$institution->name." ".$institution->control." ".$institution->stateCode." ".$institution->combinePolicySource."</p>";
		}
		
		$myHTML .= "</body></html>";
		
		$this->HTML = $myHTML;
	}

}


$myPage = new Tracker();
echo $myPage->HTML;

?>