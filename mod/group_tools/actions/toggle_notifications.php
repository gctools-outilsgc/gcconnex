<?php

$group_guid = (int) get_input('group_guid');
$group = get_entity($group_guid);
if (!($group instanceof ElggGroup)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();

$notifications_enabled = \ColdTrick\GroupTools\Membership::notificationsEnabledForGroup($user, $group);

if ($notifications_enabled) {
	// user has notifications enabled, but wishes to disable this
	$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethodsAsDeprecatedGlobal();
	foreach ($NOTIFICATION_HANDLERS as $method => $dummy) {
		elgg_remove_subscription($user->getGUID(), $method, $group->getGUID());
	}
	
	system_message(elgg_echo('group_tools:action:toggle_notifications:disabled', [$group->name]));
} else {
	// user has no notification settings for this group and wishes to enable this
	$user_settings = get_user_notification_settings($user->getGUID());
	
	$supported_notifications = ['site', 'email'];
	$found = [];
	
	if (!empty($user_settings)) {
		// check current user settings
		foreach ($user_settings as $method => $value) {
			if (!in_array($method, $supported_notifications)) {
				continue;
			}
			
			if (!empty($value)) {
				$found[] = $method;
			}
		}
	}
	
	// user has no base nofitication settings
	if (empty($found)) {
		$found = $supported_notifications;
	}
	
	foreach ($found as $method) {
		elgg_add_subscription($user->getGUID(), $method, $group->getGUID());
	}
	
	system_message(elgg_echo('group_tools:action:toggle_notifications:enabled', [$group->name]));
}

forward(REFERER);
