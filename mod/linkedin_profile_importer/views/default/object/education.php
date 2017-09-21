<?php

$entity = elgg_extract('entity', $vars);

if ($entity->degree) {
	$title = "$entity->degree, ";
}
$title .= "$entity->description, $entity->title";

$calendar_start = $entity->calendar_start_year;
$calendar_end = (!$entity->calendar_end_year) ? elgg_echo('linkedin:is_current') : $entity->calendar_end_year;

echo elgg_view('object/elements/summary', array(
	'entity' => $entity,
	'title' => $title,
	'subtitle' => "$calendar_start - $calendar_end",
	'tags' => $entity->activities,
	'content' => elgg_view('output/longtext', array(
		'value' => $entity->notes
	))
));
