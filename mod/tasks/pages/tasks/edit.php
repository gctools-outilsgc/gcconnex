<?php
/**
 * Edit a task
 *
 * @package ElggTasks
 */

gatekeeper();

$task_guid = (int)get_input('guid');
$task = get_entity($task_guid);
if (!$task) {
	register_error(elgg_echo('noaccess'));
	forward('');
}

$container = $task->getContainerEntity();
if (!$container) {
	register_error(elgg_echo('noaccess'));
	forward('');
}

elgg_set_page_owner_guid($container->getGUID());

elgg_push_breadcrumb($task->title, $task->getURL());
elgg_push_breadcrumb(elgg_echo('edit'));

$title = elgg_echo("tasks:edit");

if ($task->canEdit()) {
	$vars = tasks_prepare_form_vars($task);
	$content = elgg_view_form('tasks/edit', array(), $vars);
} else {
	$content = elgg_echo("tasks:noaccess");
}

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
