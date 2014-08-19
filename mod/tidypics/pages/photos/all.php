<?php
/**
 * View all albums on the site
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:albums'));

$offset = (int)get_input('offset', 0);
$limit = (int)get_input('limit', 16);

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'album',
	'limit' => $limit,
	'offset' => $offset,
	'full_view' => false,
	'list_type' => 'gallery',
	'list_type_toggle' => false,
	'gallery_class' => 'tidypics-gallery',
));
if (!$content) {
	$content = elgg_echo('tidypics:none');
}

$title = elgg_echo('album:all');

if (elgg_is_logged_in()) {
        $logged_in_guid = elgg_get_logged_in_user_guid();
        elgg_register_menu_item('title', array('name' => 'addphotos',
                                               'href' => "ajax/view/photos/selectalbum/?owner_guid=" . $logged_in_guid,
                                               'text' => elgg_echo("photos:addphotos"),
                                               'link_class' => 'elgg-button elgg-button-action elgg-lightbox'));
}

elgg_register_title_button('photos');

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('photos/sidebar', array('page' => 'all')),
));

echo elgg_view_page($title, $body);
