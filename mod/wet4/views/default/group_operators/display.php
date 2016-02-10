<?php
/**
 * Elgg group operator display
 *
 * @uses $vars['entity'] ElggUser operator
 * @uses $vars['size']   Size of the icon
 * @uses $vars['group'] ElggGroup group which the operator have permissons
 */

$entity = elgg_extract('entity', $vars);
$size = elgg_extract('size', $vars, 'tiny');
$group = elgg_extract('group', $vars);

$icon = elgg_view_entity_icon($entity, 'medium');

$title = "<a href=\"" . $entity->getUrl() . "\" $rel>" . $entity->name . "</a>";

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'group_operators',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz mrgn-lft-0',
    'item_class' => 'mrgn-lft-sm',
));

$params = array(
	'entity' => $entity,
	'metadata' => $metadata,
	'title' => $title,
);


	$list_body = elgg_view('user/elements/summary', $params);

	echo elgg_view_image_block($icon, $list_body);

    elgg_unregister_menu_item('entity', 'edit');