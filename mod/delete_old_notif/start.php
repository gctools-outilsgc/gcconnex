<?php

elgg_register_event_handler('init', 'system', 'delete_old_notif_init');

/*
 * Plugin Init
 */

function delete_old_notif_init() {
	elgg_register_library('elgg:old_notification:functions', elgg_get_plugins_path() . 'delete_old_notif/lib/functions.php');
	elgg_register_plugin_hook_handler('cron', 'weekly', 'delete_weekly_cron_handler', 100);
	elgg_register_event_handler('pagesetup', 'system', 'delete_old_notif_pagesetup');
}

function delete_weekly_cron_handler($hook, $entity_type, $return_value, $params) {
	echo "<p>Starting up the cron job for the delete old notification (delete_old_notif plugin)</p>";
	elgg_load_library('elgg:old_notification:functions');

	initialize_queue('weekly');

	delete_old_notif_handler($hook, $entity_type, $return_value, $params, 'weekly');
}

function delete_old_notif_handler($hook, $entity_type, $return_value, $params, $cron_freq) {
	$dbprefix = elgg_get_config('dbprefix');

	// delete and clean up the notification
	$query = "";
	$result = delete_data($query);

}