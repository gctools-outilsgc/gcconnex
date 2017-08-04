<?php

$entity = elgg_extract('entity', $vars);
$size = elgg_extract('size', $vars);
$override = (bool) elgg_extract('override', $vars, false);

$allowed_sizes = ['tiny', 'small', 'medium'];
if (!in_array($size, $allowed_sizes)) {
	$size = 'small';
}

$icon = elgg_view('output/img', [
	'src' => $entity->getIconUrl($size),
	'alt' => $entity->title,
	'title' => $entity->title,
]);

if (!$override) {
	echo elgg_view('output/url', [
		'text' => $icon,
		'href' => $entity->getURL(),
		'class' => 'icon',
	]);
} else {
	echo $icon;
}
