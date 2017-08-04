<?php

$guid = (int) get_input('guid');
$metadata = get_input('metadata');

if (empty($guid) || empty($metadata)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

elgg_entity_gatekeeper($guid, 'object', 'blog');
$entity = get_entity($guid);

if (!$entity->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$old = $entity->$metadata;

if (empty($entity->$metadata)) {
	$entity->$metadata = true;
} else {
	unset($entity->$metadata);
}

if ($old !== $entity->$metadata) {
	system_message(elgg_echo('blog_tools:action:toggle_metadata:success'));
} else {
	register_error(elgg_echo('blog_tools:action:toggle_metadata:error'));
}

forward(REFERER);
