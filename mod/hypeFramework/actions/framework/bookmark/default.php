<?php

/**
 * Bookmark dispatcher
 *
 * @uses $guid		guid of an entity to be bookmarked
 */
$guid = get_input('guid');

if (check_entity_relationship(elgg_get_logged_in_user_guid(), 'bookmarked', $guid)) {
	action('framework/bookmark/remove');
} else {
	action('framework/bookmark/create');
}

forward(REFERER, 'action');
