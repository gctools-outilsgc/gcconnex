<?php
	$user ='root';
	$password='';
	$dbname='elgg2';
	
	$db = new mysqli('localhost', $user, $password, $dbname) or die("Unable to connect to the database.");	


	$name = $_POST['name'];
	$email= $_POST['email'];
	$departure=$_POST['start'];
	$destination=$_POST['end'];
	$time=$_POST['time'];
	$capacity=$_POST['capacity'];
	$music=$_POST['music'];
	$addC=$_POST['addcomments'];
	$date = $_POST['startDate'];

	$countQuery = ($db->query('select * from Route'));
	$count = mysqli_num_rows($countQuery);

	$sql="INSERT INTO Route (
		RouteID, 
		Departure,
		Destination, 
		TimeOfDeparture, 
		Music, 
		Capacity, 
		StartDate, 
		DriverName, 
		DriverEmail, 
		AdditionalComments, 
		Status) 
		VALUES(
		 '$count ',
		 '$departure ', 
		 '$destination',
		 '$time',
		 '$music',
		 '$capacity',
		 '$date',
		 '$name',
		 '$email',
		 '$addC', 
		 '1')";



	if($db->query($sql) == TRUE){
		echo"<script type='text/javascript'>alert('Successfully Posted! Thank you!');</script>";
	}else{
		echo "<script type='text/javascript'>alert('error');</script>"; 
		//Error here. Maybe transfering the data from the javascript...
		//Right format in connect.php
	}
	$db->close();
?>