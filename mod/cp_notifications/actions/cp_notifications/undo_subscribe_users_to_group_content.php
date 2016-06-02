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
$limit = 50;

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

do {
	$user_guids = get_data("SELECT u.guid as guid, md.id as mid, md.time_created as m_time from {$db_prefix}users_entity u LEFT JOIN {$db_prefix}metadata md ON u.guid = md.entity_guid
		WHERE md.name_id = {$str_id}
		ORDER BY u.guid DESC 
		LIMIT {$offset}, {$limit}");

	if (!$user_guids) {
		// no users left to process
		break;
	}

	// Subscribe users to all the content in their groups
	foreach ( $user_guids as $user_guid ) {
		$user = get_user( $user_guid->guid );

		// get upper and lower bounds on when this user was processed by the original script
		$time_upper = $user_guid->m_time;
		$time_lower = $time_upper - 2;

		// get subscription relationships created for this user within this time range
		$relationships = get_data( "SELECT id FROM {$db_prefix}entity_relationships 
			WHERE guid_one = {$user_guid->guid} AND ( relationship = 'cp_subscribed_to_email' OR relationship = 'cp_subscribed_to_site_mail' )
			AND time_created > {$time_lower} AND time_created <= {$time_upper}" );
		
		foreach ( $relationships as $relationship ) {
			$id = $relationship->id;
			if ($id) {
				delete_relationship($id);
			}

			else {
				register_error( "error processing subscription to a group for user " . $user->getGUID() );
				$error_count++;
			}
		}
		
		elgg_delete_metadata_by_id($user_guid->mid);
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