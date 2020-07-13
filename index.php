<?php




class Institution {
	
	public $name;
	public $stateCode;
	public $policyType;
	public $sourceLink;
	
	public function __construct( $databaseArray ) {
		$this->name = $databaseArray[0];
		$this->stateCode = $databaseArray[1];
		$this->policyType = $databaseArray[2];
		$this->sourceLink = $databaseArray[3];
		$this->getCoordinates();
	}
	
	
}



class Tracker {
	
	
	public function getData() {
		$myfile = fopen("data-w8lLG.csv", "r") or die("Unable to open file!");
		$myData = fread($myfile,filesize("data-w8lLG.csv"));
		fclose($myfile);
	}

}


?>