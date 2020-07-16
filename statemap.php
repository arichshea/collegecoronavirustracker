<?php

class coronaStateMap {
	
	public $stateArray;
	public $collegeArray;
	public $stateCollegeArray;
	public $coronaColor;
	
	public function __construct() {
		
	}
	
	public function getMap() {
		$stateColors = " stateSpecificStyles: {
							'MD': {fill: 'yellow'},
							'VA': {fill: 'teal'}
						  }";
	
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
						  },
								});
							  });
						</script>
					</head>
					<body><div id='map' style='width: 350px; height: 250px;'></div>
					<div id='clicked-state'></div>
					</body></html>"; 
		return $myHTML;
			
		
	}
	
	public function addData( $data ) {
		
	}
	
}

$myMap = new coronaStateMap();
echo $myMap->getMap();

?>