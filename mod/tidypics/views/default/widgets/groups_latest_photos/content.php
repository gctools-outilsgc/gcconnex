<?php
/**
 * Tidypics Plugin
 *
 * Groups page Latest Photos widget for Widget Manager plugin
 *
 */

elgg_load_js('lightbox');
elgg_load_css('lightbox');

// get widget settings
$count = sanitise_int($vars["entity"]->tp_latest_photos_count, false);
if(empty($count)){
	$count = 12;
}

$container_guid =  elgg_get_page_owner_guid();
$db_prefix = elgg_get_config('dbprefix');

$prev_context = elgg_get_context();
elgg_set_context('groups');
$image_html = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'image',
	'joins' => array("join {$db_prefix}entities u on e.container_guid = u.guid"),
	'wheres' => array("u.container_guid = {$container_guid}"),
	'order_by' => "e.time_created desc",
	'limit' => $count,
	'full_view' => false,
	'list_type_toggle' => false,
	'list_type' => 'gallery',
	'pagination' => false,
	'gallery_class' => 'tidypics-gallery-widget',
));
elgg_set_context($prev_context);

if (elgg_is_logged_in()) {
	$group = get_entity($container_guid);
	if ($group->isMember(elgg_get_logged_in_user_entity())) {
		$image_html .= elgg_view('output/url', array(
			'href' => "ajax/view/photos/selectalbum/?owner_guid=" . $container_guid,
			'text' => elgg_echo("photos:addphotos"),
			'class' => 'elgg-lightbox',
			'link_class' => 'elgg-lightbox',
			'is_trusted' => true,
		));
	}
}

echo $image_html;
