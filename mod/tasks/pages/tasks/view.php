<?php
/**
 * View a single task
 *
 * @package ElggTasks
 */

$task_guid = get_input('guid');
$task = get_entity($task_guid);
if (!$task) {
	forward();
}

elgg_set_page_owner_guid($task->getContainerGUID());

group_gatekeeper();

$container = elgg_get_page_owner_entity();
if (!$container) {
}

$title = $task->title;

if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb($container->name, "tasks/group/$container->guid/all");
} else {
	elgg_push_breadcrumb($container->name, "tasks/owner/$container->username");
}
tasks_prepare_parent_breadcrumbs($task);
elgg_push_breadcrumb($title);

$content = elgg_view_entity($task, array('full_view' => true));
$content .= elgg_view_comments($task);

if (elgg_get_logged_in_user_guid() == $task->getOwnerGuid()) {
	$url = "tasks/add/$task->guid";
	elgg_register_menu_item('title', array(
			'name' => 'subtask',
			'href' => $url,
			'text' => elgg_echo('tasks:newchild'),
			'link_class' => 'elgg-button elgg-button-action',
	));
}

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('tasks/sidebar/navigation'),
));

echo elgg_view_page($title, $body);
