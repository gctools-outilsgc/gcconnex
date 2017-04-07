<?php
/**
 * Elgg reading_list plugin owner page
 *
 * @package Reading_List
 */
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('bookmarks'));

//$params["filter_context"] = "featured";

$title = elgg_echo('reading_list');
$page_owner = elgg_get_page_owner_entity();

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'readinglistitem',
	'container_guid' => $page_owner->guid,
	'full_view' => false,
	'view_toggle_type' => false,
	'no_results' => elgg_echo('bookmarks:none'),
	'preload_owners' => true,
	'preload_containers' => true,
	'distinct' => false,
));

$body = elgg_view_layout('content', array(
	'filter_context' => 'reading_list',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);

