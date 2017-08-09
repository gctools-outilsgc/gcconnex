<?php

/**
* Group Tools
*
* Invite users to the group
* 
* @author ColdTrick IT Solutions
*/	

$invite_members = get_input('invite_members');
$group_guid = (int) get_input('group_guid');

if (empty($group_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

elgg_entity_gatekeeper($group_guid, 'group');
$group = get_entity($group_guid);

if (!$group->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$group->invite_members = $invite_members;

system_message(elgg_echo('admin:configuration:success'));

forward($group->getURL());
