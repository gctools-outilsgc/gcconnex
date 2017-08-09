<?php

/**
 * Group Tools
 *
 *  Group module to show related groups
 *
 * @author ColdTrick IT Solutions
 * 
 */

$group = elgg_extract('entity', $vars);
if (!($group instanceof ElggGroup)) {
	return;
}

if ($group->related_groups_enable !== 'yes') {
	return;
}

$all_link = elgg_view('output/url', [
	'href' => "groups/related/{$group->getGUID()}",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
]);

$dbprefix = elgg_get_config('dbprefix');

$options = [
	'type' => 'group',
	'limit' => 4,
	'relationship' => 'related_group',
	'relationship_guid' => $group->getGUID(),
	'full_view' => false,
	'joins' => [
		"JOIN {$dbprefix}groups_entity ge ON e.guid = ge.guid",
	],
	'order_by' => 'ge.name ASC',
	'no_results' => elgg_echo('groups_tools:related_groups:none'),
];

elgg_push_context('widgets');
$content = elgg_list_entities_from_relationship($options);
elgg_pop_context();

echo elgg_view('groups/profile/module', [
	'title' => elgg_echo('groups_tools:related_groups:widget:title'),
	'content' => $content,
	'all_link' => $all_link,
]);
