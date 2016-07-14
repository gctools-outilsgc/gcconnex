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
$str_id = elgg_get_metastring_id('fixing_notification_inconsistencies');
$val_id = elgg_get_metastring_id('0');

$dbprefix = elgg_get_config('dbprefix');


do {
	$query = "	SELECT r1.guid_one as user_id, r1.guid_two as group_id
				FROM {$dbprefix}entity_relationships r1
				LEFT OUTER JOIN {$dbprefix}entity_relationships r2 ON r1.guid_two = r2.guid_two AND r2.relationship = 'member' AND r1.guid_one = r2.guid_one
				WHERE
					r1.guid_one IN (SELECT guid FROM {$dbprefix}users_entity)
					AND r1.relationship LIKE 'cp_subscribed_to%'
					AND r1.guid_two IN (SELECT guid FROM {$dbprefix}groups_entity)
					AND r2.relationship is null";

	$users = get_data($query);

	if (count($users) <= 0 || !$users)
		break;

	foreach ($users as $user) {
		// remove the group notifications
		remove_entity_relationship($user->user_id, 'cp_subscribed_to_email', $user->group_id);
		remove_entity_relationship($user->user_id, 'cp_subscribed_to_site_mail', $user->group_id);

		$contents = get_data(get_group_content($user->group_id));
		foreach ($contents as $content) {
			// remove each group content
			remove_entity_relationship($user->user_id, 'cp_subscribed_to_email', $content->guid);
			remove_entity_relationship($user->user_id, 'cp_subscribed_to_site_mail', $content->guid);
		}
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





/* get_content()
 * returns the query for all the content that the user is associated with
 */
function get_group_content($group_id) {
	$dbprefix = elgg_get_config('dbprefix');
	$subscribe_to = array('file','blog','poll','groupforumtopic','bookmarks','image','album','event_calendar','page_top','task_top','task',);

	$query_content = "SELECT e.guid, es.subtype FROM {$dbprefix}entities e, {$dbprefix}entity_subtypes es WHERE {$group_id} = e.container_guid AND e.subtype = es.id AND (";

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

	return $query_content;
}
