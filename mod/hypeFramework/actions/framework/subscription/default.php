<?php

/**
 * Subscription dispatch
 *
 * @uses $guid
 */
$guid = get_input('guid');

if (check_entity_relationship(elgg_get_logged_in_user_guid(), 'subscribed', $guid)) {
	action('framework/subscription/remove');
} else {
	action('framework/subscription/create');
}

forward(REFERER, 'action');
