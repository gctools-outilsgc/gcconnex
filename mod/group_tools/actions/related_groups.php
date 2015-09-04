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
			if ($group->getGUID() != $related->getGUID()) {
				// not already related?
				if (!check_entity_relationship($group->getGUID(), "related_group", $related->getGUID())) {
					
					if (add_entity_relationship($group->getGUID(), "related_group", $related->getGUID())) {
						// notify the other owner about this
						if ($group->getOwnerGUID() != $related->getOwnerGUID()) {
							$subject = elgg_echo("group_tools:related_groups:notify:owner:subject");
							$message = elgg_echo("group_tools:related_groups:notify:owner:message", array(
								$related->getOwnerEntity()->name,
								elgg_get_logged_in_user_entity()->name,
								$related->name,
								$group->name
							));
							
							notify_user($related->getOwnerGUID(), $group->getOwnerGUID(), $subject, $message);
						}
						
						system_message(elgg_echo("group_tools:action:related_groups:success"));
					} else {
						register_error(elgg_echo("group_tools:action:related_groups:error:add"));
					}
				} else {
					register_error(elgg_echo("group_tools:action:related_groups:error:already"));
				}
			} else {
				register_error(elgg_echo("group_tools:action:related_groups:error:same"));
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
