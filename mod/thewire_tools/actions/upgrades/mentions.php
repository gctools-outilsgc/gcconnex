<?php
/**
 * Convert thewire_tools plugin user settings to new settings
 *
 * Run for 5 seconds per request as set by $batch_run_time_in_secs. This includes
 * the engine loading time.
 */

// from engine/start.php
global $START_MICROTIME;
$batch_run_time_in_secs = 5;

if (get_input("upgrade_completed")) {
	// set the upgrade as completed
	$factory = new ElggUpgrade();
	$upgrade = $factory->getUpgradeFromPath("admin/upgrades/thewire_tools_mentions");
	if ($upgrade instanceof ElggUpgrade) {
		$upgrade->setCompleted();
	}

	return true;
}

// Offset is the total amount of errors so far. We skip these
// annotations to prevent them from possibly repeating the same error.
$offset = (int) get_input("offset", 0);
$limit = 25;

$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

// don"t want any event or plugin hook handlers from plugins to run
$original_events = _elgg_services()->events;
$original_hooks = _elgg_services()->hooks;
_elgg_services()->events = new Elgg_EventsService();
_elgg_services()->hooks = new Elgg_PluginHooksService();

elgg_register_plugin_hook_handler("permissions_check", "all", "elgg_override_permissions");
elgg_register_plugin_hook_handler("container_permissions_check", "all", "elgg_override_permissions");
_elgg_services()->db->disableQueryCache();

$success_count = 0;
$error_count = 0;

while ((microtime(true) - $START_MICROTIME) < $batch_run_time_in_secs) {

	$options = array(
		"type" => "user",
		"plugin_id" => "thewire_tools",
		"plugin_user_setting_name" => "notify_mention",
		"count" => true
	);
	$count = elgg_get_entities_from_plugin_user_settings($options);

	if (!$count) {
		// no old subscriptions left
		$factory = new ElggUpgrade();
		$upgrade = $factory->getUpgradeFromPath("admin/upgrades/thewire_tools_mentions");
		if ($upgrade instanceof ElggUpgrade) {
			$upgrade->setCompleted();
		}

		break;
	}

	$options["count"] = false;
	$options["offset"] = $offset;
	$options["limit"] = $limit;

	$users = elgg_get_entities_from_plugin_user_settings($options);
	foreach ($users as $user) {
		
		$setting = elgg_get_plugin_user_setting("notify_mention", $user->getGUID(), "thewire_tools");
		if ($setting == "yes") {
			$notification_settings = get_user_notification_settings($user->getGUID());
			
			if (!empty($notification_settings)) {
				$notification_settings = (array) $notification_settings;
				$methods = array();
				
				foreach ($notification_settings as $method => $value) {
					if ($value == "yes") {
						$methods[] = $method;
					}
				}
				
				if (!empty($methods)) {
					elgg_set_plugin_user_setting("notification_settings", implode(",", $methods), $user->getGUID(), "thewire_tools");
				}
			}
		}
		
		if (!elgg_unset_plugin_user_setting("notify_mention", $user->getGUID(), "thewire_tools")) {
			$error_count++;
		} else {
			$success_count++;
		}
		
	}
}

access_show_hidden_entities($access_status);

// replace events and hooks
_elgg_services()->events = $original_events;
_elgg_services()->hooks = $original_hooks;
_elgg_services()->db->enableQueryCache();

// Give some feedback for the UI
echo json_encode(array(
	"numSuccess" => $success_count,
	"numErrors" => $error_count
));
