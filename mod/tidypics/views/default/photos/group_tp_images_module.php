<?php
/**
 * Group images module
 */

$group = $vars['entity'];
$group_guid = $group->getGUID();

if ($group->tp_images_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "photos/siteimagesgroup/$group_guid",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

$new_link = '';
if (tidypics_can_add_new_photos(null, $group)) {
	$url = elgg_get_site_url() . "ajax/view/photos/selectalbum/?owner_guid=" . $group_guid;
	$url = elgg_format_url($url);
	$new_link = elgg_view('output/url', array(
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

$db_prefix = elgg_get_config('dbprefix');
elgg_push_context('groups');
$options = array(
	'type' => 'object',
	'subtype' => 'image',
	'joins' => array("join {$db_prefix}entities u on e.container_guid = u.guid"),
	'wheres' => array("u.container_guid = {$group_guid}"),
	'order_by' => "e.time_created desc",
	'limit' => 6,
	'full_view' => false,
	'list_type_toggle' => false,
	'list_type' => 'gallery',
	'pagination' => false,
	'gallery_class' => 'tidypics-gallery-widget'
);
$content = elgg_list_entities($options);
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('tidypics:none') . '</p>';
}

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('tidypics:mostrecent'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
