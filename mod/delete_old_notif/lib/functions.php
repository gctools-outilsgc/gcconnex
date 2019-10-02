<?php

// Base on cp_notification
function initialize_list( $cutoff_timestamp ){
	$dbprefix = elgg_get_config('dbprefix');
	$message_subtype = ;
	$fromId = elgg_get_metastring_id('fromId'); 

	# get user guid list of old notifications and insert them all into a temp table
	$query_table = "CREATE TABLE tmp_notify_delete_list ( `guid` bigint(20) unsigned NOT NULL, PRIMARY KEY (`guid`) )";
	$query = "INSERT INTO tmp_notify_delete_list (guid) SELECT guid FROM {$dbprefix}entities 
		LEFT JOIN {$db_prefix}metadata msg_fromId on e.guid = msg_fromId.entity_guid
		LEFT JOIN {$db_prefix}metastrings msvfrom ON msg_fromId.value_id = msvfrom.id
		LEFT JOIN {$db_prefix}entities efrom ON msvfrom.string = efrom.guid 
		WHERE e.subtype=$message_subtype AND e.time_created < {$cutoff_timestamp}
		AND msg_fromId.name_id='{$fromId}' AND efrom.type <> 'user'";

	try{
		$result_table = insert_data($query_table);
		$result = insert_data($query);
	} catch (Exception $e) {/* let mysql take care of duplicate insert attempts and trivialize leader election*/ return 1; }
	
	return 0;
}



function delete_notifications(){
	#do stuff
}