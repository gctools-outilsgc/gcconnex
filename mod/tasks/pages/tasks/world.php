<?php
/**
 * List all Tasks
 *
 * @package ElggPages
 */
 

$title = elgg_echo('tasks:all');

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('tasks'));

elgg_register_title_button();

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'task_top',
	'full_view' => false,
	'no_results' => elgg_echo('tasks:none'),
));

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'filter_override' => elgg_view('filter_override/taskspagefilter',array("filter_context"=>'all')),
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('tasks/sidebar'),
));

echo elgg_view_page($title, $body);
