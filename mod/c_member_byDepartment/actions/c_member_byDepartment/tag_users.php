<?php

error_log('cyu - tag users action invoked');

global $CONFIG;
$query = "SELECT e.guid, ue.email, ue.username FROM elggentities e, elggusers_entity ue WHERE e.type = 'user' AND e.guid = ue.guid AND e.enabled = 'yes'";

$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
if (mysqli_connect_errno($connection)) elgg_log("Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
$result = mysqli_query($connection,$query);
mysqli_close($connection);

$tagging_members = array();
while ($row = mysqli_fetch_array($result)) {
	$department = $row['email'];
	$department = explode('@',$department);
	$department = explode('.',$department[1]);
	$tagging_members[$row['username']] = strtoupper($department[0]);
}

$today = date("YmdHis");
$data_directory = $CONFIG->dataroot.'gc_dept'.DIRECTORY_SEPARATOR;
if (is_array($tagging_members)) {
	error_log('cyu - this is an array to location: '.$data_directory.'tagged_members_'.$today);
	$write_as_backup = file_put_contents($data_directory.'tagged_members_'.$today.'.json', json_encode($tagging_members));
}

error_log('cyu - write status: '.$write_as_backup.' /// size of array: '.count($tagging_members));
forward(REFERER);