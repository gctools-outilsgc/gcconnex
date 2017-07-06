<?php
/**
 * This action toggles the expert role for a user on or off
 */

$user_guid = (int) get_input('user_guid');
$page_owner_guid = (int) get_input('guid');

if (empty($user_guid) || empty($page_owner_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$user = get_user($user_guid);
$page_owner = get_entity($page_owner_guid);
if (empty($user) || empty($page_owner) || (!($page_owner instanceof ElggSite) && !($page_owner instanceof ElggGroup)) || !$page_owner->canEdit()) {
	register_error(elgg_echo('pageownerunavailable', [$page_owner_guid]));
	forward(REFERER);
}

// check if the user is an expert
if (check_entity_relationship($user->getGUID(), QUESTIONS_EXPERT_ROLE, $page_owner->getGUID())) {
	// yes, so remove
	remove_entity_relationship($user->getGUID(), QUESTIONS_EXPERT_ROLE, $page_owner->getGUID());
	
	system_message(elgg_echo('questions:action:toggle_expert:success:remove', [$user->name, $page_owner->name]));
} else {
	// no, so add
	add_entity_relationship($user->getGUID(), QUESTIONS_EXPERT_ROLE, $page_owner->getGUID());
	
	system_message(elgg_echo('questions:action:toggle_expert:success:make', [$user->name, $page_owner->name]));
}

forward(REFERER);
