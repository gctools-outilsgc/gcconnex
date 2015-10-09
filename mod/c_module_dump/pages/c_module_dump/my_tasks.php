<?php
/**
 * List a user's friends' tasks
 *
 * @package ElggTasks
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('tasks/all');
}

elgg_push_breadcrumb($owner->name, "tasks/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('my task'));

elgg_register_title_button();

$title = elgg_echo('my task');

//$content = list_user_friends_objects($owner->guid, 'task_top', 10, false);

// cyu - 09/08/2015 : configured to get the tasks based on the current worker
$content = elgg_list_entities_from_metadata(array(
	'metadata_names' => 'assigned_to',
	'metadata_values' => $owner->guid,
	'types' => 'object',
	'subtypes' => 'task_top',
	'limit' => $limit,
	'full_view' => false,
));

if (!$content) {
	$content = elgg_echo('tasks:none');
}

$params = array(
	'filter_context' => 'my_task',
	'filter_override' => elgg_view('filter_override/taskspagefilter',array("filter_context"=>'my_task')),
	'content' => $content,
	'title' => $title,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);