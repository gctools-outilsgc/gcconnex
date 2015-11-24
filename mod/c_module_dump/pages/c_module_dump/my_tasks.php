<?php
/**
 * List a user's or group's tasks
 *
 * @package ElggPages
 */

// grab the username of the page
$username_page = get_input('username');
$owner = get_user_by_username($username_page);

if (!$owner) 
	forward('tasks/all');

$title = elgg_echo('tasks:owner', array($owner->name));
elgg_push_breadcrumb($owner->name);

elgg_register_title_button();

// cyu - configured to get the tasks based on the current worker
$content = elgg_list_entities_from_metadata(array(
	'metadata_names' => 'assigned_to',
	'metadata_values' => $owner->guid,
	'types' => 'object',
	'subtypes' => 'task_top',
	'limit' => $limit,
	'full_view' => false,
));

if (!$content)
	$content = '<p>'.elgg_echo('tasks:none') . '</p>';

$filter_context = '';
if ($owner->guid == elgg_get_logged_in_user_guid())
	$filter_context = 'my_tasks';

$sidebar = elgg_view('tasks/sidebar/navigation');
$sidebar .= elgg_view('tasks/sidebar');

$params = array(
	'filter_context' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
