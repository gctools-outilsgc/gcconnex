<?php
/**
 * Remove a task
 *
 * Subtasks are not deleted but are moved up a level in the tree
 *
 * @package ElggTasks
 */

$guid = get_input('guid');
$task = get_entity($guid);
if ($task) {
	if ($task->canEdit() && (elgg_instanceof($task, "object", "task") || elgg_instanceof($task, "object", "task_top"))) {
		$container = get_entity($task->container_guid);

		// Bring all child elements forward
		$parent = $task->parent_guid;
		$children = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => 'task',
			'container_guid' => $task->getContainerGUID(),
			'limit' => false,
			'metadata_name_value_pairs' => array(
				'name' => 'parent_guid',
				'value' => $task->getGUID()
			)
		));
		if ($children) {
			foreach ($children as $child) {
				$child->parent_guid = $parent;
			}
		}
		
		if ($task->delete()) {
			system_message(elgg_echo('tasks:delete:success'));
			if ($parent) {
				if ($parent = get_entity($parent)) {
					forward($parent->getURL());
				}
			}
			if (elgg_instanceof($container, 'group')) {
				forward("tasks/group/$container->guid/all");
			} else {
				forward("tasks/owner/$container->username");
			}
		}
	}
}

register_error(elgg_echo('tasks:delete:failure'));
forward(REFERER);
