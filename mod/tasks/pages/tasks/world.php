<?php
/**
 * List all tasks
 *
 * @package ElggPages
 */

$title = elgg_echo('tasks:all');

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('tasks'));

elgg_register_title_button();

$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => 'task_top',
	'full_view' => false,
));
if (!$content) {
	$content = '<p>' . elgg_echo('tasks:none') . '</p>';
}

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('tasks/sidebar'),
));

echo elgg_view_page($title, $body);
