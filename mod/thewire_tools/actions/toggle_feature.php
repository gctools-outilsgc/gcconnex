<?php

$guid = get_input('guid');
elgg_entity_gatekeeper($guid, 'object', 'thewire');

/* @var $entity ElggWire */
$entity = get_entity($guid);

$container = $entity->getContainerEntity();
if ($container instanceof \ElggGroup) {
	if (!$container->canEdit()) {
		register_error(elgg_echo('actionunauthorized'));
		forward(REFERER);
	}
} elseif (!elgg_is_admin_logged_in()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

if (!empty($entity->featured)) {
	unset($entity->featured);
	
	system_message(elgg_echo('thewire_tools:action:toggle_feature:unfeatured'));
} else {
	$entity->featured = time();
	
	system_message(elgg_echo('thewire_tools:action:toggle_feature:featured'));
}

forward(REFERER);