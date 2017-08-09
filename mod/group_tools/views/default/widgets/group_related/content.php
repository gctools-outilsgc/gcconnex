<?php
/**
 * Content view of the related groups widget
 */

$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 4;
}

$dbprefix = elgg_get_config('dbprefix');

$options = [
	'type' => 'group',
	'limit' => $num_display,
	'relationship' => 'related_group',
	'relationship_guid' => $widget->getOwnerGUID(),
	'full_view' => false,
	'pagination' => false,
	'joins' => [
		"JOIN {$dbprefix}groups_entity ge ON e.guid = ge.guid",
	],
	'order_by' => 'ge.name ASC',
	'no_results' => elgg_echo('groups_tools:related_groups:none'),
];

echo elgg_list_entities_from_relationship($options);
