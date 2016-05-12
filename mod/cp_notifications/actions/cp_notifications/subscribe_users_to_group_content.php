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

// list of entities that do not require to be subscribed
$do_not_subscribe_strings = array('messages', 'widget', 'poll_choice', 'discussion_reply', 'folder');
foreach ( $do_not_subscribe_strings as $dns_string ){
	$do_not_subscribe[$dns_string] = get_data("SELECT id FROM {$db_prefix}entity_subtypes WHERE subtype = '$dns_string'")[0]->id;
}

$str_id = elgg_get_metastring_id('subscribed_to_all_group_content', true);	// get the metastring id, create the metastring if it does not exist

$success_count = 0;
$error_count = 0;

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
		$user = get_user( $user_guid->guid );
		$user_option = elgg_get_plugin_user_setting('cpn_set_optout', $user->guid, 'cp_notifications');
		if ( $user_option === 'auto_sub' || !isset($user_option) ){
			$groups = $user->getGroups();
			foreach ( $groups as $group ) {
				$guid = $group->getGUID();
				if ($guid) {
					// first, subscribe to the group
					add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group->getGUID());
					add_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group->getGUID());
					// get group content
					/*$content = elgg_get_entities(array(
						'container_guid' => $guid,
					));*/
					$content = get_data("SELECT guid, subtype FROM {$db_prefix}entities WHERE container_guid = {$guid}");
					foreach ( $content as $item ) {
						// check entity is part of notifications
						if ( !in_array($item->subtype, $do_not_subscribe) ){
							$item_guid = $item->guid;
							// subscribe to the group content
							add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $item_guid);
							add_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $item_guid);
						}
					}
				}

				else {
					register_error( "error processing subscription to a group for user " . $user->getGUID() );
					$error_count++;
				}
			}
		}
		$user->subscribed_to_all_group_content = 1;
		$success_count++;
	}
} while ((microtime(true) - $START_MICROTIME) < $batch_run_time_in_secs);
access_show_hidden_entities($access_status);

// replace events and hooks
_elgg_services()->events = $original_events;
_elgg_services()->hooks = $original_hooks;

// Give some feedback for the UI
echo json_encode(array(
	'numSuccess' => $success_count,
	'numErrors' => $error_count,
));
