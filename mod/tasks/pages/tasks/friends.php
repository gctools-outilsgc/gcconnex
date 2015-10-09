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
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button();

$title = elgg_echo('tasks:friends');

$content = list_user_friends_objects($owner->guid, 'task_top', 10, false);
if (!$content) {
	$content = elgg_echo('tasks:none');
}

$params = array(
	'filter_context' => 'friends',
	'filter_override' => elgg_view('filter_override/taskspagefilter',array("filter_context"=>'friends')),
	'content' => $content,
	'title' => $title,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
