<?php
/**
 * All event handler functions are bundled in this file
 */

/**
 * This functions performs actions when a wire post is created
 *
 * @param string     $event  'create'
 * @param string     $type   'object'
 * @param ElggObject $object the ElggObject created
 *
 * @return void
 */
function thewire_tools_create_object_event_handler($event, $type, ElggObject $object) {
	
	if (empty($object) || !elgg_instanceof($object, "object", "thewire")) {
		return;
	}
	
	//send out notification to users mentioned in a wire post
	$usernames = array();
	preg_match_all("/\@([A-Za-z0-9\_\.\-]+)/i", $object->description, $usernames);
	
	if (empty($usernames)) {
		return;
	}
	
	$usernames = array_unique($usernames[0]);
	$params = array(
		"object" => $object,
		"action" => "mention"
	);
	
	foreach ($usernames as $username) {
		$username = str_ireplace("@", "", $username);
		$user = get_user_by_username($username);
		
		if (empty($user) || ($user->getGUID() == $object->getOwnerGUID())) {
			continue;
		}
			
		$setting = thewire_tools_get_notification_settings($user->getGUID());
		if (empty($setting)) {
			continue;
		}
		
		$subject = elgg_echo("thewire_tools:notify:mention:subject");
		$message = elgg_echo("thewire_tools:notify:mention:message", array(
			$user->name,
			$object->getOwnerEntity()->name,
			elgg_normalize_url("thewire/search/@" . $user->username)
		));
		
		notify_user($user->getGUID(), $object->getOwnerGUID(), $subject, $message, $params, $setting);
	}
}

/**
 * Listen to the upgrade event to make sure upgrades can be run
 *
 * @param string $event  the name of the event
 * @param string $type   the type of the event
 * @param null   $object nothing
 *
 * @return void
 */
function thewire_tools_upgrade_system_event_handler($event, $type, $object) {
	
	// Upgrade also possible hidden entities. This feature get run
	// by an administrator so there's no need to ignore access.
	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(true);
	
	// register an upgrade script
	$options = array(
		"type" => "user",
		"plugin_id" => "thewire_tools",
		"plugin_user_setting_name" => "notify_mention",
		"count" => true
	);
	$count = elgg_get_entities_from_plugin_user_settings($options);
	if ($count) {
		$path = "admin/upgrades/thewire_tools_mentions";
		$upgrade = new ElggUpgrade();
		if (!$upgrade->getUpgradeFromPath($path)) {
			$upgrade->setPath($path);
			$upgrade->title = "TheWire Tools mentions upgrade";
			$upgrade->description = "The way mention notifications are handled has changed. Run this script to make sure all settings are migrated.";
				
			$upgrade->save();
		}
	}
	
	access_show_hidden_entities($access_status);
}
