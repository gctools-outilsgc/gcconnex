<?php

if (elgg_in_context('widgets')) {
	return true;
}

$entity = elgg_extract('entity', $vars, false);

if (!$entity) return true;

$params = array(
	'entity' => $entity,
	'class' => elgg_extract('class', $vars, 'elgg-menu-hz'),
	'sort_by' => 'priority',
	'dropdown' => elgg_extract('dropdown', $vars, false)
);

echo elgg_view_menu('entity', $params);

