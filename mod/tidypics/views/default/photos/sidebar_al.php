<?php
/**
 * Sidebar view
 */

$base = elgg_get_site_url() . 'photos/';

elgg_register_menu_item('page', array(
	'name' => 'A10_tiypics_siteimages',
	'text' => elgg_echo('tidypics:siteimagesall'),
	'href' => $base . 'siteimagesall',
	'section' => 'A'
));
elgg_register_menu_item('page', array(
	'name' => 'A20_tiypics_albums',
	'text' => elgg_echo('album:all'),
	'href' => $base . 'all',
	'section' => 'A'
));

$page = elgg_extract('page', $vars);
switch ($page) {
	case 'upload':
		if (elgg_get_plugin_setting('quota', 'tidypics')) {
			echo elgg_view('photos/sidebar/quota', $vars);
		}
		break;
	case 'all':
		echo elgg_view('photos/sidebar/extended_menu', $vars);
		echo elgg_view('page/elements/comments_block', array(
			'subtypes' => 'album',
		));
		echo elgg_view('page/elements/tagcloud_block', array(
			'subtypes' => 'album',
		));
		break;
	case 'owner':
		echo elgg_view('photos/sidebar/extended_menu', $vars);
		echo elgg_view('page/elements/comments_block', array(
			'subtypes' => 'album',
			'owner_guid' => elgg_get_page_owner_guid(),
		));
		echo elgg_view('page/elements/tagcloud_block', array(
			'subtypes' => 'album',
			'owner_guid' => elgg_get_page_owner_guid(),
		));
		break;
	case 'friends':
		echo elgg_view('photos/sidebar/extended_menu', $vars);
		break;
}
