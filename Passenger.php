<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="passenger.css">
<title>
</title>
</head>
<body>
<?php
	echo"<h1>Search Results</h1>";
	echo'	<table id="columnNames";align="center"; style="width:80%;margin: auto;">
	<tr>
		<td align="left"><label>Departure</label></td>
		<td align="left"><label>Destination</label></td>
		<td align="center"><label>Starting Date</label></td>
	</tr>
	</table>';
	echo'	<div id="result" style="width:80%;height:150px;margin: auto; border: 2px solid black; overflow-y: scroll">';

	//Get the input from the user
	$departure = $_POST['departure'];
	$destination = $_POST['end'];
	$date = $_POST['startDate'];
	$time = $_POST['time'];
	$music = $_POST['music'];
 	//Connect to the database
	$user ='root';
	$password='';
	$dbname='elgg2';
	
	$db = new mysqli('localhost', $user, $password, $dbname) or die("Unable to connect to the database.");
	//Enable the search in the query
	$sql="SELECT Destination,Departure, startDate FROM ROUTE WHERE destination in ('$destination')";
	//put the result in the variable
	if($db->query($sql)==true){
		$result = $db->query($sql);
	//	$numrow = mysql_num_rows($result);
	}else{
		echo "<script type='text/javascript'>alert('error');</script>"; 
	}
/*
	if($numrow == 0){
		echo "<script type='text/javascript'>alert('No Results!');</script>";
	}else{*/
		echo"<table id='list'; cellspacing ='2px'; cellpadding = '5%' align ='center' width=100%>";
		while ($row = mysqli_fetch_assoc($result)) {
    	 		echo"<tr id='tablerow' onclick='getMap($row[Destination], $row[Departure])'>";
    	 		echo"<td align='left' > $row[Destination]</td>";
    	 		echo"<td align='left'> $row[Departure]</td>";
    	 		echo"<td align='left'> $row[startDate]</td>";
    	 		echo"</tr>";

		};
	//};
	$db->close();

	echo"</table></div>";
?>

	<br>
	<div id="map" style="width:80%;height:600px;margin: auto; border: 2px solid black"></div>
	<br>
	<button type="button" id="request" name="request">Send Request to Driver</button>

</body>

		<script>
			function initMap(){
			    var directionsService = new google.maps.DirectionsService;
				var directionsDisplay = new google.maps.DirectionsRenderer;
				var basic = new google.maps.LatLng(45.425821,-75.719821)
				var map = new google.maps.Map(document.getElementById('map'),{
					zoom: 15, center: {lat: 45.425821, lng: -75.719821}});
				var marker = new google.maps.Marker({
					position: {lat: 45.425821, lng: -75.719821},
					map: map
				});

      			  directionsDisplay.setMap(map);

      			  document.getElementById('display').addEventListener('click', function() {
          			display();
        		});
			}
			function calculateAndDisplayRoute(directionsService, directionsDisplay) {
		        var waypts = [];

		        directionsService.route({
		          origin: document.getElementById('start').value,
		          destination: document.getElementById('end').value,

		          travelMode: 'DRIVING'
		        }, function(response, status) {
		          if (status === 'OK') {
		            directionsDisplay.setDirections(response);
		            var route = response.routes[0];
		            var summaryPanel = document.getElementById('directions-panel');
		            summaryPanel.innerHTML = '';
		            // For each route, display summary information.
		            for (var i = 0; i < route.legs.length; i++) {
		              var routeSegment = i + 1;
		              summaryPanel.innerHTML += '<b>Route Segment' +
		                  '</b><br>';
		              summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
		              summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
		              summaryPanel.innerHTML += route.legs[i].distance.text + '<br>';
		              summaryPanel.innerHTML += route.legs[i].duration.text + '<br><br>';
		            }
		          } else {
		            window.alert('Directions request failed due to ' + status);
          		}
        	});
      	}

      	function getMap(departure, destination){
      			  directionsService.route({
		          origin: document.getElementById('start').value,
		          destination: document.getElementById('end').value,

		          travelMode: 'DRIVING'
		        }
      	}
		</script>
		<script 	
			 src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyB2AjldRKq1iv_sl951s7uMdFmlDXtbSWI&callback=initMap">
		</script>
</html>

