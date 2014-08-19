<?php
/**
 * Pages function library
 */

/**
 * Prepare the add/edit form variables
 *
 * @param ElggObject $task
 * @return array
 */
function tasks_prepare_form_vars($task = null, $parent_guid = 0) {

	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		
		
		// FXN - Ajout des champs spécifiques, serait mieux autre part en fait
		'start_date' => '',
		'end_date' => '',
		'task_type' => '',
		'status' => '',
		'assigned_to' => '',
		'percent_done' => '',
		'work_remaining' => '',
		
		'access_id' => ACCESS_DEFAULT,
		'write_access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $task,
		'parent_guid' => $parent_guid,
	);

	if ($task) {
		foreach (array_keys($values) as $field) {
			if (isset($task->$field)) {
				$values[$field] = $task->$field;
			}
		}
	}

	if (elgg_is_sticky_form('task')) {
		$sticky_values = elgg_get_sticky_values('task');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('task');

	return $values;
}

/**
 * Recurses the task tree and adds the breadcrumbs for all ancestors
 *
 * @param ElggObject $task Page entity
 */
function tasks_prepare_parent_breadcrumbs($task) {
	if ($task && $task->parent_guid) {
		$parents = array();
		$parent = get_entity($task->parent_guid);
		while ($parent) {
			array_push($parents, $parent);
			$parent = get_entity($parent->parent_guid);
		}
		while ($parents) {
			$parent = array_pop($parents);
			elgg_push_breadcrumb($parent->title, $parent->getURL());
		}
	}
}

/**
 * Register the navigation menu
 * 
 * @param ElggEntity $container Container entity for the tasks
 */
function tasks_register_navigation_tree($container) {
	if (!$container) {
		return;
	}

	$top_tasks = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'task_top',
		'container_guid' => $container->getGUID(),
	));

	foreach ($top_tasks as $task) {
		elgg_register_menu_item('tasks_nav', array(
			'name' => $task->getGUID(),
			'text' => $task->title,
			'href' => $task->getURL(),
		));

		$stack = array();
		array_push($stack, $task);
		while (count($stack) > 0) {
			$parent = array_pop($stack);
			$children = elgg_get_entities_from_metadata(array(
				'type' => 'object',
				'subtype' => 'task',
				'metadata_name' => 'parent_guid',
				'metadata_value' => $parent->getGUID(),
			));
			
			foreach ($children as $child) {
				elgg_register_menu_item('tasks_nav', array(
					'name' => $child->getGUID(),
					'text' => $child->title,
					'href' => $child->getURL(),
					'parent_name' => $parent->getGUID(),
				));
				array_push($stack, $child);
			}
		}
	}
}
