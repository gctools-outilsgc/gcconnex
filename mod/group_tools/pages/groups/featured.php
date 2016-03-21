<?php
/**
 * List featured groups
 */


// for consistency with other tabs
elgg_push_breadcrumb(elgg_echo("groups"));

// only register title button if allowed
if ((elgg_get_plugin_setting("limited_groups", "groups") != "yes") || elgg_is_admin_logged_in()) {
	elgg_register_title_button();
}

$selected_tab = "featured";

$featured_groups = elgg_get_entities_from_metadata(array(
	'metadata_name' => 'featured_group',
	'metadata_value' => 'yes',
	'type' => 'group',
));
if ($featured_groups) {

	//$body = '';
    $content = '<div class="clearfix">';
	foreach ($featured_groups as $group) {
		$content .= elgg_view_entity($group, array('full_view' => false, 'class' => 'list-break '));
	}
    $content .= '</div>';
}else{
	$content = elgg_echo("group_tools:suggested_groups:none");
}

$filter = elgg_view("groups/group_sort_menu", array("selected" => $selected_tab));

$sidebar = elgg_view("groups/sidebar/find");
$sidebar .= elgg_view("groups/sidebar/suggested");

$params = array(
    "title" => elgg_echo('groups'),
	"content" => $content,
	"sidebar" => $sidebar,
	"filter" => $filter,
);

$body = elgg_view_layout("content", $params);

echo elgg_view_page(elgg_echo("groups:featured"), $body);