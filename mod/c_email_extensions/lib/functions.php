<?php

function requirements_check()
{
	global $CONFIG;

	$db_config = new \Elgg\Database\Config($CONFIG);
	if ($db_config->isDatabaseSplit()) {
		$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::WRITE);
	} else {	
		$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::READ_WRITE);
	}

	$query = "CREATE TABLE IF NOT EXISTS email_extensions (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), ext char(30), dept char(255))";

	$connection = mysqli_connect($read_settings["host"], $read_settings["user"], $read_settings["password"], $read_settings["database"]);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	//mysqli_free_result($result);
	mysqli_close($connection);

	return true;
}

function getExtension() 
{
	global $CONFIG;

	$db_config = new \Elgg\Database\Config($CONFIG);
	if ($db_config->isDatabaseSplit()) {
		$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::READ);
	} else {	
		$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::READ_WRITE);
	}

	$query = "SELECT * FROM email_extensions";

	$connection = mysqli_connect($read_settings["host"], $read_settings["user"], $read_settings["password"], $read_settings["database"]);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	//mysqli_free_result($result);
	mysqli_close($connection);
	return $result;
}

function addExtension($ext, $dept)
{
	global $CONFIG;

	$db_config = new \Elgg\Database\Config($CONFIG);
	if ($db_config->isDatabaseSplit()) {
		$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::WRITE);
	} else {	
		$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::READ_WRITE);
	}

	$query = "INSERT INTO email_extensions (ext, dept) VALUES ('".$ext."','".$dept."')";
	//elgg_log('cyu - query:'.$query, 'NOTICE');

	$connection = mysqli_connect($read_settings["host"], $read_settings["user"], $read_settings["password"], $read_settings["database"]);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	//mysqli_free_result($result);
	mysqli_close($connection);
	return $result;
}

function deleteExtension($id)
{
	global $CONFIG;

	$db_config = new \Elgg\Database\Config($CONFIG);
	if ($db_config->isDatabaseSplit()) {
		$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::WRITE);
	} else {	
		$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::READ_WRITE);
	}

	$query = "DELETE FROM email_extensions WHERE id=".$id;
	//elgg_log('cyu - query:'.$query, 'NOTICE');

	$connection = mysqli_connect($read_settings["host"], $read_settings["user"], $read_settings["password"], $read_settings["database"]);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	//mysqli_free_result($result);
	mysqli_close($connection);
	return $result;
}

function editExtension($id, $ext, $dept)
{
	global $CONFIG;

	$query = "UPDATE email_extensions SET ext='".$ext."', dept='".$dept."' WHERE id=".$id;

	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	mysqli_close($connection);
	return $result;
}