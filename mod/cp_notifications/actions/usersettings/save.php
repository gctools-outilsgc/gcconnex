<?php

/**
 * Overwriting the core function to save the Notifications Settings page
 *
 */

gatekeeper();

$params = get_input('params');
$plugin_id = get_input('plugin_id');
$user_guid = get_input('user_guid', elgg_get_logged_in_user_guid());
$plugin = elgg_get_plugin_from_id('cp_notifications');
$user = get_entity($user_guid);

/// overwriting the save action for usersettings in notifications, save all the checkboxes
$plugin_name = $plugin->getManifest()->getName();


/// when no colleagues are selected for subscription, the key does not exist
if (!array_key_exists('subscribe_colleague_picker', $params)) {

	// no performance issue because this function should only be called once
	$all_colleagues = $user->getFriends(array('limit' => false));
	foreach ($all_colleagues as $colleague) {

		$result1 = remove_entity_relationship($user->guid, 'cp_subscribed_to_email', $colleague->guid);
		$result2 = remove_entity_relationship($user->guid, 'cp_subscribed_to_site_mail', $colleague->guid);
	}
}



foreach ($params as $k => $v) {

	// select all checkbox, don't save metadata
	if (strpos($k,'cpn_group_') !== false)
		continue;

	// PHP WARNING string required, but array given
	if (!is_array($v)) 
		$result = $plugin->setUserSetting($k, $v, $user->guid);

	/// create relationships between user and group that they have subscribed to
	if (strpos($k,'cpn_site_mail_') !== false || strpos($k,'cpn_email_') !== false) {
		
		$group_guid = explode('_',$k);
		if (strpos($k,'cpn_site_mail_') !== false) {
		
			if (strcmp($v,'set_notify_off') == 0)
				remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group_guid[sizeof($group_guid) - 1]);
			else
				add_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group_guid[sizeof($group_guid) - 1]);
			
		}
	
		if (strpos($k,'cpn_email_') !== false) {
		
			if (strcmp($v,'set_notify_off') == 0) 
				remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group_guid[sizeof($group_guid) - 1]);
			else 
				add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group_guid[sizeof($group_guid) - 1]);
				
		}
	}

	/// create relationship between user and user (colleagues)
	if (strcmp($k,'subscribe_colleague_picker') == 0) {
		// make sure that the value is an array, less warnings within the foreach loop
		$all_colleagues = $user->getFriends(array('limit' => false));
		$subscribed_colleagues = $v;

		foreach ($all_colleagues as $colleague) {

			if (in_array($colleague->getGUID(), $subscribed_colleagues)) {
				$result1 = add_entity_relationship($user->guid, 'cp_subscribed_to_email', $colleague->guid);
        		$result2 = add_entity_relationship($user->guid, 'cp_subscribed_to_site_mail', $colleague->guid);
    		} else {
    			$result1 = remove_entity_relationship($user->guid, 'cp_subscribed_to_email', $colleague->guid);
        		$result2 = remove_entity_relationship($user->guid, 'cp_subscribed_to_site_mail', $colleague->guid);
			}
    	}
	}

	if (!$result) {
		register_error(elgg_echo('plugins:usersettings:save:failed', array($plugin_name)));
		forward(REFERER);
	}
}


($result) ? system_message(elgg_echo('cp_notification:save:success')) : register_error(elgg_echo('cp_notification:save:failed'));
forward(REFERER);


