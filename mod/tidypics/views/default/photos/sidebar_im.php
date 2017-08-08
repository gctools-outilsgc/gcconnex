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
			'subtypes' => 'image',
		));
		echo elgg_view('page/elements/tagcloud_block', array(
			'subtypes' => 'image',
		));
		break;
	case 'owner':
		echo elgg_view('photos/sidebar/extended_menu', $vars);
		echo elgg_view('page/elements/comments_block', array(
			'subtypes' => 'image',
			'owner_guid' => elgg_get_page_owner_guid(),
		));
		echo elgg_view('page/elements/tagcloud_block', array(
			'subtypes' => 'image',
			'owner_guid' => elgg_get_page_owner_guid(),
		));
		break;
	case 'friends':
		echo elgg_view('photos/sidebar/extended_menu', $vars);
		break;
	case 'tp_view':
		$image = elgg_extract('image', $vars);
		if ($image) {
			if (elgg_get_plugin_setting('exif', 'tidypics')) {
				echo elgg_view('photos/sidebar/exif', $vars);
			}

			// list of tagged members in an image (code from Tagged people plugin by Kevin Jardine)
			if (elgg_get_plugin_setting('tagging', 'tidypics')) {
				$body = elgg_list_entities_from_relationship(array(
					'relationship' => 'phototag',
					'relationship_guid' => $image->guid,
					'inverse_relationship' => true,
					'type' => 'user',
					'limit' => 15,
					'list_type' => 'gallery',
					'gallery_class' => 'elgg-gallery-users',
					'pagination' => false
				));
				if ($body) {
					$title = elgg_echo('tidypics_tagged_members');
					echo elgg_view_module('aside', $title, $body);
				}
			}
		}
		break;
}
