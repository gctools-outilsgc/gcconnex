<?php

/**
 * Delete an entity
 *
 * @uses $guid	guid of an entity to be deleted
 * @return str json encoded string
 */

$guid = get_input('guid');
$entity = get_entity($guid);

if (!elgg_instanceof($entity)) {
	register_error(elgg_echo('hj:framework:delete:error:notentity'));
	forward(REFERER);
}

$container = $entity->getContainerEntity();
if ($entity->canEdit() && $entity->delete()) {
	if (elgg_is_xhr()) {
		print json_encode(array('guid' => $guid));
	}
	system_message(elgg_echo('hj:framework:delete:success'));

	// cyu - 12/11/2014: this will direct user back to the first layer (not group page)
	$container_guid = get_entity($guid)->getContainerEntity()->guid;
	if (get_entity($guid)->getContainerEntity() instanceof ElggGroup)
	{
		$forward_url = elgg_get_site_url().'forum/group/'.$container_guid;
		forward($forward_url, 'action');
	}

	forward($container->getURL(), 'action');
} else {
	register_error(elgg_echo('hj:framework:delete:error:unknown'));
	forward(REFERER, 'action');
}