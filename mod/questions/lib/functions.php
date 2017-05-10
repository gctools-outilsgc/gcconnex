<?php
/**
 * All helper functions for the questions plugin can be found in this file.
 */

/**
 * This function checks if expert roles are enabled in the plugin settings
 *
 * @return bool
 */
function questions_experts_enabled() {
	static $result;
	
	if (isset($result)) {
		return $result;
	}
	
	$result = false;
	if (elgg_get_plugin_setting('experts_enabled', 'questions') === 'yes') {
		$result = true;
	}
	
	return $result;
}

/**
 * This function checks if only experts are allowed to answer in the plugin settings
 *
 * @return bool
 */
function questions_experts_only_answer() {
	static $result;
	
	if (isset($result)) {
		return $result;
	}
	
	$result = false;
	if (!questions_experts_enabled()) {
		return $result;
	}
	
	$setting = elgg_get_plugin_setting('experts_answer', 'questions');
	if ($setting === 'yes') {
		$result = true;
	}
	
	return $result;
}

/**
 * Check if a user is an expert
 *
 * @param ElggEntity $container the container where a question was asked, leave empty for any relationship
 * @param ElggUser   $user      the user to check (defaults to current user)
 *
 * @return bool
 */
function questions_is_expert(ElggEntity $container = null, ElggUser $user = null) {
	$result = false;
	
	// make sure we have a user
	if (!($user instanceof ElggUser)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	if (empty($user)) {
		return false;
	}
	
	if ($container instanceof ElggEntity) {
		if ($container instanceof ElggUser) {
			$container = elgg_get_site_entity();
		}
		
		if (($container instanceof ElggSite) || ($container instanceof ElggGroup)) {
			if (check_entity_relationship($user->getGUID(), QUESTIONS_EXPERT_ROLE, $container->getGUID())) {
				// user has the expert role
				$result = true;
			}
		}
	} else {
		$expert_options =[
			'count' => true,
			'relationship' => QUESTIONS_EXPERT_ROLE,
			'relationship_guid' => $user->getGUID(),
		];
		
		if (elgg_get_entities_from_relationship($expert_options)) {
			// check if user has any expert relationship with entity on this site
			$result = true;
		}
		
		if (!$result) {
			// added specific check for Subsite Manager plugin where site has no current site entity set as entity_guid
			if (check_entity_relationship($user->getGUID(), QUESTIONS_EXPERT_ROLE, elgg_get_site_entity()->getGUID())) {
				// user has the expert role for this site
				$result = true;
			}
		}
	}
		
	return $result;
}

/**
 * Check if the user can mark this answer as the correct one
 *
 * @param ElggAnswer $entity the answer to check
 * @param ElggUser   $user   the use who is wants to do the action (defaults to current user)
 *
 * @return bool
 */
function questions_can_mark_answer(ElggAnswer $entity, ElggUser $user = null) {
	$result = false;
	static $experts_only;
	
	// check if we have a user
	if (empty($user) || !($user instanceof ElggUser)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	if (empty($user) || empty($entity) || !($entity instanceof ElggAnswer)) {
		return false;
	}
	
	$container = $entity->getContainerEntity();
	
	// are experts enabled
	if (!questions_experts_enabled()) {
		// no, so only question owner can mark
		if ($user->getGUID() == $container->getOwnerGUID()) {
			$result = true;
		}
	} else {
		// get plugin setting for who can mark the answer
		if (!isset($experts_only)) {
			$experts_only = false;
			
			$setting = elgg_get_plugin_setting('experts_mark', 'questions');
			if ($setting == 'yes') {
				$experts_only = true;
			}
		}
		
		// are only experts allowed to mark
		if (!$experts_only) {
			// no, so the owner of a question can also mark
			if ($user->getGUID() == $container->getOwnerGUID()) {
				$result = true;
			}
		}
		
		// is the user an expert
		if (!$result && questions_is_expert($container->getContainerEntity(), $user)) {
			$result = true;
		}
	}
	
	return $result;
}

/**
 * Make sure the provided access_id is valid for this container
 *
 * @param int $access_id      the current access_id
 * @param int $container_guid the container where the entity will be placed
 *
 * @return int
 */
function questions_validate_access_id($access_id, $container_guid) {
	
	$access_id = sanitise_int($access_id);
	if ($access_id === ACCESS_DEFAULT) {
		$access_id = get_default_access();
	}
	
	if (empty($container_guid)) {
		return $access_id;
	}
	
	$container = get_entity($container_guid);
	if (empty($container)) {
		return $access_id;
	}
	
	if ($container instanceof ElggUser) {
		// is a default level defined in the plugin settings
		$personal_access_id = questions_get_personal_access_level();
		if ($personal_access_id !== false) {
			$access_id = $personal_access_id;
		} else {
			// make sure access_id is not a group acl
			$acl = get_access_collection($access_id);
			if (!empty($acl) && ($acl->owner_guid != $container->getGUID())) {
				// this acl is a group acl, so set to something else
				$access_id = ACCESS_LOGGED_IN;
			}
		}
	} elseif ($container instanceof ElggGroup) {
		// is a default level defined in the plugin settings
		$group_access_id = questions_get_group_access_level($container);
		if ($group_access_id !== false) {
			$access_id = $group_access_id;
		} else {
			// friends access not allowed in groups
			if ($access_id === ACCESS_FRIENDS) {
				// so set it to group access
				$access_id = (int) $container->group_acl;
			}
			
			// check if access is an acl
			$acl = get_access_collection($access_id);
			if (!empty($acl) && ($acl->owner_guid != $container->getGUID())) {
				// this acl is an acl, make sure it's the group acl
				$access_id = (int) $container->group_acl;
			}
		}
	}
	
	return $access_id;
}

/**
 * Get the default defined peronal access setting.
 *
 * @return false|int
 */
function questions_get_personal_access_level() {
	static $result;
	
	if (!isset($result)) {
		$result = false;
		
		$setting = elgg_get_plugin_setting('access_personal', 'questions');
		if (!empty($setting) && ($setting !== 'user_defined')) {
			$result = (int) $setting;
		}
	}
	
	return $result;
}

/**
 * Get the default defined group access setting.
 *
 * @param ElggGroup $group the group if the setting is group_acl
 *
 * @return false|int
 */
function questions_get_group_access_level(ElggGroup $group) {
	static $plugin_setting;
	$result = false;
	
	if (!isset($plugin_setting)) {
		$plugin_setting = false;
		
		$setting = elgg_get_plugin_setting('access_group', 'questions');
		if (!empty($setting) && ($setting != 'user_defined')) {
			$plugin_setting = $setting;
		}
	}
	
	if ($plugin_setting) {
		if ($plugin_setting == 'group_acl') {
			$result = (int) $group->group_acl;
		} else {
			$result = (int) $plugin_setting;
		}
	}
	
	return $result;
}

/**
 * This function checks of the plugin setting to close a question on a marked answer is set
 *
 * @return bool
 */
function questions_close_on_marked_answer() {
	static $result;
	
	if (!isset($result)) {
		$result = false;
		
		$setting = elgg_get_plugin_setting('close_on_marked_answer', 'questions');
		if ($setting === 'yes') {
			$result = true;
		}
	}
	
	return $result;
}

/**
 * Return the number of days it should take to solve a question.
 *
 * @param ElggEntity $container if a group is provided, first the setting of the group is checked, then the default setting of the site
 *
 * @return int
 */
function questions_get_solution_time(ElggEntity $container) {
	static $plugin_setting;
	
	if (!isset($plugin_setting)) {
		$plugin_setting = (int) elgg_get_plugin_setting('site_solution_time', 'questions');
	}
	
	// get site setting
	$result = $plugin_setting;
	
	// check is group
	if (($container instanceof ElggGroup) && questions_can_groups_set_solution_time()) {
		// get group setting
		$group_setting = $container->getPrivateSetting('questions_solution_time');
		if (($group_setting !== false) && ($group_setting !== null)) {
			// we have a valid group setting
			$result = (int) $group_setting;
		}
	}
	
	return $result;
}

/**
 * Check the plugin setting if questions are limited to groups.
 *
 * @return bool
 */
function questions_limited_to_groups() {
	static $result;
	
	if (!isset($result)) {
		$result = false;
		
		$setting = elgg_get_plugin_setting('limit_to_groups', 'questions');
		if ($setting === 'yes') {
			$result = true;
		}
	}
	
	return $result;
}

/**
 * Return the GUID from a database row.
 *
 * @param stdObject $row the database row
 *
 * @return int
 */
function questions_row_to_guid($row) {
	return (int) $row->guid;
}

/**
 * Checks if a question can be moved to the discussion in the container.
 *
 * @param ElggEntity $container the container where the question should become a discussion
 * @param ElggUser   $user      the user trying to move the question, defaults to current user
 *
 * @return bool
 */
function questions_can_move_to_discussions(ElggEntity $container, ElggUser $user = null) {
	
	// make sure we have a user
	if (!($user instanceof ElggUser)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	if (empty($user)) {
		return false;
	}
	
	// only if container is a group
	if (!($container instanceof ElggGroup)) {
		return false;
	}
	
	// only experts can move
	if (!questions_is_expert($container, $user)) {
		return false;
	}
	
	// are discussions enabled
	if ($container->forum_enable === 'no') {
		return false;
	}
	
	return true;
}

/**
 * Backdate an entity, since this can't be done by Elgg core functions
 *
 * @param int $entity_guid  the entity to update
 * @param int $time_created the new time_created
 *
 * @access private
 *
 * @return bool
 */
function questions_backdate_entity($entity_guid, $time_created) {
	
	$entity_guid = sanitise_int($entity_guid, false);
	$time_created = sanitise_int($time_created);
	
	if (empty($entity_guid)) {
		return false;
	}
	
	$dbprefix = elgg_get_config('dbprefix');
	$query = "UPDATE {$dbprefix}entities
		SET time_created = {$time_created}
		WHERE guid = {$entity_guid}";
	
	return (bool) update_data($query);
}

/**
 * Check if a user can ask a question in a container
 *
 * @param ElggEntity $container the container to check (default: page_owner)
 * @param ElggUser   $user      the user askting the question (default: current user)
 *
 * @return bool
 */
function questions_can_ask_question(ElggEntity $container = null, ElggUser $user = null) {
	
	// default to page owner
	if (!($container instanceof ElggEntity)) {
		$container = elgg_get_page_owner_entity();
	}
	
	// default to current user
	if (!($user instanceof ElggUser)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	if (empty($user)) {
		// not logged in
		return false;
	}
	
	if (!($container instanceof ElggGroup)) {
		// personal questions
		return !questions_limited_to_groups();
	}
	
	if ($container->questions_enable !== 'yes') {
		// group option not enabled
		return false;
	}
	
	if (!questions_experts_enabled() || ($container->getPrivateSetting('questions_who_can_ask') !== 'experts')) {
		// no experts enabled, or not limited to experts
		return can_write_to_container($user->getGUID(), $container->getGUID(), 'object', ElggQuestion::SUBTYPE);
	}
	
	if (!questions_is_expert($container, $user)) {
		// limited to expert, and user isn't one
		return false;
	}
	
	return can_write_to_container($user->getGUID(), $container->getGUID(), 'object', ElggQuestion::SUBTYPE);
}

/**
 * Check if a user can answer a question
 *
 * @param ElggQuestion $question the question that needs answer
 * @param ElggUser     $user     the user askting the question (default: current user)
 *
 * @return bool
 */
function questions_can_answer_question(ElggQuestion $question, ElggUser $user = null) {
	static $general_experts_only;
	
	// default to page owner
	if (!($question instanceof ElggQuestion)) {
		return false;
	}
	
	// default to current user
	if (!($user instanceof ElggUser)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	if (empty($user)) {
		// not logged in
		return false;
	}
	
	$container = $question->getContainerEntity();
	
	if (!questions_experts_enabled()) {
		return questions_can_ask_question($container, $user);
	}
	
	// get plugin setting
	if (!isset($general_experts_only)) {
		$general_experts_only = questions_experts_only_answer();
	}
	
	$is_expert = questions_is_expert($container, $user);
	
	// check general setting
	if ($general_experts_only && !$is_expert) {
		return false;
	}
	
	if (!($container instanceof ElggGroup)) {
		return true;
	}
	
	// check group settings
	$group_experts_only = false;
	if ($container->getPrivateSetting('questions_who_can_answer') === 'experts') {
		$group_experts_only = true;
	}
	
	if ($group_experts_only && !$is_expert) {
		return false;
	}
	
	// are you a group member or can you edit the group
	return ($container->isMember($user) || $container->canEdit($user->getGUID()));
}

/**
 * Can group owners set the solution time
 *
 * @return bool
 */
function questions_can_groups_set_solution_time() {
	static $result;
	
	if (isset($result)) {
		return $result;
	}
	
	$result = true;
	if (elgg_get_plugin_setting('solution_time_group', 'questions') === 'no') {
		$result = false;
	}
	
	return $result;
}

/**
 * Automaticly mark an answer as the correct answer, when created by an expert
 *
 * NOTE: for now this is only supported in groups
 *
 * @param ElggEntity $container the container of the questions (group or user)
 * @param ElggUser   $user      the user doing the action (default: current user)
 *
 * @return bool
 */
function questions_auto_mark_answer_correct(ElggEntity $container, ElggUser $user = null) {
	
	if (!($container instanceof ElggGroup)) {
		// for now only supported in groups
		return false;
	}
	
	if (!($user instanceof ElggUser)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	if (!($user instanceof ElggUser)) {
		return false;
	}
	
	if (!questions_experts_enabled()) {
		// only applies to experts
		return false;
	}
	
	if (!questions_is_expert($container, $user)) {
		// not an expert
		return false;
	}
	
	// check group setting
	$group_setting = $container->getPrivateSetting('questions_auto_mark_correct');
	
	return ($group_setting === 'yes');
}
