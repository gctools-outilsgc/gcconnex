<?php

$entity = elgg_extract('entity', $vars);

$title = elgg_echo('linkedin:position:label', array($entity->title, $entity->company));
$calendar_start = date("F Y", mktime(0, 0, 0, $entity->calendar_start_month, 0, $entity->calendar_start_year));
$calendar_end = ($entity->is_current) ? elgg_echo('linkedin:is_current') : date("F Y", mktime(0, 0, 0, $entity->calendar_end_month, 0, $entity->calendar_end_year));

echo elgg_view('object/elements/summary', array(
	'entity' => $entity,
	'title' => $title,
	'subtitle' => "$calendar_start - $calendar_end",
	'content' => elgg_view('output/longtext', array(
		'value' => $entity->description
	))
));
