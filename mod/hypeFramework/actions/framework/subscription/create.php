<?php

/**
 * Create a new subscription to an entity
 *
 * @uses $guid
 * @return str json encoded string
 */
$guid = get_input('guid');

if (!check_entity_relationship(elgg_get_logged_in_user_guid(), 'subscribed', $guid)) {
	add_entity_relationship(elgg_get_logged_in_user_guid(), 'subscribed', $guid);

	$count = elgg_get_entities_from_relationship(array(
		'types' => 'user',
		'relationship' => 'subscribed',
		'relationship_guid' => $guid,
		'inverse_relationship' => true,
		'count' => true
			));

	if (elgg_is_xhr()) {
		print json_encode(array('count' => $count));
	}

	system_message(elgg_echo('hj:framework:subscription:create:success'));
	forward(REFERER, 'action');
}

register_error(elgg_echo('hj:framework:subscription:create:error'));
forward(REFERER, 'action');