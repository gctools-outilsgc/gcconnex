<?php
/**
 * All files
 *
 * @package ElggFile
 */

elgg_push_breadcrumb(elgg_echo('file'));

$title = elgg_echo('file:all');

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'file',
	'full_view' => false,
	'no_results' => elgg_echo("file:none"),
	'preload_owners' => true,
	'preload_containers' => true,
	'distinct' => false,
));

$sidebar = file_get_type_cloud();
$sidebar .= elgg_view('file/sidebar');

elgg_unregister_menu_item('title2', 'new_folder');

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content . elgg_unregister_menu_item('title', 'new_folder'), //change title2 cause phpwarning: Object of class ElggMenuItem could not be converted to string
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
