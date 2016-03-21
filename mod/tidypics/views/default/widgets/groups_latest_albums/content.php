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

$prev_context = elgg_get_context();
elgg_set_context('groups');
$image_html = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'album',
	'container_guid' => elgg_get_page_owner_guid(),
	'limit' => $count,
	'full_view' => false,
	'pagination' => false,
));
elgg_set_context($prev_context);

if (elgg_is_logged_in()) {
	$container = get_entity(elgg_get_page_owner_guid());
	if ($container->isMember(elgg_get_logged_in_user_entity())) {
		$image_html .= elgg_view('output/url', array(
			'href' => "photos/add/" . elgg_get_page_owner_guid(),
			'text' => elgg_echo('photos:add'),
			'is_trusted' => true,
		));
	}
}

echo $image_html;
