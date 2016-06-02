<?php

global $START_MICROTIME;
$batch_run_time_in_secs = 5;	// run for 2 seconds per request

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

$insert_in_text = array();
$str_id = elgg_get_metastring_id('set_personal_subscription');
$val_id = elgg_get_metastring_id('0');

$dbprefix = elgg_get_config('dbprefix');


do {

	$query = "SELECT guid, username FROM {$dbprefix}users_entity u LEFT JOIN (SELECT * FROM {$dbprefix}metadata WHERE name_id = {$str_id}) md ON u.guid = md.entity_guid  WHERE md.value_id IS NULL OR md.value_id = {$val_id} ORDER BY u.guid DESC LIMIT {$limit}";
	$users = get_data($query);

	if (count($users) <= 0)
		break;

	foreach ($users as $user) {

		//$user_option = elgg_get_plugin_user_setting('cpn_set_optout', $user->guid, 'cp_notifications');
		// check if user is ElggUsers AND personal_subscription is not-set/false AND user is opt-in
		//if ($user_option === 'auto_sub' || !isset($user_option)) {

			$contents = get_data(get_content($user->guid));

			// each user go through their user-generated content
			foreach ($contents as $content) {	
				create_relationship($user, $content);
			}

		//} else {
			register_error("user {$user->guid} ({$user->username}) opted-out of subscription script)");
			$error_count++;
		//}

		create_metadata($user->guid, 'set_personal_subscription', true);
		update_timestamp($user);
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



/* helper functions below */


function update_timestamp($user) {
	$dbprefix = elgg_get_config('dbprefix');
	$str_id = elgg_get_metastring_id('set_personal_subscription');
	$query = "UPDATE {$dbprefix}metadata SET time_created = ".time()." WHERE entity_guid = {$user->guid} AND name_id = {$str_id}";
	update_data($query);
}

/* create_relationship()
 * creates the relationship for each content created by the user
 * returns bool
 */
function create_relationship($user, $content) {
	$result_email = add_entity_relationship($user->guid, 'cp_subscribed_to_email', $content->guid);
	$result_site_mail = add_entity_relationship($user->guid, 'cp_subscribed_to_site_mail', $content->guid);
}



/* get_content()
 * returns the query for all the content that the user is associated with
 */
function get_content($user_guid) {
	$dbprefix = elgg_get_config('dbprefix');
	$subscribe_to = array('file','blog','thewire','hjforumtopic','hjforum','poll','groupforumtopic','bookmarks','image','album','event_calendar','page_top','task_top','task',);

	$query_content = "SELECT e.guid, es.subtype FROM {$dbprefix}entities e, {$dbprefix}entity_subtypes es WHERE {$user_guid} = e.owner_guid AND {$user_guid} = e.container_guid AND e.subtype = es.id AND (";

	// cyu - query only those contents that are of concern
	$count = 0;
	foreach ($subscribe_to as $subtype_name) {
		if ($count == 0)
			$query_content .= "es.subtype = '{$subtype_name}' ";
		else
			$query_content .= "OR es.subtype = '{$subtype_name}' ";
		$count++;
	}
	$query_content .= ")";

	error_log("query - {$query_content}");
	return $query_content;
}
