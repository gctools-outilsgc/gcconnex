<?php
/**
 * Quickly open/close a discussion
 */

$guid = (int) get_input("guid");

if (!empty($guid)) {
	$entity = get_entity($guid);
	if (!empty($entity) && $entity->canEdit()) {
		if (elgg_instanceof($entity, "object", "groupforumtopic")) {
			if ($entity->status == "closed") {
				$entity->status = "open";
				
				system_message(elgg_echo("group_tools:action:discussion:toggle_status:success:open"));
			} else {
				$entity->status = "closed";
				
				system_message(elgg_echo("group_tools:action:discussion:toggle_status:success:close"));
			}
		} else {
			register_error(elgg_echo("ClassException:ClassnameNotClass", array($guid, elgg_echo("item:object:groupforumtopic"))));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
	}
} else {
	register_error(elgg_echo("InvalidParameterException:MissingParameter"));
}

forward(REFERER);
