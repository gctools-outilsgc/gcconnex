<?php
/**
 * Group images module
 */

elgg_load_js('lightbox');
elgg_load_css('lightbox');

$group = $vars['entity'];

if ($group->tp_images_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "photos/siteimagesgroup/$group->guid",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

$new_link = '';
if (elgg_is_logged_in()) {
	if ($group->isMember(elgg_get_logged_in_user_entity())) {
		$new_link = elgg_view('output/url', array(
			'href' => "ajax/view/photos/selectalbum/?owner_guid=" .$group->guid,
			'text' => elgg_echo("photos:addphotos"),
			'class' => 'elgg-lightbox',
			'link_class' => 'elgg-lightbox',
			'is_trusted' => true,
		));
	}
}

$container_guid =  elgg_get_page_owner_guid();
$db_prefix = elgg_get_config('dbprefix');
elgg_push_context('groups');
$options = array(
	'type' => 'object',
	'subtype' => 'image',
	'joins' => array("join {$db_prefix}entities u on e.container_guid = u.guid"),
	'wheres' => array("u.container_guid = {$container_guid}"),
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
