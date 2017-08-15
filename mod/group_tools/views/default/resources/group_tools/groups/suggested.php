<?php
/**
 * List suggested groups
 */

elgg_gatekeeper();

// for consistency with other tabs
elgg_push_breadcrumb(elgg_echo('groups'));

// only register title button if allowed
if ((elgg_get_plugin_setting('limited_groups', 'groups') != 'yes') || elgg_is_admin_logged_in()) {
	elgg_register_title_button();
}

$selected_tab = 'suggested';

// build page elements
// limit to 9 so we can have a nice 3 x 3 grid
$groups = group_tools_get_suggested_groups(elgg_get_logged_in_user_entity(), 9);
if (!empty($groups)) {
	// list suggested groups
	$content = elgg_view('output/text', [
		'value' => elgg_echo('group_tools:suggested_groups:info'),
	]);
	$content .= elgg_view('group_tools/suggested', [
		'groups' => $groups,
	]);
} else {
	$content = elgg_echo('group_tools:suggested_groups:none');
}

$filter = elgg_view('groups/group_sort_menu', [
	'selected' => $selected_tab,
]);

$sidebar = elgg_view('groups/sidebar/find');
$sidebar .= elgg_view('groups/sidebar/featured');

// build page
$body = elgg_view_layout('content', [
	'content' => $content,
	'sidebar' => $sidebar,
	'filter' => $filter,
]);

// draw page
echo elgg_view_page(elgg_echo('group_tools:groups:sorting:suggested'), $body);
