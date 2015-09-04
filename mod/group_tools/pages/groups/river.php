<?php
/**
 * Add a filter to the river page of a group
 *
 * @todo remove when Elgg core supports this
 */

$guid = (int) get_input("guid");

elgg_entity_gatekeeper($guid, 'group');

elgg_set_page_owner_guid($guid);

elgg_group_gatekeeper();

// remove thewire_tools double extend
elgg_unextend_view("core/river/filter", "thewire_tools/activity_post");

// get inputs
$group = get_entity($guid);
$type = preg_replace('[\W]', '', get_input('type', 'all'));
$subtype = preg_replace('[\W]', '', get_input('subtype', ''));
if ($subtype) {
	$selector = "type=$type&subtype=$subtype";
} else {
	$selector = "type=$type";
}

// set river options
$db_prefix = elgg_get_config('dbprefix');
$options = array(
	'joins' => array(
		"JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid",
		"LEFT JOIN {$db_prefix}entities e2 ON e2.guid = rv.target_guid",
	),
	'wheres' => array(
		"(e1.container_guid = $group->guid OR e2.container_guid = $group->guid)",
	),
	'no_results' => elgg_echo('groups:activity:none'),
);

if ($type != 'all') {
	$options['type'] = $type;
	if ($subtype) {
		$options['subtype'] = $subtype;
	}
}

// build page elements
$title = elgg_echo('groups:activity');

elgg_push_breadcrumb($group->name, $group->getURL());
elgg_push_breadcrumb($title);

$content = elgg_view('core/river/filter', array('selector' => $selector));
$content .= elgg_list_river($options);

$params = array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'class' => 'elgg-river-layout',
);
$body = elgg_view_layout('content', $params);

// draw page
echo elgg_view_page($title, $body);
