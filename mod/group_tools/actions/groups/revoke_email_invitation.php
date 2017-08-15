<?php
/**
* Group Tools
*
* Revoke an email inviation for a group
* 
* @author ColdTrick IT Solutions
*/	

$annotation_id = (int) get_input('annotation_id');
$group_guid = (int) get_input('group_guid');

if (empty($group_guid) || empty($annotation_id)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

elgg_entity_gatekeeper($group_guid, 'group');
$group = get_entity($group_guid);
$annotation = elgg_get_annotation_from_id($annotation_id);
if (empty($annotation) || ($annotation->name !== 'email_invitation')) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

if (!$group->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

if ($annotation->delete()) {
	system_message(elgg_echo('group_tools:action:revoke_email_invitation:success'));
} else {
	register_error(elgg_echo('group_tools:action:revoke_email_invitation:error'));
}

forward(REFERER);