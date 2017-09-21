<?php

$entity = elgg_extract('entity', $vars);

$title = $entity->title;

if ($entity->number) {
	$subtitle[] = elgg_echo('linkedin:course:number', array($entity->number));
}

echo elgg_view('object/elements/summary', array(
	'entity' => $entity,
	'title' => $title,
	'subtitle' => implode('<br />', $subtitle),
	'content' => ''
));
