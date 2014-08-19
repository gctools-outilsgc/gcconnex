<?php
/**
 * ideas helper functions
 *
 * @package ideas
 */

/**
 * Prepare the add/edit form variables
 *
 * @param ElggObject $idea A idea object.
 * @return array
 */
function ideas_prepare_form_vars($idea = null) {
	$user = elgg_get_logged_in_user_guid();
	
	$values = array(
		'title' => get_input('title', ''),
		'search' => get_input('search', ''),
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'status' => 'open',
		'status_info' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
	);

	if (!$values['title']) $values['title'] = $values['search'];

	if ($idea) {
		foreach (array_keys($values) as $field) {
			if (isset($idea->$field)) {
				$values[$field] = $idea->$field;
			}
		}
	}

	if (elgg_is_sticky_form('idea')) {
		$sticky_values = elgg_get_sticky_values('idea');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('idea');

	return $values;
}


/**
 * Prepare the group settings form variables
 *
 * @param ElggObject $group A group object.
 * @return array
 */
function ideas_group_settings_prepare_form_vars($group = null) {
	
	$values = array(
		'ideas_description' => get_input('ideas_description', ''),
		'ideas_question' => get_input('ideas_question', elgg_echo('ideas:search')),
	);

	if ($group) {
		foreach (array_keys($values) as $field) {
			if (isset($group->$field)) {
				$values[$field] = $group->$field;
			}
		}
	}

	if (elgg_is_sticky_form('ideas_settings')) {
		$sticky_values = elgg_get_sticky_values('ideas_settings');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('ideas_settings');

	return $values;
}
