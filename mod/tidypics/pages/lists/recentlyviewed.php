<?php

/**
 * Most recently viewed images - world view only
 *
 */

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:recentlyviewed'));

$offset = (int)get_input('offset', 0);
$limit = (int)get_input('limit', 16);

$options = array(
	'type' => 'object',
	'subtype' => 'image',
	'limit' => $limit,
	'offset' => $offset,
	'annotation_name' => 'tp_view',
	'order_by_annotation' => "n_table.time_created desc",
	'full_view' => false,
	'list_type' => 'gallery',
	'gallery_class' => 'tidypics-gallery'
);

$result = elgg_list_entities_from_annotations($options);

$title = elgg_echo('tidypics:recentlyviewed');

if (elgg_is_logged_in()) {
	$logged_in_guid = elgg_get_logged_in_user_guid();
	elgg_register_menu_item('title', array(
		'name' => 'addphotos',
		'href' => "ajax/view/photos/selectalbum/?owner_guid=" . $logged_in_guid,
		'text' => elgg_echo("photos:addphotos"),
		'link_class' => 'elgg-button elgg-button-action elgg-lightbox'
	));
}

// only show slideshow link if slideshow is enabled in plugin settings and there are images
if (elgg_get_plugin_setting('slideshow', 'tidypics') && !empty($result)) {
	elgg_require_js('tidypics/slideshow');
	$url = elgg_get_site_url() . "photos/recentlyviewed?limit=64&offset=$offset&view=rss";
	$url = elgg_format_url($url);
	elgg_register_menu_item('title', array(
		'name' => 'slideshow',
		'id' => 'slideshow',
		'data-slideshowurl' => $url,
		'href' => '#',
		'text' => "<img src=\"".elgg_get_site_url() ."mod/tidypics/graphics/slideshow.png\" alt=\"".elgg_echo('album:slideshow')."\">",
		'title' => elgg_echo('album:slideshow'),
		'link_class' => 'elgg-button elgg-button-action'
	));
}

if (!empty($result)) {
	$area2 = $result;
} else {
	$area2 = elgg_echo('tidypics:recentlyviewed:nosuccess');
}
$body = elgg_view_layout('content', array(
	'filter_override' => '',
	'content' => $area2,
	'title' => $title,
	'sidebar' => elgg_view('photos/sidebar_im', array('page' => 'all')),
));

// Draw it
echo elgg_view_page(elgg_echo('tidypics:recentlyviewed'), $body);
