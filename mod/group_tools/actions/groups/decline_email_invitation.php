<?php

/**
* Group Tools
*
* Decline an email invitation
* 
* @author ColdTrick IT Solutions
*/	

$invitecode = get_input('invitecode');
if (empty($invitecode)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$options = [
	'annotation_name' => 'email_invitation',
	'annotation_value' => $invitecode,
	'limit' => false,
];

if (elgg_delete_annotations($options)) {
	system_message(elgg_echo('groups:invitekilled'));
} else {
	register_error(elgg_echo('group_tools:action:groups:decline_email_invitation:error:delete'));
}

forward(REFERER);
