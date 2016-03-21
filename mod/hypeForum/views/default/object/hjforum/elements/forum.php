<?php

$entity = elgg_extract('entity', $vars);

if ($vars['entity']->icontime) {
	$vars['size'] = 'tiny';
	$icon = elgg_view('framework/bootstrap/object/elements/icon', $vars);
}

if (elgg_in_context('groups') && !elgg_instanceof(elgg_get_page_owner_entity(), 'group')) {
	$breadcrumbs = elgg_view('framework/bootstrap/object/elements/breadcrumbs', $vars);
}

$title = elgg_view('framework/bootstrap/object/elements/title', $vars);
$description = elgg_view('framework/bootstrap/object/elements/briefdescription', $vars);

echo $breadcrumbs;
echo elgg_view_image_block($icon, $title . $description, array(
	'class' => 'hj-forum-details'
));
