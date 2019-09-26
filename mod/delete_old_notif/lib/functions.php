<?php

// Base on cp_notification
function initialize_queue( $frequency ){
	$dbprefix = elgg_get_config('dbprefix');

	try{
		# get user guid list and insert them all into the queue  ... maybe get it to filter by $frequency too
		// $query = "INSERT INTO notification_digest_queue (user_guid) SELECT entity_guid as user_guid FROM {$dbprefix}private_settings WHERE name = 'plugin:user_setting:cp_notifications:cpn_set_digest' AND value = 'set_digest_yes'";
		// $result = insert_data($query);
	} catch (Exception $e) {/* let mysql take care of duplicate instert attempts */}
	
	sleep(60);		// can certainly be done in a better way, but this is simplest and is unlikely to cause duplicates or unsent digests.
	
	return 0;
}