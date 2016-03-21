<?php
/**
 * Accept an email invitation
 */

$invitecode = get_input("invitecode");

$user = elgg_get_logged_in_user_entity();
$forward_url = REFERER;

if (!empty($invitecode)) {
	$forward_url = elgg_get_site_url() . "groups/invitations/" . $user->username;
	$group = group_tools_check_group_email_invitation($invitecode);
	
	if (!empty($group)) {
		if (groups_join_group($group, $user)) {
			$invitecode = sanitise_string($invitecode);
			
			$options = array(
				"guid" => $group->getGUID(),
				"annotation_name" => "email_invitation",
				"wheres" => array("(v.string = '" . $invitecode . "' OR v.string LIKE '" . $invitecode . "|%')"),
				"annotation_owner_guid" => $group->getGUID(),
				"limit" => 1
			);
			
			$annotations = elgg_get_annotations($options);
			if (!empty($annotations)) {
				// ignore access in order to cleanup the invitation
				$ia = elgg_set_ignore_access(true);
				
				$annotations[0]->delete();
				
				// restore access
				elgg_set_ignore_access($ia);
			}
			
			$forward_url = $group->getURL();
			system_message(elgg_echo("group_tools:action:groups:email_invitation:success"));
		} else {
			register_error(elgg_echo("group_tools:action:groups:email_invitation:error:join", array($group->name)));
		}
	} else {
		register_error(elgg_echo("group_tools:action:groups:email_invitation:error:code"));
	}
} else {
	register_error(elgg_echo("group_tools:action:groups:email_invitation:error:input"));
}

forward($forward_url);
