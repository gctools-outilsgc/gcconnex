<?php
/**
 * Revoke an email inviation for a group
 */

$annotation_id = (int) get_input("annotation_id");
$group_guid = (int) get_input("group_guid");

if (!empty($group_guid) && !empty($annotation_id)) {
	$group = get_entity($group_guid);
	$annotation = elgg_get_annotation_from_id($annotation_id);
	
	if (!empty($group) && elgg_instanceof($group, "group") && !empty($annotation)) {
		
		if ($group->canEdit() && ($annotation->name == "email_invitation")) {
			
			if ($annotation->delete()) {
				system_message(elgg_echo("group_tools:action:revoke_email_invitation:success"));
			} else {
				register_error(elgg_echo("group_tools:action:revoke_email_invitation:error"));
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