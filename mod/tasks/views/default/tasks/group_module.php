<?php
/**
 * Group tasks
 *
 * @package ElggTasks
 */


$group = elgg_get_page_owner_entity();

if ($group->tasks_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "tasks/group/$group->guid/all",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));


elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'task_top',
	'container_guid' => elgg_get_page_owner_guid(),
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
);
$content = elgg_list_entities($options);
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('tasks:none') . '</p>';
}

$new_link = elgg_view('output/url', array(
	'href' => "tasks/add/$group->guid",
	'text' => elgg_echo('tasks:add'),
	'is_trusted' => true,
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('tasks:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
