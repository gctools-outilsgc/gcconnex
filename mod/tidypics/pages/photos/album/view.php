<?php
/**
 * This displays the photos that belong to an album
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

// get the album entity
$album_guid = (int) get_input('guid');
$album = get_entity($album_guid);
if (!$album) {
	register_error(elgg_echo('noaccess'));
	$_SESSION['last_forward_from'] = current_page_url();
	forward('');
}
$container = $album->getContainerEntity();
if (!$container) {
	register_error(elgg_echo('noaccess'));
	$_SESSION['last_forward_from'] = current_page_url();
	forward('');
}

elgg_set_page_owner_guid($album->getContainerGUID());
$owner = elgg_get_page_owner_entity();
elgg_group_gatekeeper();

$title = elgg_echo($album->getTitle());

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:albums'), 'photos/all');
if (elgg_instanceof($owner, 'group')) {
	elgg_push_breadcrumb($owner->name, "photos/group/$owner->guid/all");
} else {
	elgg_push_breadcrumb($owner->name, "photos/owner/$owner->username");
}
elgg_push_breadcrumb($album->getTitle());

$content = elgg_view_entity($album, array('full_view' => true));

if (elgg_is_logged_in()) {
	if ($owner instanceof ElggGroup) {
		if ($owner->isMember(elgg_get_logged_in_user_entity())) {
			elgg_register_menu_item('title2', array(
				'name' => 'addphotos',
				'href' => "ajax/view/photos/selectalbum/?owner_guid=" . $owner->getGUID(),
				'text' => elgg_echo("photos:addphotos"),
				'link_class' => 'elgg-button elgg-button-action elgg-lightbox'
			));
		}
	} else {
		elgg_register_menu_item('title2', array(
			'name' => 'addphotos',
			'href' => "ajax/view/photos/selectalbum/?owner_guid=" . elgg_get_logged_in_user_guid(),
			'text' => elgg_echo("photos:addphotos"),
			'link_class' => 'elgg-button elgg-button-action elgg-lightbox'
		));
	}
}

if ($album->getContainerEntity()->canWriteToContainer()) {
	elgg_register_menu_item('title', array(
			'name' => 'upload',
			'href' => 'photos/upload/' . $album->getGUID(),
			'text' => elgg_echo('images:upload'),
			'link_class' => 'elgg-button elgg-button-action',
	));
}

// only show sort button if there are images
if ($album->canEdit() && $album->getSize() > 0) {
	elgg_register_menu_item('title2', array(
		'name' => 'sort',
		'href' => "photos/sort/" . $album->getGUID(),
		'text' => elgg_echo('album:sort'),
		'link_class' => 'elgg-button elgg-button-action',
		'priority' => 200,
	));
}

// only show slideshow link if slideshow is enabled in plugin settings and there are images
if (elgg_get_plugin_setting('slideshow', 'tidypics') && $album->getSize() > 0) {
	elgg_require_js('tidypics/slideshow');
	$offset = (int)get_input('offset', 0);
	$url = $album->getURL() . "?limit=64&offset=$offset&view=rss";
	$url = elgg_format_url($url);
	elgg_register_menu_item('title', array(
		'name' => 'slideshow',
		'id' => 'slideshow',
		'data-slideshowurl' => $url,
		'href' => '#',
		'text' => "<img src=\"".elgg_get_site_url() ."mod/tidypics/graphics/slideshow.png\" alt=\"".elgg_echo('album:slideshow')."\">",
		'title' => elgg_echo('album:slideshow'),
		'link_class' => 'elgg-button elgg-button-action',
		'priority' => 300
	));
}

$body = elgg_view_layout('content', array(
	'filter' => false,
	'content' => $content,
	'title' => $album->getTitle(),
	'sidebar' => elgg_view('photos/sidebar_al', array('page' => 'album')),
));

echo elgg_view_page($title, $body);
