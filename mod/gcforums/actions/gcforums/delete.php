<?php

	$entity_guid = get_input('guid');
	$entity = get_entity($entity_guid);

	$container_guid = $entity->getContainerGUID();

	$message = ($entity->canEdit() && $entity->delete()) 
	 	? elgg_echo('gcforums:delete:success', array($entity->title)) 
	 	: elgg_echo('gcforums:delete:success', array($entity->title));

	system_message($message);

	forward("http://192.168.1.18/gcconnex/gcforums/view/{$container_guid}");