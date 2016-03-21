<?php
/**
 * Decline an email invitation
 */

$invitecode = get_input("invitecode");

if (!empty($invitecode)) {
	$options = array(
		"annotation_name" => "email_invitation",
		"annotation_value" => $invitecode,
		"limit" => false
	);
	
	if (elgg_delete_annotations($options)) {
		system_message(elgg_echo("groups:invitekilled"));
	} else {
		register_error(elgg_echo("group_tools:action:groups:decline_email_invitation:error:delete"));
	}
} else {
	register_error(elgg_echo("group_tools:action:groups:email_invitation:error:input"));
}

forward(REFERER);
