<?php

/**
 * Overwriting the core function to save the Notifications Settings page
 *
 */

gatekeeper();

$params = get_input('params');
$plugin_id = get_input('plugin_id');
$user_guid = get_input('user_guid', elgg_get_logged_in_user_guid());
$plugin = elgg_get_plugin_from_id($plugin_id);
$user = get_entity($user_guid);

/// array of subscribed users
//$old_colleague_list = json_decode($plugin->getUserSetting('subscribe_colleague_picker', $user->guid),true);

/// overwriting the save action for usersettings in notifications, save all the checkboxes
$plugin_name = $plugin->getManifest()->getName();
foreach ($params as $k => $v) {
	
	// select all checkbox, don't save metadata
	if (strpos($k,'cpn_group_') !== false)
		continue;

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
		register_error(elgg_echo('plugins:usersettings:save:fail', array($plugin_name)));
		forward(REFERER);
	}
}


/// create the digest object for the user
if (strcmp(elgg_get_plugin_user_setting('cpn_set_digest', $user->guid,'cp_notifications'),'set_digest_yes') == 0) {
	if (!$user->cpn_newsletter) {

		$new_digest = new ElggObject();
		$new_digest->subtype = 'cp_digest';
		$new_digest->owner_guid = $user->guid;
		$new_digest->container_guid = $user->guid;
		//$new_digest->title = "Newsletter|{$user->email}";
		$new_digest->title = "Newsletter|{$user->guid}";
		$new_digest->access_id = ACCESS_PUBLIC;
		$digest_id = $new_digest->save();

		if ($digest_id) { 
			$user->cpn_newsletter = $digest_id;
			$result = true;
		} else {
			$result = false;
		}
	}

} else {

	$digest = get_entity($user->cpn_newsletter);
	if ($digest) {
		$digest->delete();
		$user->deleteMetadata('cpn_newsletter');
	}
}

($result) ? system_message('Settings have been saved succesfully') : register_error('Settings did not save successfully');
forward(REFERER);


