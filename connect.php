<?php
	$user ='root';
	$password='';
	$dbname='elgg';
	
	$db = new mysqli('localhost', $user, $password, $dbname) or die("Unable to connect to the database.");
	echo"Nice blyat!";
	
	if($db->connect_error){
		die("Connection failed");
	}
	
	$sql="INSERT INTO Route (RouteID, DriverName,Departure,Destination) VALUES(1,'Luan', '22 Rue Eddy, Gatineau','48 Rue de Beauvallon, Gatineau')";
	if ($db -> query($sql) == TRUE){
		echo"Very Nice Blyat!";
	}else{
		echo"Not Nice Blyat :(";
	}
	$db->close();
	?>