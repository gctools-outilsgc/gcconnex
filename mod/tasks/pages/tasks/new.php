<?php
/**
 * Create a new task
 *
 * @package ElggTasks
 */

gatekeeper();

$container_guid = (int) get_input('guid');
$container = get_entity($container_guid);
if (!$container) {

}

$parent_guid = 0;
$task_owner = $container;
if (elgg_instanceof($container, 'object')) {
	$parent_guid = $container->getGUID();
	$task_owner = $container->getContainerEntity();
}

elgg_set_page_owner_guid($task_owner->getGUID());

$title = elgg_echo('tasks:add');
elgg_push_breadcrumb($title);

$vars = tasks_prepare_form_vars(null, $parent_guid); 
$content = elgg_view_form('tasks/edit', array(), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
