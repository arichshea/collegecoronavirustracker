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
		$this->processCombinePolicySource();
	}
	
	public function processCombinePolicySource() {
		if (strpos($this->combinePolicySource, "<a") !== FALSE) {
			$this->sourceLink = $this->combinePolicySource;
			$this->policyType = explode("<", explode(">", $this->combinePolicySource)[1])[0];
		} else {
			$this->policyType = $this->combinePolicySource;
		}
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

class TrackerStateFilter extends Tracker {
	
	public function displayData() {
		$myHTML = "
	<html>
		<head>
			<title>College Coronavirus Tracker</title>
			<script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
			<script> 
			 function filterList() {
				var myFilter = $('#filterText').val();
				$('p:not(:contains('+ myFilter +'))').hide(); 
			 }
			 function resetList() {
				 $('p').show();
			 }
			</script>
		</head>
		<body>";
		$myHTML .= "<h3>Use the box below to filter the list by exact phrases. You can filter the list multiple times to narrow results. Click Reset to restore the full list.</h3><input type='text' id='filterText'/><button id='filter' onclick='filterList();'>Filter</button><button id='reset' onclick='resetList();'>Reset</button>";
		foreach ($this->fullDataArray as $institution) {
			$myHTML .= "<p>".$institution->name." ".$institution->control." ".$institution->stateCode." policyType:".$institution->policyType." sourceLink:".$institution->sourceLink."</p>";
		}
		
		$myHTML .= "</body></html>";
		
		$this->HTML = $myHTML;
	}
	
}

?>