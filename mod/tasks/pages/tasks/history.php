<?php
/**
 * History of revisions of a task
 *
 * @package ElggPages
 */

$task_guid = get_input('guid');

$task = get_entity($task_guid);
if (!$task) {

}

$container = $task->getContainerEntity();
if (!$container) {

}

elgg_set_page_owner_guid($container->getGUID());

if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb($container->name, "tasks/group/$container->guid/all");
} else {
	elgg_push_breadcrumb($container->name, "tasks/owner/$container->username");
}
tasks_prepare_parent_breadcrumbs($task);
elgg_push_breadcrumb($task->title, $task->getURL());
elgg_push_breadcrumb(elgg_echo('tasks:history'));

$title = $task->title . ": " . elgg_echo('tasks:history');

$content = list_annotations($task_guid, 'task', 20, false);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('tasks/sidebar/navigation', array('task' => $task)),
));

echo elgg_view_page($title, $body);
