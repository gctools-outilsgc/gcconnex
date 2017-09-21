<?php

$entity = elgg_extract('entity', $vars);

$title = $entity->title;

if ($entity->date) {
	$date = date("j F Y", $entity->date);
	$subtitle[] = elgg_echo('linkedin:publication:date', array($date));
}
if ($entity->publisher) {
	$subtitle[] = elgg_echo('linkedin:publication:publisher', array($entity->publisher));
}
if ($entity->authors) {
	$subtitle[] = elgg_echo('linkedin:publication:authors', array(implode(', ', $entity->authors)));
}

$description = elgg_view('output/longtext', array(
	'value' => $entity->description
		));

if ($entity->address) {
	$description .= elgg_view_icon('bookmark') . elgg_view('output/url', array(
				'text' => elgg_echo('linkedin:publication:url'),
				'href' => $entity->address,
				'target' => 'blank'
	));
}


echo elgg_view('object/elements/summary', array(
	'entity' => $entity,
	'title' => $title,
	'subtitle' => implode('<br />', $subtitle),
	'content' => $description,
));
