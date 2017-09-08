<?php
/**
 * Elgg bookmarks plugin everyone page
 *
 * @package Bookmarks
 */
$lang = get_current_language();
elgg_group_gatekeeper();

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner) {
	forward('', '404');
}

$title_bookmarks = elgg_echo('bookmarks:owner', array(gc_explode_translation($page_owner->name, $lang)));
$title = elgg_echo(gc_explode_translation($page_owner->name, $lang));

elgg_push_breadcrumb($title);

elgg_register_title_button('bookmarks', 'add', 'object', 'bookmarks');

$options = [
	'type' => 'object',
	'subtype' => 'bookmarks',
	'full_view' => false,
	'view_toggle_type' => false,
	'no_results' => elgg_echo('bookmarks:none'),
	'preload_owners' => true,
	'distinct' => false,
];

if ($page_owner instanceof ElggGroup) {
	$options['container_guid'] = $page_owner->guid;
} else {
	$options['owner_guid'] = $page_owner->guid;
}

$content .= elgg_list_entities($options);

$filter_context = '';
if ($page_owner->getGUID() == elgg_get_logged_in_user_guid()) {
	$filter_context = 'mine';
}

$vars = array(
	'filter_context' => $filter_context,
	'content' => $content,
	'title' => $title_bookmarks,
	'sidebar' => elgg_view('bookmarks/sidebar'),
);

// don't show filter if out of filter context
if ($page_owner instanceof ElggGroup) {
	$vars['filter'] = false;
}

$body = elgg_view_layout('content', $vars);

echo elgg_view_page($title, $body);
