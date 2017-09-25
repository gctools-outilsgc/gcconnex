<?php

$entity = elgg_extract('entity', $vars);

$title = elgg_echo('linkedin:volunteer_experiences:label', array($entity->title, $entity->company));

if ($entity->calendar_start) {
	$date = date("j F Y", $entity->calendar_start);
	$subtitle[] = $date;
}
if ($entity->calendar_end) {
	$date = date("j F Y", $entity->calendar_end);
	$subtitle[] = $date;
} else {
	$subtitle[] = elgg_echo('linkedin:is_current');
}

$description = elgg_view('output/longtext', array(
	'value' => $entity->description
));

echo elgg_view('object/elements/summary', array(
	'entity' => $entity,
	'title' => $title,
	'subtitle' => implode(' - ', $subtitle),
	'content' => $description
));
