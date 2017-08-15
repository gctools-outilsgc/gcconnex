<?php

/**
 * Group Tools
 *
 * Group entity view
 *
 * @package ElggGroups
 * @author ColdTrick IT Solutions
 * 
 */

$group = $vars['entity'];

$icon = elgg_view_entity_icon($group, 'tiny');

if ((elgg_in_context('livesearch') || elgg_in_context('owner_block') || elgg_in_context('widgets')) && !elgg_in_context('widgets_groups_show_members')) {
	$metadata = '';
} else {
	$metadata = elgg_view_menu('entity', [
		'entity' => $group,
		'handler' => 'groups',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	]);
}

if ($vars['full_view']) {
	echo elgg_view('groups/profile/summary', $vars);
} else {
	// brief view
	$params = [
		'entity' => $group,
		'metadata' => $metadata,
		'subtitle' => $group->briefdescription,
	];
	$params = $params + $vars;
	$list_body = elgg_view('group/elements/summary', $params);

	echo elgg_view_image_block($icon, $list_body, $vars);
}
