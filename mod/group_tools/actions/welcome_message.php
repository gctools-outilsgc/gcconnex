<?php

/**
* Group Tools
*
* Save the group welcome message
* 
* @author ColdTrick IT Solutions
*/

$group_guid = (int) get_input('group_guid');
$welcome_message = get_input('welcome_message');

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

$check_message = trim(strip_tags($welcome_message));

if (!empty($check_message)) {
	$group->setPrivateSetting('group_tools:welcome_message', $welcome_message);
} else {
	$group->removePrivateSetting('group_tools:welcome_message');
}

system_message(elgg_echo('group_tools:action:welcome_message:success'));
forward($group->getURL());
