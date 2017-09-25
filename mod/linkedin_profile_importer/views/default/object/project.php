<?php

$entity = elgg_extract('entity', $vars);

$title = $entity->title;

$description .= elgg_view('output/longtext', array(
	'value' => $entity->description
		));

if ($entity->address) {
	$description .= elgg_view_icon('bookmark') . elgg_view('output/url', array(
				'text' => elgg_echo('linkedin:project:url'),
				'href' => $entity->address,
				'target' => 'blank'
	));
}

echo elgg_view('object/elements/summary', array(
	'entity' => $entity,
	'title' => $title,
	'content' => $description
));
