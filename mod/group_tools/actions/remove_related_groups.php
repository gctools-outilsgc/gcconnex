<?php
/**
 * Action to save a new related group
 */

$group_guid = (int) get_input("group_guid");
$guid = (int) get_input("guid");

if (!empty($group_guid) && !empty($guid)) {
	$group = get_entity($group_guid);
	$related = get_entity($guid);
	
	// do we have groups
	if (!empty($group) && elgg_instanceof($group, "group") && !empty($related) && elgg_instanceof($related, "group")) {
		if ($group->canEdit()) {
			// related?
			if (check_entity_relationship($group->getGUID(), "related_group", $related->getGUID())) {
				if (remove_entity_relationship($group->getGUID(), "related_group", $related->getGUID())) {
					system_message(elgg_echo("group_tools:action:remove_related_groups:success"));
				} else {
					register_error(elgg_echo("group_tools:action:remove_related_groups:error:remove"));
				}
			} else {
				register_error(elgg_echo("group_tools:action:remove_related_groups:error:not_related"));
			}
		} else {
			register_error(elgg_echo("groups:cantedit"));
		}
	} else {
		register_error(elgg_echo("groups:notfound:details"));
	}
} else {
	register_error(elgg_echo("InvalidParameterException:MissingParameter"));
}

forward(REFERER);
