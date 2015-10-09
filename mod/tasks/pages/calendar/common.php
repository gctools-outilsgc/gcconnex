<?php
/**
 * Calendar for all Tasks
 *
 * @package ElggPages
 */
 

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('tasks').' Calendar');
elgg_register_title_button('tasks');

elgg_load_css('fullcalendar.css');
elgg_load_js('fullcalendar.js');
elgg_load_js('fullcalendar_moment.js');


$content= elgg_view('tasks/calendar', array("owner"=>elgg_get_page_owner_guid(), "filter"=>$filter_context));

$body = elgg_view_layout('content', array(
	'filter_override' => elgg_view('filter_override/taskspagefilter',array("filter_context"=>$filter_context)),
	'filter_context' => $filter_context,
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('tasks/sidebar'),
));

echo elgg_view_page($title, $body);
