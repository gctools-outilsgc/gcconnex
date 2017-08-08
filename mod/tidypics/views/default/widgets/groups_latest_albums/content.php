<?php
/**
 * Tidypics Plugin
 *
 * Groups page Latest Albums widget for Widget Manager plugin
 *
 */

// get widget settings
$count = sanitise_int($vars["entity"]->tp_latest_albums_count, false);
if(empty($count)){
	$count = 6;
}

$group = elgg_get_page_owner_entity();
$group_guid = $group->getGUID();

$prev_context = elgg_get_context();
elgg_set_context('groups');
$image_html = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'album',
	'container_guid' => $group_guid,
	'limit' => $count,
	'full_view' => false,
	'pagination' => false,
));
elgg_set_context($prev_context);

if ($group->canWriteToContainer(0, 'object', 'album')) {
	$image_html .= elgg_view('output/url', array(
		'href' => "photos/add/" . $group_guid,
		'text' => elgg_echo('photos:add'),
		'is_trusted' => true,
	));
}

echo $image_html;
