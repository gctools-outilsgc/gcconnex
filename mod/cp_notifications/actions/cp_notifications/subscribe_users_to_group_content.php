<?php
/**
 * Enable all users' group content subscriptions
 * 
 * Run for 2 seconds per request as set by $batch_run_time_in_secs. This includes
 * the engine loading time.
 */

// from engine/start.php

global $START_MICROTIME;
$batch_run_time_in_secs = 2;

// Offset is the total amount of errors so far. We skip these
// comments to prevent them from possibly repeating the same error.
$offset = get_input('offset', 0);
$limit = 10;

$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

// don't want any event or plugin hook handlers from plugins to run
$original_events = _elgg_services()->events;
$original_hooks = _elgg_services()->hooks;
_elgg_services()->events = new Elgg\EventsService();
_elgg_services()->hooks = new Elgg\PluginHooksService();
elgg_register_plugin_hook_handler('permissions_check', 'all', 'elgg_override_permissions');
elgg_register_plugin_hook_handler('container_permissions_check', 'all', 'elgg_override_permissions');

$db_prefix = elgg_get_config('dbprefix');

$str_id = elgg_get_metastring_id('subscribed_to_all_group_content', true);	// get the metastring id, create the metastring if it does not exist

$success_count = 0;
$error_count = 0;
$plugin = elgg_get_plugin_from_id('cp_notifications');

do {
	$user_guids = get_data("SELECT guid from {$db_prefix}users_entity u LEFT JOIN ( SELECT entity_guid, value_id from {$db_prefix}metadata WHERE name_id = {$str_id} ) md ON u.guid = md.entity_guid 
		WHERE md.value_id IS NULL
		ORDER BY u.guid DESC 
		LIMIT {$offset}, {$limit}");

	if (!$user_guids) {
		// no users left to process
		break;
	}

	// Subscribe users to all the content in their groups
	foreach ( $user_guids as $user_guid ) {
		$guid = $user_guid->guid;

		$email_notify = get_data("SELECT e.guid as guid FROM {$db_prefix}entity_relationships r LEFT JOIN {$db_prefix}entities e ON r.guid_two = e.guid WHERE r.guid_one = {$guid} AND r.relationship = 'notifyemail' AND e.type='group'");
		$site_notify = get_data("SELECT e.guid as guid FROM {$db_prefix}entity_relationships r LEFT JOIN {$db_prefix}entities e ON r.guid_two = e.guid WHERE r.guid_one = {$guid} AND r.relationship = 'notifysite' AND e.type='group'");
		if ( $email_notify ){
			foreach ($email_notify as $group_email) {
				// subscribe to the group by email
				$status = add_entity_relationship($guid, 'cp_subscribed_to_email', $group_email->guid);
				$plugin->setUserSetting("cpn_email_{$group_email->guid}", 'sub_'.$group_email->guid, $guid);
			}
		}
		if ( $site_notify ){
			foreach ($site_notify as $group_site) {
				// subscribe to the group by email
				add_entity_relationship($guid, 'cp_subscribed_to_site_mail', $group_site->guid);
				$plugin->setUserSetting("cpn_site_mail_{$group_site->guid}", 'sub_site_'.$group_site->guid, $guid);
			}
		}

		$user = get_user( $user_guid->guid );
		$user->subscribed_to_all_group_content = 1;
		$success_count++;
	}
} while ((microtime(true) - $START_MICROTIME) < $batch_run_time_in_secs);
access_show_hidden_entities($access_status);

// replace events and hooks
_elgg_services()->events = $original_events;
_elgg_services()->hooks = $original_hooks;

if (!$user_guids) {
	// no users left to process
	echo json_encode(array(
		'numSuccess' => $success_count,
		'numErrors' => $error_count,
		'processComplete' => true,
	));
}
else{
	// Give some feedback for the UI
	echo json_encode(array(
		'numSuccess' => $success_count,
		'numErrors' => $error_count,
		'processComplete' => false,
	));
}