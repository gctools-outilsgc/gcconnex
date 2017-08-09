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

if ($group->getGUID() === $related->getGUID()) {
	register_error(elgg_echo('group_tools:action:related_groups:error:same'));
	forward(REFERER);
}

// not already related?
if (check_entity_relationship($group->getGUID(), 'related_group', $related->getGUID())) {
	register_error(elgg_echo('group_tools:action:related_groups:error:already'));
	forward(REFERER);
}

if (add_entity_relationship($group->getGUID(), 'related_group', $related->getGUID())) {
	// notify the other owner about this
	if ($group->getOwnerGUID() != $related->getOwnerGUID()) {
		$subject = elgg_echo('group_tools:related_groups:notify:owner:subject');
		$message = elgg_echo('group_tools:related_groups:notify:owner:message', [
			$related->getOwnerEntity()->name,
			elgg_get_logged_in_user_entity()->name,
			$related->name,
			$group->name,
		]);
		
		notify_user($related->getOwnerGUID(), $group->getOwnerGUID(), $subject, $message);
	}
	
	system_message(elgg_echo('group_tools:action:related_groups:success'));
} else {
	register_error(elgg_echo('group_tools:action:related_groups:error:add'));
}

forward(REFERER);
