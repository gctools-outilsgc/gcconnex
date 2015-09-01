<?php

if (elgg_in_context('table-view')) {
	$entity = elgg_extract('entity', $vars);
	$user = $entity->getOwnerEntity();
	$friendly_time = date("F j, Y - ga T", $entity->time_created);
	echo $friendly_time . '<br />';
	echo elgg_view('output/url', array(
		'text' => elgg_echo('byline', array($user->name)),
		'href' => $entity->getURL()
	));
} else {
	$body = elgg_view('object/hjforumtopic/elements/forum', $vars);
	$image_alt = elgg_view('object/hjforumtopic/elements/menu', $vars);

	echo elgg_view_image_block('', $body, array(
		'image_alt' => $image_alt
	));
}
