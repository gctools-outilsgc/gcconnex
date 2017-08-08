<?php
/**
 * Tidypics Plugin
 *
 * Groups page Latest Photos widget for Widget Manager plugin
 *
 */

// get widget settings
$count = sanitise_int($vars["entity"]->tp_latest_photos_count, false);
if(empty($count)){
	$count = 12;
}

$group = elgg_get_page_owner_entity();
$group_guid =  $group->getGUID();

$db_prefix = elgg_get_config('dbprefix');

$prev_context = elgg_get_context();
elgg_set_context('groups');
$image_html = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'image',
	'joins' => array("join {$db_prefix}entities u on e.container_guid = u.guid"),
	'wheres' => array("u.container_guid = {$group_guid}"),
	'order_by' => "e.time_created desc",
	'limit' => $count,
	'full_view' => false,
	'list_type_toggle' => false,
	'list_type' => 'gallery',
	'pagination' => false,
	'gallery_class' => 'tidypics-gallery-widget',
));
elgg_set_context($prev_context);

if (tidypics_can_add_new_photos(null, $group)) {
	$url = elgg_get_site_url() . "ajax/view/photos/selectalbum/?owner_guid=" . $group_guid;
	$url = elgg_format_url($url);
	$image_html = elgg_view('output/url', array(
		'href' => 'javascript:',
		'text' => elgg_echo("photos:addphotos"),
		'data-colorbox-opts' => json_encode([
			'href' => $url,
		]),
		'class' => 'elgg-lightbox',
		'link_class' => 'elgg-lightbox',
		'is_trusted' => true,
	));
}

echo $image_html;
