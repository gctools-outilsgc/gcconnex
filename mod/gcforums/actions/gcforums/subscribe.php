<?php


$hjforum_guid = get_input('guid');
$hjforum_entity = get_entity($hjforum_guid);


$user = elgg_get_logged_in_user_entity();
if (check_entity_relationship($user->guid, 'subscribed', $hjforum_guid)) {
	if (remove_entity_relationship($user->guid, 'subscribed', $hjforum_guid))
		system_message(elgg_echo("Unsubscribed '{$hjforum_entity->title}' succeeded"));
} else {
	if (add_entity_relationship($user->guid, 'subscribed', $hjforum_guid))
		system_message(elgg_echo("Subscribed to '{$hjforum_entity->title}' succeeded"));
}
forward(REFERER);