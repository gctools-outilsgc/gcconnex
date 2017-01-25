<?php

gatekeeper();

$params = get_input('params');
$plugin_id = get_input('plugin_id');
$user_guid = get_input('user_guid', elgg_get_logged_in_user_guid());
$plugin = elgg_get_plugin_from_id($plugin_id);
$user = get_entity($user_guid);


/// overwriting the save action for usersettings in notifications, save all the checkboxes
$plugin_name = $plugin->getManifest()->getName();
foreach ($params as $k => $v) {
	if (strpos($k,'cpn_group_') === false) {
		$result = $plugin->setUserSetting($k, $v, $user->guid);
			error_log(">>>>>>>>>>>>>>>>>>>>>>>> key: {$k} // value: {$v}");
	}

	/// create relationships between user and group that they have subscribed to
	if (strpos($k,'cpn_site_mail_') !== false || strpos($k,'cpn_email_') !== false) {
		
		$group_guid = explode('_',$k);
		if (strpos($k,'cpn_site_mail_') !== false) {
		
			if (strcmp($v,'set_notify_off') == 0)
				add_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group_guid[sizeof($group_guid) - 1]);
			else
				remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group_guid[sizeof($group_guid) - 1]);
		}
	
		if (strpos($k,'cpn_email_') !== false) {
		
			if (strcmp($v,'set_notify_off') == 0) 
				add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group_guid[sizeof($group_guid) - 1]);
			else 
				remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group_guid[sizeof($group_guid) - 1]);
		}
	}

	if (!$result) {
		register_error(elgg_echo('plugins:usersettings:save:fail', array($plugin_name)));
		forward(REFERER);
	}
}




/// notification digest settings that should be saved
$options = array(
	'type' => 'object',
	'subtype' => 'cp_digest',
	'container_guid' => $user->getGUID(),
);
$current_digest = elgg_get_entities($options);

$user_setting = elgg_get_plugin_user_setting('cpn_set_digest', $user->guid, 'cp_notifications');
if (strcmp($user_setting,'set_digest_yes') == 0) {
//if (strcmp($bulk_notifications_email,'bulk_notifications_email') == 0) {
	error_log("the bulk notification flag is set for a user..");
	if (empty($current_digest)) {
		$new_digest = new ElggObject();
		$new_digest->subtype = 'cp_digest';
		$new_digest->owner_guid = $user->getGUID();
		$new_digest->container_guid = $user->getGUID();
		$new_digest->title = "Newsletter|{$user->email}";
		$new_digest->access_id = ACCESS_PUBLIC;
		$digest_id = $new_digest->save();

		if ($digest_id) error_log("the object was created! with the guid of {$digest_id}");
		$user->cpn_newsletter = $digest_id;
		error_log("cpn_newsletter md: {$user->cpn_newsletter}");
	}
} else {
	error_log("the bulk notification was unset...");
	// disable the object (do not remove, yet!)
}




/// group notifications settings that needs to be saved





// $groups = elgg_get_entities_from_relationship(array(
// 	'relationship' => 'member',
// 	'relationship_guid' => $user->guid,
// 	'type' => 'group',
// 	'limit' => false,
// ));

// foreach ($groups as $group) {
//     // Nick - This asks for the inputs of the checkboxes. If the checkbox is checked it will save it's value. else it will return 'unSub' or 'site_unSub'
// 	$cpn_set_subscription_email = $plugin->getUserSetting("cpn_email_{$group->getGUID()}", $user->getGUID());	// setting email notification

// 	// (email) if user set item to subscribed, and no relationship has been built, please add new relationship
//     if ($cpn_set_subscription_email == 'sub_'.$group->getGUID() /*&& !check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email',$group->getGUID())*/){
// 		add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group->getGUID());
//     }

// 	// (email) if user set item to unsubscribe, update relationship table
// 	if ($cpn_set_subscription_email == 'unSub' /*&& check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email',$group->getGUID())*/){
// 		remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group->getGUID());
//     }

// 	if (empty($cpn_set_subscription_email)) $cpn_set_subscription_email = 'sub_'.$group->getGUID() ;	// if not set, set no email as default



// 	$cpn_set_subscription_site_mail = $plugin->getUserSetting("cpn_site_mail_{$group->getGUID()}", $user->getGUID());
// 	// (site mail) checks for the inputs of the check boxes
// 	if ($cpn_set_subscription_site_mail == 'sub_site_'.$group->getGUID()/* && !check_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail',$group->getGUID())*/){
//         add_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group->getGUID());
//     }
		
// 	// (site mail)
// 	if ($cpn_set_subscription_site_mail == 'site_unSub' /*&& check_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail',$group->getGUID())*/){
//         remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group->getGUID());
//     }

// 	if (empty($cpn_set_subscription_site_mail)) $cpn_set_subscription_site_mail = 'sub_site_'.$group->getGUID();
// }

// colleagues
$all_colleagues = elgg_get_logged_in_user_entity()->getFriends(array('limit' => 0));
$colleagues = get_input('colleagues_notify_sub');

foreach( $all_colleagues as $colleague ){
	if ( in_array( $colleague->getGUID(), $colleagues ) ){
        add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $colleague->getGUID());
        add_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $colleague->getGUID());
	}
	else{
        remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $colleague->getGUID());
        remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $colleague->getGUID());
	}
}