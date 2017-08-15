<?php
/**
 * content of the group members widget
 */

$widget = elgg_extract('entity', $vars);

$count = (int) $widget->num_display;
if ($count < 1) {
	$count = 5;
}

$options = [
	'type' => 'user',
	'limit' => $count,
	'relationship' => 'member',
	'relationship_guid' => $widget->getOwnerGUID(),
	'inverse_relationship' => true,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
	'pagination' => false,
	'no_results' => elgg_echo('widgets:group_members:view:no_members'),
];

echo elgg_list_entities_from_relationship($options);
