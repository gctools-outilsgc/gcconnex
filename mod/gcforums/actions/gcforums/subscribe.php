<?php

$hjforum_guid = get_input('guid');
$hjforum_entity = get_entity($hjforum_guid);

$user = elgg_get_logged_in_user_entity();

// cyu - changing the subscription behavior
if (elgg_is_active_plugin('cp_notifications')) {
	if (check_entity_relationship($user->guid, 'cp_subscribed_to_email', $hjforum_guid) || check_entity_relationship($user->guid, 'cp_subscribed_to_site_mail', $hjforum_guid)) {
		$r1 = remove_entity_relationship($user->guid, 'cp_subscribed_to_email', $hjforum_guid);
		$r2 = remove_entity_relationship($user->guid, 'cp_subscribed_to_site_mail', $hjforum_guid);

		if ($r1 || $r2) {
			system_message(elgg_echo("Unsubscribed to '{$hjforum_entity->title}' succeeded"));
		}
	} else {
		$r1 = add_entity_relationship($user->guid, 'cp_subscribed_to_email', $hjforum_guid);
		$r2 = add_entity_relationship($user->guid, 'cp_subscribed_to_site_mail', $hjforum_guid);

		if ($r1 || $r2) {
			system_message(elgg_echo("Subscribed '{$hjforum_entity->title}' succeeded"));
		}
	}
} else {
	if (check_entity_relationship($user->guid, 'subscribed', $hjforum_guid)) {
		if (remove_entity_relationship($user->guid, 'subscribed', $hjforum_guid)) {
			system_message(elgg_echo("Unsubscribed '{$hjforum_entity->title}' succeeded"));
		}
	} else {
		if (add_entity_relationship($user->guid, 'subscribed', $hjforum_guid)) {
			system_message(elgg_echo("Subscribed to '{$hjforum_entity->title}' succeeded"));
		}
	}
}

forward(REFERER);
