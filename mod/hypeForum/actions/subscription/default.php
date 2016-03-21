<?php

$guid = get_input('guid');

if (check_entity_relationship(elgg_get_logged_in_user_guid(), 'subscribed', $guid)) {
	action('forum/subscription/remove');
} else {
	action('forum/subscription/create');
}

forward(REFERER);
