<?php
/**
 * A page to show (and add) related groups
 */

$group_guid = (int) elgg_extract('guid', $vars);

elgg_entity_gatekeeper($group_guid, 'group');
$group = get_entity($group_guid);

// set page owner
elgg_set_page_owner_guid($group->getGUID());

// build breadcrumb
elgg_push_breadcrumb(elgg_echo('groups'), 'groups/all');
elgg_push_breadcrumb($group->name, $group->getURL());

$title_text = elgg_echo('group_tools:related_groups:title');
elgg_push_breadcrumb($title_text);

// page elements
$content = '';
if ($group->canEdit()) {
	$content .= elgg_view_form('group_tools/related_groups', [
		'class' => 'mbm',
	], [
		'entity' => $group,
	]);
}

$dbprefix = elgg_get_config('dbprefix');

$options = [
	'type' => 'group',
	'relationship' => 'related_group',
	'relationship_guid' => $group->getGUID(),
	'full_view' => false,
	'joins' => [
		"JOIN {$dbprefix}groups_entity ge ON e.guid = ge.guid",
	],
	'order_by' => 'ge.name ASC',
	'no_results' => elgg_echo('groups_tools:related_groups:none'),
];

// helper context for entity menu
elgg_push_context('group_tools_related_groups');

$content .= elgg_list_entities_from_relationship($options);

elgg_pop_context();

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title_text,
	'content' => $content,
	'filter' => '',
]);

// draw page
echo elgg_view_page($title_text, $page_data);
