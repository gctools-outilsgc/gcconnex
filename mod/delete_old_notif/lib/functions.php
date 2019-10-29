<?php

// Base on cp_notification
function initialize_list( $cutoff_timestamp ){
	$dbprefix = elgg_get_config('dbprefix');
	$message_subtype = get_subtype_id( 'object', 'messages' );
	$fromId = elgg_get_metastring_id('fromId'); 

	# get user guid list of old notifications and insert them all into a temp table
	$query_table = "CREATE TABLE tmp_notify_delete_list ( `guid` bigint(20) unsigned NOT NULL, PRIMARY KEY (`guid`) )";
	$query = "INSERT INTO tmp_notify_delete_list (guid) SELECT e.guid FROM {$dbprefix}entities e 
LEFT JOIN {$dbprefix}metadata msg_fromId on e.guid = msg_fromId.entity_guid 
LEFT JOIN {$dbprefix}metastrings msvfrom ON msg_fromId.value_id = msvfrom.id 
LEFT JOIN {$dbprefix}entities efrom ON msvfrom.string = efrom.guid 
WHERE e.subtype=$message_subtype AND e.time_created < {$cutoff_timestamp} 
AND msg_fromId.name_id='{$fromId}' AND efrom.type <> 'user'";

	try{
		$result_table = insert_data($query_table);
		$result = insert_data($query);
	} catch (Exception $e) {/* let mysql take care of duplicate insert attempts and trivialize leader election*/ echo $e; return 1; }
	
	return 0;
}



function delete_notifications(){
	$dbprefix = elgg_get_config('dbprefix');

	$delete_entities = "DELETE FROM {$dbprefix}entities WHERE guid IN (SELECT guid FROM tmp_notify_delete_list)";
	$delete_objects = "DELETE FROM {$dbprefix}objects_entity WHERE guid IN (SELECT guid FROM tmp_notify_delete_list)";
	$delete_metadata = "DELETE FROM {$dbprefix}metadata WHERE entity_guid IN (SELECT guid FROM tmp_notify_delete_list)";
	$cleanup_tmp = "DROP TABLE tmp_notify_delete_list";


	delete_data($delete_entities);
	delete_data($delete_objects);
	delete_data($delete_metadata);
	delete_data($cleanup_tmp);
}