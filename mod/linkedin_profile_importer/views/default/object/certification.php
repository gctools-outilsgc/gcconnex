<?php

$entity = elgg_extract('entity', $vars);

$title = $entity->title;

if ($entity->calendar_start) {
	$date = date("j F Y", $entity->calendar_start);
	$subtitle[] = elgg_echo("linkedin:certification:calendar_start", array($date));
}
if ($entity->calendar_end) {
	$date = date("j F Y", $entity->calendar_end);
	$subtitle[] = elgg_echo("linkedin:certification:calendar_end", array($date));
}
if ($entity->authority) {
	$subtitle[] = elgg_echo('linkedin:certification:authority', array($entity->authority));
}
if ($entity->number) {
	$subtitle[] = elgg_echo('linkedin:certification:number', array($entity->number));
}

if ($entity->address) {
	$description .= elgg_view_icon('bookmark') . elgg_view('output/url', array(
				'text' => elgg_echo('linkedin:certification:url'),
				'href' => $entity->address,
				'target' => 'blank'
	));
}

echo elgg_view('object/elements/summary', array(
	'entity' => $entity,
	'title' => $title,
	'subtitle' => implode('<br />', $subtitle),
	'content' => $description
));
