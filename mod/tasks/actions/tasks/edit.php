<?php
/**
 * Create or edit a task
 *
 * @package ElggTasks
 */

$variables = elgg_get_config('tasks');
$input = array();
foreach ($variables as $name => $type) {
	$input[$name] = get_input($name);
	if ($name == 'title') {
		$input[$name] = strip_tags($input[$name]);
	}
	if ($type == 'tags') {
		$input[$name] = string_to_tag_array($input[$name]);
	}
}

// Get guids
$task_guid = (int)get_input('task_guid');
$container_guid = (int)get_input('container_guid');
$parent_guid = (int)get_input('parent_guid');

elgg_make_sticky_form('task');

if (!$input['title']) {
	register_error(elgg_echo('tasks:error:no_title'));
	forward(REFERER);
}

if ($task_guid) {
	$task = get_entity($task_guid);
	if (!$task || !$task->canEdit()) {
		register_error(elgg_echo('tasks:cantedit'));
		forward(REFERER);
	}
	$new_task = false;
} else {
	$task = new ElggObject();
	if ($parent_guid) {
		$task->subtype = 'task';
	} else {
		$task->subtype = 'task_top';
	}
	$new_task = true;
}

if (sizeof($input) > 0) {
	foreach ($input as $name => $value) {
		$task->$name = $value; echo $name.',';
	}
}

// need to add check to make sure user can write to container
$task->container_guid = $container_guid;

if ($parent_guid) {
	$task->parent_guid = $parent_guid;
}

if ($task->save()) { 

	elgg_clear_sticky_form('task');

	// Now save description as an annotation
	$task->annotate('task', $task->description, $task->access_id);

	system_message(elgg_echo('tasks:saved'));

	if ($new_task) {
		add_to_river('river/object/task/create', 'create', elgg_get_logged_in_user_guid(), $task->guid);
	}

	forward($task->getURL());
} else {
	register_error(elgg_echo('tasks:notsaved'));
	forward(REFERER);
}
