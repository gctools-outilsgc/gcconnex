<?php

global $START_MICROTIME;
$batch_run_time_in_secs = 2;	// run for 2 seconds per request

$error_count = 0;
$success_count = 0;
$limit = 250;

$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

// don't want any event or plugin hook handlers from plugins to run
$original_events = _elgg_services()->events;
$original_hooks = _elgg_services()->hooks;
_elgg_services()->events = new Elgg\EventsService();
_elgg_services()->hooks = new Elgg\PluginHooksService();
elgg_register_plugin_hook_handler('permissions_check', 'all', 'elgg_override_permissions');
elgg_register_plugin_hook_handler('container_permissions_check', 'all', 'elgg_override_permissions');


$str_id = elgg_get_metastring_id('set_personal_subscription');
$val_id = elgg_get_metastring_id('1');

$dbprefix = elgg_get_config('dbprefix');


do {

	$query = "SELECT guid FROM {$dbprefix}users_entity u LEFT JOIN (SELECT * FROM {$dbprefix}metadata WHERE name_id = {$str_id}) md ON u.guid = md.entity_guid WHERE md.value_id IS NULL OR md.value_id = {$val_id} ORDER BY u.guid DESC LIMIT {$limit}";
	$users = get_data($query);

	if (count($users) <= 0)
		break;

	foreach ($users as $user) {
		$query = "SELECT time_created FROM {$dbprefix}metadata WHERE name_id = {$str_id} AND entity_guid = {$user->guid}";
		$metadata_obj = get_data($query);

		$start_ts = $metadata_obj[0]->time_created - 1 * 60 * 1000;
		$end_ts = $metadata_obj[0]->time_created;
		$relationships = get_data(get_content($user->guid, $start_ts, $end_ts));

		// each user go through their user-generated content
		foreach ($relationships as $relationship)
 			remove_relationship($user->guid, $relationship->guid_two);

	 	create_metadata($user->guid, 'set_personal_subscription', false);
	 	$success_count++;
	}

} while ((microtime(true) - $START_MICROTIME) < $batch_run_time_in_secs);	// do the update while it's less than 2 seconds


access_show_hidden_entities($access_status);


// replace events and hooks
_elgg_services()->events = $original_events;
_elgg_services()->hooks = $original_hooks;


echo json_encode(array(
	'numSuccess' => $success_count,
	'numErrors' => $error_count,
));




/*
 * 
 */
function get_relationship_ts($user, $content) {
	$dbprefix = elgg_get_config('dbprefix');
	$query = "SELECT time_created FROM {$dbprefix}entity_relationships WHERE guid_one = {$user->guid} AND (relationship = 'cp_subscribed_to_site_mail' OR relationship = 'cp_subscribed_to_email') AND guid_two = {$content->guid}";
	$relationship_obj = get_data($query);

	return $relationship_obj[0]->time_created;
}

/* create_relationship()
 * creates the relationship for each content created by the user
 * returns bool
 */
function remove_relationship($user_guid, $content_guid) {
	remove_entity_relationship($user_guid, 'cp_subscribed_to_email', $content_guid);
	remove_entity_relationship($user_guid, 'cp_subscribed_to_site_mail', $content_guid);
}



/* get_content()
 * returns the query for all the content that the user is associated with
 */
function get_content($user_guid, $start_ts, $end_ts) {



	$dbprefix = elgg_get_config('dbprefix');
	
	$query_content = "
			SELECT *
			 FROM {$dbprefix}entity_relationships
			 WHERE guid_one = {$user_guid} 
				 AND (relationship = 'cp_subscribed_to_email' OR relationship = 'cp_subscribed_to_site_mail')
				 AND (time_created > {$start_ts} AND time_created <= {$end_ts})";
	
	$query_content = str_replace("\n", "", $query_content);
	$query_content = str_replace("\r", "", $query_content);
	$query_content = str_replace("\t", "", $query_content);
	
	return $query_content;
}
