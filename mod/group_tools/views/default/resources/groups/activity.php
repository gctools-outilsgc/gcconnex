<?php
/**
 * the river page of a group
 *
 * Reasons for override
 * - add type/subtype filter
 * - don't use distinct in river query (for small performance increase)
 *
 */

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'group');

elgg_set_page_owner_guid($guid);

elgg_group_gatekeeper();

$lang = get_current_language();

// remove thewire_tools double extend
elgg_unextend_view('core/river/filter', 'thewire_tools/activity_post');

// get inputs
$group = get_entity($guid);
$type = preg_replace('[\W]', '', get_input('type', 'all'));
$subtype = preg_replace('[\W]', '', get_input('subtype', ''));
if ($subtype) {
	$selector = "type={$type}&subtype={$subtype}";
} else {
	$selector = "type={$type}";
}

// set river options
$db_prefix = elgg_get_config('dbprefix');
$options = [
	'distinct' => false,
	'joins' => [
		"JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid",
		"LEFT JOIN {$db_prefix}entities e2 ON e2.guid = rv.target_guid",
	],
	'wheres' => [
		"(e1.container_guid = {$group->getGUID()} OR e2.container_guid = {$group->getGUID()})",
	],
	'no_results' => elgg_echo('groups:activity:none'),
];

if ($type != 'all') {
	$options['type'] = $type;
	if ($subtype) {
		$options['subtype'] = $subtype;
	}
}

// build page elements
$title = elgg_echo('groups:activity');

elgg_push_breadcrumb(gc_explode_translation($group->name,$lang), $group->getURL());
elgg_push_breadcrumb($title);

$content = elgg_view('core/river/filter', [
	'selector' => $selector,
]);
$content .= elgg_list_river($options);

// build page
$body = elgg_view_layout('content', [
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'class' => 'elgg-river-layout',
]);

// draw page
echo elgg_view_page($title, $body);
