<?php

$entity = elgg_extract('entity', $vars, false);

if (!$entity) return true;

$params = array(
	'entity' => $entity,
	'class' => 'elgg-menu-hz',
	'sort_by' => 'priority',
	'full_view' => false
);

echo elgg_view_menu('entity', $params);

