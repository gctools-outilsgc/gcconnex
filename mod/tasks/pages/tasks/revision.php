<?php
/**
 * View a revision of task
 *
 * @package ElggTasks
 */

$id = get_input('id');
$annotation = elgg_get_annotation_from_id($id);
if (!$annotation) {
	forward();
}

$task = get_entity($annotation->entity_guid);
if (!$task) {
	
}

elgg_set_page_owner_guid($task->getContainerGUID());

group_gatekeeper();

$container = elgg_get_page_owner_entity();
if (!$container) {
}

$title = $task->title . ": " . elgg_echo('tasks:revision');

if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb($container->name, "tasks/group/$container->guid/all");
} else {
	elgg_push_breadcrumb($container->name, "tasks/owner/$container->username");
}
tasks_prepare_parent_breadcrumbs($task);
elgg_push_breadcrumb($task->title, $task->getURL());
elgg_push_breadcrumb(elgg_echo('tasks:revision'));

$content = elgg_view('object/task_top', array(
	'entity' => $task,
	'revision' => $annotation,
	'full_view' => true,
));

$sidebar = elgg_view('tasks/sidebar/history', array('task' => $task));

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
