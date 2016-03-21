<?php

$entity = elgg_extract('entity', $vars);

if (!elgg_instanceof($entity, 'object', 'hjfile')) {
	return true;
}

$album = $entity->getContainerEntity();

if (!$album) {
	return true;
}

$title = elgg_view('object/hjalbum/elements/title', array(
	'entity' => $album
));
$body = elgg_view('object/hjalbum/elements/images', array(
	'entity' => $album
));

echo elgg_view_module('aside', $title, $body);