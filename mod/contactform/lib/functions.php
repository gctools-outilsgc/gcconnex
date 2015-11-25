<?php

function requirements_check2()
{
	global $CONFIG;

	//$query = "CREATE TABLE IF NOT EXISTS contact_list (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), english char(30), francais char(255))";

	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
    
    $query = "SELECT * FROM contact_list";
	$result = mysqli_query($connection,$query);
    
    if(empty($result)){
    
    $query = "CREATE TABLE IF NOT EXISTS contact_list (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), english char(30), francais char(255))";
        
    $result = mysqli_query($connection,$query);
      baseText_check2();
    
    }
	//mysqli_free_result($result);
      
	mysqli_close($connection);

	return true;
   
}




function baseText_check2()
{
	global $CONFIG;

	$query = "INSERT INTO contact_list (english, francais) VALUES ('J\'ai Général','Bye'), ('hola','Adios')";
    
	//elgg_log('cyu - query:'.$query, 'NOTICE');

	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	//mysqli_free_result($result);
	mysqli_close($connection);
	return $result;
}

function getExtension2() 
{
	global $CONFIG;

	$query = "SELECT * FROM contact_list";

	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	//mysqli_free_result($result);
	mysqli_close($connection);
	return $result;
}

function addExtension2($english, $french)
{
	global $CONFIG;
    
    $eng = mysql_real_escape_string($english);
    $fr = mysql_real_escape_string($french);
    
	$query = "INSERT INTO contact_list (english, francais) VALUES ('".$eng."','".$fr."')";
	//elgg_log('cyu - query:'.$query, 'NOTICE');

	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	//mysqli_free_result($result);
	mysqli_close($connection);
	return $result;
}

function deleteExtension2($id)
{
	global $CONFIG;

	$query = "DELETE FROM contact_list WHERE id=".$id;
	//elgg_log('cyu - query:'.$query, 'NOTICE');

	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	//mysqli_free_result($result);
	mysqli_close($connection);
	return $result;
}