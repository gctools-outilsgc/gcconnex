<?php

require_once "engine/settings.php";		// get the elgg settings, in particular the settings for all the db server(s) that will be tested. This location may need to be adjusted for different versions of Elgg
global $CONFIG;

// array of queries to be used to test db performance and proper use of indexes
// each entry needs to be an array containing the query and a critical excecution time in ms that when excceeded whould indicate a failed test
// example: $test_queries[] = array("select * from *", 0.15);
$test_queries = array();
$test_queries[] = array();

$results = array();			// results of the tests defined by $test_queries 


// check if we're testing a single db server at a split configuration
if ( !isset($CONFIG->db['split']) || $CONFIG->db['split'] == false ){
	// only a single db connection needs testing
	$connection = mysqli_connect( $CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname );
	// TODO: check for connection errors
}
else {
	// initialize with the write connection
	$connections = array( mysqli_connect( $CONFIG->db['write']['dbhost'], $CONFIG->db['write']['dbuser'], $CONFIG->db['write']['dbpass'], $CONFIG->db['write']['dbname'] ) );

	// now add all the read servers
	foreach( $CONFIG->db['read'] as $dbread ){
		$connections[] = mysqli_connect( $dbread['dbhost'], $dbread['dbuser'], $dbread['dbpass'], $dbread['dbname'] );
		// TODO: check for connection errors
	}
}


// now that the connections are ready, run the tests and record the results

?>