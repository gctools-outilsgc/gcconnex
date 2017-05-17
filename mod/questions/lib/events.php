<?php
/**
 * All event handler functions for this plugin can be found in this file.
 */

/**
 * When an expert leaves the group, remove the expert role
 *
 * @param string $event  the 'leave' event
 * @param string $type   for the 'group' type
 * @param array  $params the provided params
 *
 * @return void
 */
function questions_leave_group_handler($event, $type, $params) {
	
	if (empty($params) || !is_array($params)) {
		return;
	}
	
	$user = elgg_extract('user', $params);
	$group = elgg_extract('group', $params);
	if (empty($user) || !($user instanceof ElggUser) || empty($group) || !($group instanceof ElggGroup)) {
		return;
	}
	
	// is the user an expert in this group
	if (check_entity_relationship($user->getGUID(), QUESTIONS_EXPERT_ROLE, $group->getGUID())) {
		// remove the expert role
		remove_entity_relationship($user->getGUID(), QUESTIONS_EXPERT_ROLE, $group->getGUID());
	}
}

/**
 * When an expert leaves the site, remove the expert role
 *
 * @param string           $event        the 'delete' event
 * @param string           $type         for the 'member_of_site' type
 * @param ElggRelationship $relationship the provided params
 *
 * @return void
 */
function questions_leave_site_handler($event, $type, $relationship) {
	
	if (!($relationship instanceof ElggRelationship)) {
		return;
	}
	
	if ($relationship->relationship !== 'member_of_site') {
		return;
	}
	
	$user = get_user($relationship->guid_one);
	$site = elgg_get_site_entity($relationship->guid_two);
	if (empty($user) || empty($site)) {
		return;
	}
	
	// is the user an expert in this site
	if (check_entity_relationship($user->getGUID(), QUESTIONS_EXPERT_ROLE, $site->getGUID())) {
		// remove the expert role
		remove_entity_relationship($user->getGUID(), QUESTIONS_EXPERT_ROLE, $site->getGUID());
	}
}
