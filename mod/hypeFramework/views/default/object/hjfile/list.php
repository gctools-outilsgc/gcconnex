<?php

$entity = elgg_extract('entity', $vars, false);
$full = elgg_extract('full_view', $vars, false);

if (!elgg_instanceof($entity, 'object', 'hjfile')) {
	return true;
}

$title = elgg_view('object/hjfile/elements/title', $vars);

$details .= elgg_view('object/hjfile/elements/tags', $vars);

if ($full) {

	if ($entity->simpletype == 'image') {
		$vars['size'] = 'master';
		$image = elgg_view('object/hjfile/elements/icon', $vars);
	}

	$description = elgg_view('object/hjfile/elements/description', $vars);

	$comments = elgg_view('object/hjfile/elements/comments', $vars);
	echo elgg_view_module('main', '', $description . $image . $details, array(
		'footer' => $comments
	));
} else {
	$vars['size'] = 'medium';
	$cover = elgg_view('object/hjfile/elements/icon', $vars);
	$briefdescription = elgg_view('object/hjfile/elements/description', $vars);
	echo elgg_view_image_block($cover, $title . $briefdescription . $details);
}