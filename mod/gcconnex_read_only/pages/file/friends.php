<?php
/**
 * Friends Files
 *
 * @package ElggFile
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('', '404');
}

elgg_push_breadcrumb(elgg_echo('file'), "file/all");
elgg_push_breadcrumb($owner->name, "file/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

$title = elgg_echo("file:friends");

$content = elgg_list_entities_from_relationship(array(
	'type' => 'object',
	'subtype' => 'file',
	'full_view' => false,
	'relationship' => 'friend',
	'relationship_guid' => $owner->guid,
	'relationship_join_on' => 'container_guid',
	'no_results' => elgg_echo("file:none"),
	'preload_owners' => true,
	'preload_containers' => true,
));

$sidebar = file_get_type_cloud($owner->guid, true);

elgg_unregister_menu_item('title2', 'new_folder');

$body = elgg_view_layout('content', array(
	'filter_context' => 'friends',
	'content' => $content  . elgg_unregister_menu_item('title', 'new_folder'),//change title2 cause phpwarning: Object of class ElggMenuItem could not be converted to string
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
