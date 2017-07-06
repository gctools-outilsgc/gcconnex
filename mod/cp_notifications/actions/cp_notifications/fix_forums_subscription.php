<?php

elgg_load_library('elgg:gc_notification:functions');

global $START_MICROTIME;
$batch_run_time_in_secs = 5;

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
$str_id = elgg_get_metastring_id('fix_forum_subscriptions');
$val_id = elgg_get_metastring_id('0');

$dbprefix = elgg_get_config('dbprefix');




do {

	// get all the forums subscribed by users
	$query = "	SELECT r1.guid_one, r1.guid_two, e.container_guid, es.subtype, r1.relationship
				FROM elggentity_relationships r1 
				    LEFT JOIN elggentities e ON r1.guid_two = e.guid
				    LEFT JOIN elggentity_subtypes es ON es.id = e.subtype
				    LEFT JOIN elggusers_entity ue ON ue.guid = r1.guid_one
				WHERE r1.relationship like 'cp_subscribed_to%' AND es.subtype like 'hj%'
				GROUP BY r1.guid_one, r1.guid_two";

	// contains everything that is related to the forums
	$forums = get_data($query);
	$invalid_forums = array();

	// find all the invalid forums (users that are not members of a particular group that the forum resides in)
	foreach ($forums as $forum) {
		$group_id = get_forum_in_group($forum->guid_two, $forum->guid_two);
		$relationship = check_entity_relationship($forum->guid_one, 'member', $group_id);
		
		// check if the user is a member of the group indicated
		if (!($relationship instanceof ElggRelationship)) {
			$invalid_forums[] = "{$forum->guid_one}|{$forum->guid_two}|{$group_id}";
		}
	}

	// this condition will break the while loop, it means everything has been fixed
	if (count($invalid_forums) <= 0 || !$invalid_forums) 
		break;

	foreach ($invalid_forums as $invalid_forum) {
		$item = explode('|', $invalid_forum);
		remove_entity_relationship($item[0], 'cp_subscribed_to_email', $item[1]);
		remove_entity_relationship($item[0], 'cp_subscribed_to_site_mail', $item[1]);

		$success_count++;
	}
 

} while ((microtime(true) - $START_MICROTIME) < $batch_run_time_in_secs);



// END SCRIPT, FINISH CLEANING UP THE STUFF AFTER
access_show_hidden_entities($access_status);

// replace events and hooks
_elgg_services()->events = $original_events;
_elgg_services()->hooks = $original_hooks;

echo json_encode(array(
	'numSuccess' => $success_count,
	'numErrors' => $error_count,
));

