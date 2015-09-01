<?php

$entity = elgg_extract('entity', $vars, false);
$full = elgg_extract('full_view', $vars, false);

if (!elgg_instanceof($entity, 'object', 'hjfile')) {
	return true;
}

if ($full) {
	echo elgg_view('object/hjfile/list', $vars);
	return true;
}

$title = elgg_view('object/hjfile/elements/title', $vars);

$info .= elgg_view('object/hjfile/elements/author', $vars);
$info .= elgg_view('object/hjfile/elements/time_created', $vars);

$details = elgg_view('object/hjfile/elements/description', $vars);
$details .= elgg_view('object/hjfile/elements/tags', $vars);

$menu = elgg_view('object/hjfile/elements/menu', $vars);

$vars['size'] = 'large';
$icon = elgg_view('object/hjfile/elements/icon', $vars);

$output = elgg_view_module('aside', $title, $icon . $info, array(
	'class' => 'elgg-module-file'
		));

if (elgg_in_context('gallery-view')) {
	if (get_input('details') == 'summary') {

		$vars['size'] = 'master';
		$info = elgg_view('object/hjfile/elements/icon', $vars) . $info;

		$title = elgg_view_image_block('', $title, array(
			'image_alt' => $menu
				));
		$output = elgg_view_module('aside', $title, $info . $details, array('class' => 'elgg-module-hjfile-summary'));
	} else if (get_input('details') == 'full') {

		$vars['size'] = 'master';
		$info = elgg_view('object/hjfile/elements/icon', $vars) . $info;

		$title = elgg_view_image_block('', $title, array(
			'image_alt' => $menu
				));

		$output = elgg_view_module('aside', $title, $info . $details, array('class' => 'elgg-module-hjfile-full'));
	}
}

echo $output;
