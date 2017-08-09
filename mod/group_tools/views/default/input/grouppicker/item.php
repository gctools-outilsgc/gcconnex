<?php

/**
 *
 * Group Tools
 * 
 * Group view in Group Picker
 *
 * @package Elgg
 * @subpackage Core
 *
 * @todo remove this view (it's the same as in group tools)
 *
 * @uses $vars['entity'] Group entity
 * @uses $vars['input_name'] Name of the returned data array
 *
 * @author ColdTrick IT Solutions
 */

/* @var ElggEntity $entity */
$entity = elgg_extract('entity', $vars);
$input_name = elgg_extract('input_name', $vars);

// build elements
$icon = elgg_view_entity_icon($entity, 'tiny', ['use_hover' => false]);
$delete_icon = elgg_view_icon('delete-alt', 'elgg-group-picker-remove');

// list item
$image_block = elgg_view_image_block($icon, $entity->name, ['image_alt' => $delete_icon]);

$input = elgg_view('input/hidden', [
	'name' => "{$input_name}[]",
	'value' => $entity->getGUID(),
]);

echo elgg_format_element('li', ['data-guid' => $entity->getGUID()], $image_block . $input);
