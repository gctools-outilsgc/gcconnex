<?php
/**
 * Individual's or group's files
 *
 * @package ElggFile
 */

// access check for closed groups
elgg_group_gatekeeper();
$lang = get_current_language();
$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('', '404');
}

elgg_push_breadcrumb(elgg_echo('file'), "file/all");
elgg_push_breadcrumb(gc_explode_translation($owner->name, $lang));

$params = array();

if ($owner->guid == elgg_get_logged_in_user_guid()) {
	// user looking at own files
	$params['filter_context'] = 'mine';
} else if (elgg_instanceof($owner, 'user')) {
	// someone else's files
	// do not show select a tab when viewing someone else's posts
	$params['filter_context'] = 'none';
} else {
	// group files
	$params['filter'] = '';
}

$title = elgg_echo("file:user", array(gc_explode_translation($owner->name, $lang)));

// List files
$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'file',
	'container_guid' => $owner->guid,
	'full_view' => false,
	'no_results' => elgg_echo("file:none"),
	'preload_owners' => true,
	'distinct' => false,
));

$sidebar = file_get_type_cloud(elgg_get_page_owner_guid());
$sidebar .= elgg_view('file/sidebar');

$params['content'] = $content;
$params['title'] = $title;
$params['sidebar'] = $sidebar;

elgg_unregister_menu_item('title2', 'new_folder');

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
