<?php

// If a previous version of the Set No Notification plugin was installed convert the plugin settings,
// if the old version had the former plugin name / id setNoNotifications instead of the new name / id

$current_version = elgg_get_plugin_setting('version', 'set_no_notifications');
$new_version = '1.9.3';

if (!$current_version) {

	// show hidden entities (in this case disabled plugins)
	$old_access = access_get_show_hidden_status();
	access_show_hidden_entities(true);

	$old_plugin_previously_installed = elgg_get_plugin_from_id('setNoNotifications');

	if ($old_plugin_previously_installed) {
		$old_setNoNotif_time = $old_plugin_previously_installed->setNoNotif_time;
		$old_setNoNotif_type = $old_plugin_previously_installed->setNoNotif_type;

		elgg_unset_all_plugin_settings('setNoNotifications');
	
		elgg_set_plugin_setting('setNoNotif_time', $old_setNoNotif_time, 'set_no_notifications');
		elgg_set_plugin_setting('setNoNotif_type', $old_setNoNotif_type, 'set_no_notifications');
	}

	access_show_hidden_entities($old_access);
}

if (version_compare($current_version, $new_version, '!=')) {
	// Set new version
	elgg_set_plugin_setting('version', $new_version, 'set_no_notifications');
}
