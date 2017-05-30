<?php

require_once "engine/settings.php";		// get the elgg settings, in particular the settings for all the db server(s) that will be tested. This location may need to be adjusted for different versions of Elgg
global $CONFIG;

// array of queries to be used to test db performance and proper use of indexes
// each entry needs to be an array containing the query and a critical excecution time in ms that when excceeded whould indicate a failed test
// example: $test_queries[] = array("sql" => "select * from *", "time" => 0.15, "");
// time is in seconds!
$test_queries = array();

$prefix = $CONFIG->dbprefix;	// please use this for table names, different installations will have different prefixes
$test_queries[] = array("sql" => "select * from {$prefix}users_entity u WHERE 1 ORDER BY last_login asc LIMIT 25", "time" => 0.1);
$test_queries[] = array("sql" => "select * from {$prefix} users_entity u WHERE 1 ORDER BY last_login asc LIMIT 50", "time" => 0.15);		// test error handling
$test_queries[] = array("sql" => "SELECT COUNT(DISTINCT e.guid) as total FROM {$prefix}entities e  JOIN {$prefix}entity_relationships r on r.guid_one = e.guid  WHERE  (r.relationship = 'parent' AND r.guid_two = '24170993') AND  (e.site_guid IN (1)) AND ((e.access_id = -2 AND e.owner_guid IN ( SELECT guid_one FROM elggentity_relationships WHERE relationship = 'friend' AND guid_two = 674666 ) OR e.owner_guid = 674666 OR e.access_id IN (2,1,144,309,771,1291,1348,1482,2069,3003,3321,3769,4396,5249,6128,7077,9059,9347,9447,9681,10001,10148,10610,10669)) AND (e.enabled = 'yes'))", "time" => 1.0);
$test_queries[] = array("sql" => "SELECT DISTINCT e.*, r.id FROM {$prefix}entities e  JOIN {$prefix}entity_relationships r on r.guid_one = e.guid  JOIN {$prefix}metadata n_table on e.guid = n_table.entity_guid  JOIN {$prefix}metastrings msn on n_table.name_id = msn.id  JOIN {$prefix}metastrings msv on n_table.value_id = msv.id  WHERE  (r.relationship = 'descendant' AND r.guid_two = '7803301') AND  (((msn.string IN ('sticky')) AND (msv.string IN ('1')) AND ((n_table.access_id IN (2,-5)) AND (n_table.enabled = 'yes')))) AND  ((e.type = 'object' AND e.subtype IN (53))) AND  (e.site_guid IN (1)) AND ((e.access_id IN (2,-5)) AND (e.enabled = 'yes')) ORDER BY e.time_created desc", "time" => 0.5);
$test_queries[] = array("sql" => "SELECT DISTINCT e.*, r.id FROM {$prefix}entities e  JOIN {$prefix}entity_relationships r on r.guid_one = e.guid  JOIN {$prefix}metadata n_table on e.guid = n_table.entity_guid  JOIN {$prefix}metastrings msn on n_table.name_id = msn.id  JOIN {$prefix}metastrings msv on n_table.value_id = msv.id  WHERE  (r.relationship = 'descendant' AND r.guid_two = '7803304') AND  (((msn.string IN ('sticky')) AND (msv.string IN ('1')) AND ((n_table.access_id = -2 AND n_table.owner_guid IN ( SELECT guid_one FROM elggentity_relationships WHERE relationship = 'friend' AND guid_two = 10964415 ) OR n_table.owner_guid = 10964415 OR n_table.access_id IN (2,1,12337)) AND (n_table.enabled = 'yes')))) AND  ((e.type = 'object' AND e.subtype IN (53))) AND  (e.site_guid IN (1)) AND ((e.access_id = -2 AND e.owner_guid IN ( SELECT guid_one FROM elggentity_relationships WHERE relationship = 'friend' AND guid_two = 10964415 ) OR e.owner_guid = 10964415 OR e.access_id IN (2,1,12337)) AND (e.enabled = 'yes')) ORDER BY e.time_created desc", "time" => 0.5);
// add more test queries as needed.


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
		$connections['read '.$id] = mysqli_connect( $dbread['dbhost'], $dbread['dbuser'], $dbread['dbpass'], $dbread['dbname'] );
		// TODO: check for connection errors
	}
}


// now that the connections are ready, run the tests and record the results
if ( count( $connections ) > 0 ){
	echo "Database connection(s) created, preparing tests.";
	// tests will be run on each connection
	foreach ($connections as $id => $connection) {
		echo " \nTests for DB {$id}: \t";
		$results[$id] = "";			// initialize results string for the connection.	
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
				$fails[$id][]	= "Following query ran in " . floatval($t_1 - $t_0) . "s >= {$time}s: {$sql}"; 
			}
			else{
				echo "1";
				$results[$id]	.= "1";
			}
		}

		$connection->close();		// close the connection now that all tests have finished for it
	}


	// report any failed tests
	if ( count($fails) > 0 ){
		foreach ($fails as $db => $fail_reports) {
			if ( count($fail_reports) > 0 ){
				echo "\n\nThe following tests failed for databse $db: \n";	
				foreach ($fail_reports as $fail) {
					echo $fail . "\n";
				}
			}
		}
	}

	// report any errors that occured
	if ( count($errors) > 0 ){
		foreach ($errors as $db => $error_reports) {
			if ( count($error_reports) > 0 ){
				echo "\n\nThe following tests resulted in errors for databse $db: \n";
				foreach ($error_reports as $error) {
					echo $error . "\n";
				}
			}
		}
	}
}
else { echo "No connections loaded"; }

?>