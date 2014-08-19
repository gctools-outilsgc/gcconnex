<?php
/**
 * List all the albums of someone's friends
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

gatekeeper();

$owner = elgg_get_page_owner_entity();

elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:albums'), 'photos/all');
elgg_push_breadcrumb($owner->name, "photos/friends/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

$title = elgg_echo('album:friends');

$limit = (int)get_input('limit', 16);

set_input('list_type', 'gallery');
$content = list_user_friends_objects($owner->guid, 'album', $limit, false);
if (!$content) {
	$content = elgg_echo('tidypics:none');
}

$logged_in_guid = elgg_get_logged_in_user_guid();
elgg_register_menu_item('title', array('name' => 'addphotos',
                                       'href' => "ajax/view/photos/selectalbum/?owner_guid=" . $logged_in_guid,
                                       'text' => elgg_echo("photos:addphotos"),
                                       'link_class' => 'elgg-button elgg-button-action elgg-lightbox'));

elgg_register_title_button();

$body = elgg_view_layout('content', array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
        'sidebar' => elgg_view('photos/sidebar', array('page' => 'friends')),
));

echo elgg_view_page($title, $body);
