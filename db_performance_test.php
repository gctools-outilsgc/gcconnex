<?php

require_once "engine/settings.php";		// get the elgg settings, in particular the settings for all the db server(s) that will be tested. This location may need to be adjusted for different versions of Elgg
global $CONFIG;

// array of queries to be used to test db performance and proper use of indexes
// each entry needs to be an array containing the query and a critical excecution time in ms that when excceeded whould indicate a failed test
// example: $test_queries[] = array("sql" => "select * from *", "time" => 0.15, "");
// time is in milliseconds!
$test_queries = array();
$test_queries[] = array();

$results = array();			// results of the tests defined by $test_queries, string of 1/0/E for pass/fail/error for each db connection
$fails = array();			// Details about each failed test, grouped by db connection
$errors = array();			// Details about each errored test, grouped by db connection

$connections = array();		// array containing connections to db services to be tested

// check if we're testing a single db server at a split configuration
if ( !isset($CONFIG->db['split']) || $CONFIG->db['split'] == false ){
	// only a single db connection needs testing
	$connections["ReadWrite"] = mysqli_connect( $CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname );
	// TODO: check for connection errors
}
else {
	// start with the write connection
	$connections["write"] = mysqli_connect( $CONFIG->db['write']['dbhost'], $CONFIG->db['write']['dbuser'], $CONFIG->db['write']['dbpass'], $CONFIG->db['write']['dbname'] );

	// now add all the read servers
	foreach( $CONFIG->db['read'] as $id => $dbread ){
		$connections['read'.$id] = mysqli_connect( $dbread['dbhost'], $dbread['dbuser'], $dbread['dbpass'], $dbread['dbname'] );
		// TODO: check for connection errors
	}
}


// now that the connections are ready, run the tests and record the results
if ( count( $connections ) > 0 ){
	echo "Database connection(s) created, preparing tests.";
	// tests will be run on each connection
	foreach ($connections as $id => $connection) {
		echo " \nTests for DB {$id}: \n";
		// run all prepared tests using the connection
		foreach ($test_queries as $test) {
			// each test contains the test query as well as some relevant data, load it now
			$sql = $test["sql"];
			$time = $test["time"];

			// run and time the execution of the test query, we don't actually need the result, but a check for errors will be done
			$t_0 = microtime(true);
			$result = $connection->query($sql);
			$t_1 = microtime(true);

			// check for errors, mark the test as an error if that is the case
			if ( $result === false ){
				echo "E";
				$results[$id]	.= "E";
				$errors[$id][]	= "Error attempting query: {$sql}";
				continue;
			}

			// check if the query execution time passes the set test time and report it as 1 for a pass and 0 for a fail
			if ( $t_1 - $t_0 >= $time ){
				echo "0";
				$results[$id]	.= "0";
				$fails[$id][]	= "Following query ran in " . $t_1 - $t_0 . "ms >= {$time}ms: [$sql]"; 
			}
			else{
				echo "1";
				$results[$id]	.= "1";
			}
		}

		$connection->close();		// close the connection now that all tests have finished for it
	}

	// report the results
	foreach ($results as $key => $res_string) {
		echo "Tests for databse $key: $res_string";
	}
}
else { echo "No connections loaded"; }

?>