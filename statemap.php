<?php
include('tracker.php');

class coronaStateMap {
	
	public $stateArray;
	public $institutionArray;
	public $stateCollegeArray;
	public Tracker $tracker;
	public $institutionCount;
	public $stateColors;
	
	public function __construct( $tracker ) {
		$this->stateArray = ['AK', 'AL', 'AR', 'AS', 'AZ', 'CA', 'CO', 'CT', 'DC', 'DE', 'FL', 'GA', 'GU', 'HI', 'IA', 'ID', 'IL', 'IN', 'KS', 'KY', 'LA', 'MA', 'MD', 'ME', 'MI', 'MN', 'MO', 'MP', 'MS', 'MT', 'NC', 'ND', 'NE', 'NH', 'NJ', 'NM', 'NV', 'NY', 'OH', 'OK', 'OR', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UM', 'UT', 'VA', 'VI', 'VT', 'WA', 'WI', 'WV', 'WY'];
		$this->institutionArray = $tracker->fullInstitutionArray;
		foreach($this->stateArray as $stateCode) {
			$this->stateCollegeArray[$stateCode] = [];
		}
		foreach( $this->institutionArray as $institution) {
			if (strpos($institution->policyType, "online") === FALSE) {
				$this->stateCollegeArray[$institution->stateCode][] = $institution;
			}
		}
		foreach($this->stateArray as $stateCode) {
			$this->institutionCount[$stateCode] = count($this->stateCollegeArray[$stateCode]);
		}
		$this->setColors();
	}
	
	public function getMap() {
		$stateCountHTML = "<div>";
		$stateColors = " stateSpecificStyles: {";
		foreach( $this->stateArray as $stateCode) {
			if ($stateCode != 'AK') $stateColors .= ",";
			$count = $this->institutionCount[$stateCode];
			$color = $this->stateColors[$stateCode];
			$stateColors .= "'$stateCode': {fill:'".$color."'}";
			$stateCountHTML .= "<span>$stateCode:".$count."</span><br />";
			
		}
		$stateCountHTML .= "</div>";
		$stateColors .= "  }";
	
		$myHTML = "
				<html>
					<head>
						<title>College Coronavirus Tracker</title>
						<script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
						 <script src='../raphael/raphael-min.js'></script>
						<script src='../us-map/jquery.usmap.js'></script>
						<script> 
							$(document).ready(function() {
								$('#map').usmap({ 
									$stateColors, 
						  click: function(event, data) {
							$('#clicked-state')
							  .text('You clicked: '+data.name)
							  .parent().effect('highlight', {color: '#C7F464'}, 2000);
						  }
								});
							  });
						</script>
					</head>
					<body><div id='map' style='width: 1000px; height: 800px;'></div>
					<div id='clicked-state'></div>
					$stateCountHTML
					</body></html>"; 
		return $myHTML;
			
		
	}
	
	public function setColors( ) {
		$maxInstitutionCount = max( $this->institutionCount );
		$interval = floor(255/$maxInstitutionCount);
		foreach($this->stateArray as $stateCode) {
			$this->stateColors[$stateCode] = "rgb(255,255,255)";
		}
		foreach($this->institutionCount as $stateCode => $count) {
			$green = 255 - ($interval * $count);
			$blue = 255 - (floor($interval/2)* $count);
			$this->stateColors[$stateCode] = "rgb($green, $blue, $blue)";
			
			
		}
	}
	
}

$myTracker = new TrackerStateFilter();
$myMap = new coronaStateMap( $myTracker );
echo $myMap->getMap();

?>