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
		
		
		// FXN - Ajout des champs sp�cifiques, serait mieux autre part en fait
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
		'limit' => false
	));

	if ($top_tasks) {
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
					'limit' => false,
					'metadata_name_value_pairs' => array(
						'name' => 'parent_guid',
						'value' => $parent->getGUID()
					)
				));
				
				if ($children) {
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
	}
}


function tasks_get_json($options) {

	$entities_options = array(
			'type' 			=> 'object',
			'subtype' 		=> 'task_top',
			'limit' 		=> false,
			'metadata_name_value_pairs_operator' => 'OR',
			'joins' => array(),
			'wheres' => array(),
			'order_by_metadata' => array("name" => 'start_date', "direction" => 'ASC', "as" => "text")
		);
		
	$oEntity = get_entity($options['owner']);
	
	if (elgg_instanceof($oEntity , 'group')){
		$entities_options['container_guid'] = $options['owner'];
	}elseif($options["owner"] && $options['filter'] == 'mine'){
		$entities_options['owner_guid'] = $options['owner'];
		$entities_options['container_guid'] = $options['owner'];
	}elseif($options["owner"] && $options['filter'] == 'friends' ){
		$friends = get_user_friends($options["owner"], "", 999999, 0);
		$friendguids = array();
		foreach ($friends as $friend) {
             $friendguids[] = $friend->getGUID();
        }
		$entities_options['owner_guid'] = $friendguids;
	}

	if(!empty($options['start_date'])) {
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'start_date', 'value' => $options['start_date'], 'operand' => '>=');
	}
	
	if(!empty($options['end_date'])) {
		$entities_options['metadata_name_value_pairs'][] = array('name' => 'end_date', 'value' => $options['end_date'], 'operand' => '<=');
	}

	$tasks = elgg_get_entities_from_metadata($entities_options);
	$result = array();
	foreach($tasks as $task){
	
		$oname 	= $task->getOwnerEntity()->name;
		$mine 	= $task->getOwnerGUID() == elgg_get_logged_in_user_entity()->guid; 
		$friend = $task->getOwnerEntity()->isFriendsWith(elgg_get_logged_in_user_entity()->guid);
		$group	= elgg_instanceof($task->getContainerEntity(), 'group');
		$tag_string = '';
		if (is_array($task->tags)) {
			$tags = array();

			foreach ($task->tags as $tag) {
				if (is_string($tag)) {
					$tags[] = $tag;
				} else {
					$tags[] = $tag->value;
				}
			}

			$tag_string = implode(", ", $tags);
		}
	
		$result[] = array(
			"id"=>$task->guid,
			"container_guid"=>$task->getContainerGUID(),
			"parent_guid"=>$task->parent_guid,
			
			'title' => $task->title,
			'start' => $task->start_date,
			'end' => $task->end_date,

			'description' => $task->description,
			'task_type' => $task->task_type,
			'status' => $task->status,
			'assigned_to' => $task->assigned_to,
			'percent_done' => $task->percent_done,
			'work_remaining' => $task->work_remaining,
			
			'tags' => $tag_string,
			'access_id' => $task->access_id,
			'write_access_id' => $task->write_access_id,
			
			"oname" => $oname,
			
			"color" => ($group ? 'DarkSlateBlue' : ( $friend ? 'HotPink' : ($mine ? 'DarkGreen' : ''))),
			"url"	=> elgg_get_site_url().'tasks/view/'.$task->guid,
			"editable" => $task->canEdit() ? 'true' : 'false',

			
		);
	}
	die(json_encode($result));	
}
