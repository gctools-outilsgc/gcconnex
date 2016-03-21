<?php

/**
 * Bookmark an entity
 *
 * @uses $guid guid of an entity to be bookmarked
 * @return str json encoded string
 */
$guid = get_input('guid');

if (!check_entity_relationship(elgg_get_logged_in_user_guid(), 'bookmarked', $guid)) {
	add_entity_relationship(elgg_get_logged_in_user_guid(), 'bookmarked', $guid);

	$count = elgg_get_entities_from_relationship(array(
		'types' => 'user',
		'relationship' => 'bookmarked',
		'relationship_guid' => $guid,
		'inverse_relationship' => true,
		'count' => true
			));

	if (elgg_is_xhr()) {
		print json_encode(array('count' => $count));
	}
	system_message(elgg_echo('hj:framework:bookmark:create:success'));
	forward(REFERER, 'action');
}

register_error(elgg_echo('hj:framework:bookmark:create:error'));
forward(REFERER, 'action');