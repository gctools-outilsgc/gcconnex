<?php

$guid = (int) get_input("guid");
$metadata = get_input("metadata");

if (!empty($guid) && !empty($metadata)) {
	$entity = get_entity($guid);
	
	if (!empty($entity) && $entity->canEdit()) {
		if (elgg_instanceof($entity, "object", "blog", "ElggBlog")) {
			$old = $entity->$metadata;
			
			if (empty($entity->$metadata)) {
				$entity->$metadata = true;
			} else {
				unset($entity->$metadata);
			}
			
			if ($old != $entity->$metadata) {
				system_message(elgg_echo("blog_tools:action:toggle_metadata:success"));
			} else {
				register_error(elgg_echo("blog_tools:action:toggle_metadata:error"));
			}
		} else {
			register_error(elgg_echo("InvalidClassException:NotValidElggStar", array($guid, "ElggBlog")));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:GUIDNotFound", array($guid)));
	}
} else {
	register_error(elgg_echo("InvalidParameterException:MissingParameter"));
}

forward(REFERER);