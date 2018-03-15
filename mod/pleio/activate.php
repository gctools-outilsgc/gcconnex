<?php
$result = get_data("show tables where 'pleio_request_access'");
if (count($result) === 0) {
    run_sql_script(dirname(__FILE__) . "/sql/pleio_request_access.sql");

	global $CONFIG;
	$dbprefix = elgg_get_config("dbprefix");

	$db_config = new \Elgg\Database\Config($CONFIG);
	if ($db_config->isDatabaseSplit()) {
		$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::READ);
	} else {	
		$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::READ_WRITE);
	}

	$connection = mysqli_connect($read_settings["host"], $read_settings["user"], $read_settings["password"], $read_settings["database"]);
	$query = "ALTER TABLE {$dbprefix}users_entity ADD `pleio_guid` BIGINT(20);";
	
	if (mysqli_connect_errno($connection)) elgg_log("Pleio - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	mysqli_close($connection);
}