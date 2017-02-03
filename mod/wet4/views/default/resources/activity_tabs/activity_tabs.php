<?php

/**
 * Main activity stream list page
 */
$options = array();

$page_type = preg_replace('[\W]', '', $vars['page_type']);
$type = preg_replace('[\W]', '', get_input('type', 'all'));
$subtype = preg_replace('[\W]', '', get_input('subtype', ''));

$id = sanitize_int($vars['guid']);

//sanity check
if (!is_numeric($id)) {
	register_error(elgg_echo('activity_tabs:invalid:id'));
	forward('activity', 'activity_tabs_invalid_id');
}

if ($subtype) {
	$selector = "type=$type&subtype=$subtype";
} else {
	$selector = "type=$type";
}

if ($type != 'all') {
	$options['type'] = $type;
	if ($subtype) {
		$options['subtype'] = $subtype;
	}
}

// deal with the special case of group access collection
$display = elgg_get_plugin_user_setting('group_' . $id . '_display', elgg_get_logged_in_user_guid(), PLUGIN_ID);
if ($page_type == 'group' && $display != 'group') {
	$page_type = 'collection';
	$id = get_entity($id)->group_acl;
}

switch ($page_type) {
	case 'user':
		$title = elgg_echo('activity_tabs:user');
		$page_filter = 'activity_tab';

		$options['subject_guid'] = $id;
		break;
	case 'group':
		$db_prefix = elgg_get_config('dbprefix');
		$title = elgg_echo('activity_tabs:group');
		$page_filter = 'activity_tab';
		$options['joins'] = array("JOIN {$db_prefix}entities e ON e.guid = rv.object_guid");
		$options['wheres'] = array("e.container_guid = $id");
		break;
	case 'mydept':
		$title = elgg_echo('activity_tabs:collection');
		$page_filter = 'activity_tab';
		
		$db_prefix = elgg_get_config('dbprefix');
		$dept = elgg_get_logged_in_user_entity()->department;
		$options['joins'] = array("INNER JOIN {$db_prefix}metadata md ON md.entity_guid = rv.subject_guid LEFT JOIN {$db_prefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$db_prefix}metastrings msv ON md.value_id = msv.id");	// we need this to filter by metadata
		$options['wheres'] = array("msn.string = \"department\" AND msv.string LIKE \"{$dept}\"");
		break;
	case 'otherdept':
		$title = elgg_echo('activity_tabs:collection');
		$page_filter = 'activity_tab';

		$db_prefix = elgg_get_config('dbprefix');
		$dept = elgg_get_logged_in_user_entity()->department;
		$options['joins'] = array("INNER JOIN {$db_prefix}metadata md ON md.entity_guid = rv.subject_guid LEFT JOIN {$db_prefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$db_prefix}metastrings msv ON md.value_id = msv.id");	// we need this to filter by metadata
		$options['wheres'] = array("msn.string = \"department\" AND msv.string NOT LIKE \"{$dept}\"");
		break;
	case 'collection':
	default:
		$title = elgg_echo('activity_tabs:collection');
		$page_filter = 'activity_tab';

		$options['subject_guid'] = $members;
		break;
}

$options['no_results'] = elgg_echo('river:none');
$activity = elgg_list_river($options);

$content = elgg_view('core/river/filter', array('selector' => $selector));

$html = elgg_view('widgets/most_liked/content');

$sidebar = elgg_view_module('aside', elgg_echo('activity:module:weekly_likes'), $html);//elgg_view('core/river/sidebar');

$params = array(
	'content' => $content . $activity,
	'sidebar' => $sidebar,
	'filter_context' => $page_filter,
	'class' => 'elgg-river-layout',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
