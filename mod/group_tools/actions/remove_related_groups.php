<?php

/**
* Group Tools
*
* Action to save a new related group
* 
* @author ColdTrick IT Solutions
*/	

$group_guid = (int) get_input('group_guid');
$guid = (int) get_input('guid');

if (empty($group_guid) || empty($guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

elgg_entity_gatekeeper($group_guid, 'group');
elgg_entity_gatekeeper($guid, 'group');

$group = get_entity($group_guid);
$related = get_entity($guid);

if (!$group->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

// related?
if (!check_entity_relationship($group->getGUID(), 'related_group', $related->getGUID())) {
	register_error(elgg_echo('group_tools:action:remove_related_groups:error:not_related'));
	forward(REFERER);
}

if (remove_entity_relationship($group->getGUID(), 'related_group', $related->getGUID())) {
	system_message(elgg_echo('group_tools:action:remove_related_groups:success'));
} else {
	register_error(elgg_echo('group_tools:action:remove_related_groups:error:remove'));
}

forward(REFERER);
