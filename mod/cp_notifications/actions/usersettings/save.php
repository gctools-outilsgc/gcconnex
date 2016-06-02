<?php

$params = get_input('params');
$plugin_id = get_input('plugin_id');
$user_guid = get_input('user_guid', elgg_get_logged_in_user_guid());
$plugin = elgg_get_plugin_from_id($plugin_id);
$user = get_entity($user_guid);



$plugin_name = $plugin->getManifest()->getName();
foreach ($params as $k => $v) {
	// Save
	$result = $plugin->setUserSetting($k, $v, $user->guid);

	// Error?
	if (!$result) {
		register_error(elgg_echo('plugins:usersettings:save:fail', array($plugin_name)));
		forward(REFERER);
	}
}


$options = array(
	'relationship' => 'member',
	'relationship_guid' => $user->guid,
	'type' => 'group',
	'limit' => false,
);

$groups = elgg_get_entities_from_relationship($options);

foreach ($groups as $group) {
    // Nick - This asks for the inputs of the checkboxes. If the checkbox is checked it will save it's value. else it will return 'unSub' or 'site_unSub'
	$cpn_set_subscription_email = $plugin->getUserSetting("cpn_email_{$group->getGUID()}", $user->getGUID());	// setting email notification

	// (email) if user set item to subscribed, and no relationship has been built, please add new relationship
    if ($cpn_set_subscription_email == 'sub_'.$group->getGUID() /*&& !check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email',$group->getGUID())*/){
		add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group->getGUID());
    }

	// (email) if user set item to unsubscribe, update relationship table
	if ($cpn_set_subscription_email == 'unSub' /*&& check_entity_relationship($user->getGUID(), 'cp_subscribed_to_email',$group->getGUID())*/){
		remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $group->getGUID());
    }

	if (empty($cpn_set_subscription_email)) $cpn_set_subscription_email = 'sub_'.$group->getGUID() ;	// if not set, set no email as default



	$cpn_set_subscription_site_mail = $plugin->getUserSetting("cpn_site_mail_{$group->getGUID()}", $user->getGUID());
	// (site mail) checks for the inputs of the check boxes
	if ($cpn_set_subscription_site_mail == 'sub_site_'.$group->getGUID()/* && !check_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail',$group->getGUID())*/){
        add_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group->getGUID());
    }
		
	// (site mail)
	if ($cpn_set_subscription_site_mail == 'site_unSub' /*&& check_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail',$group->getGUID())*/){
        remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $group->getGUID());
    }

	if (empty($cpn_set_subscription_site_mail)) $cpn_set_subscription_site_mail = 'sub_site_'.$group->getGUID();
}

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