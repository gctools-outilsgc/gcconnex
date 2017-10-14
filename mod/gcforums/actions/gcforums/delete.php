<?php

$entity_guid = get_input('guid');
$entity = get_entity($entity_guid);
$base_url = elgg_get_site_entity();

$container_guid = $entity->getContainerGUID();

$message = ($entity->delete())
	? elgg_echo('gcforums:delete:success', array($entity->title))
	: elgg_echo('gcforums:delete:unsuccess', array($entity->title));

system_message($message);

forward("{$base_url}gcforums/view/{$container_guid}");
