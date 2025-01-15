<?php
/**
 * Show all the albums that belong to a user or group
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

elgg_group_gatekeeper();
$lang = get_current_language();
$owner = elgg_get_page_owner_entity();

if (!$owner) {
	forward(REFERER);
}
// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:albums'), 'photos/all');

	$title = elgg_echo('album:user', array(gc_explode_translation($owner->name,$lang)));
	elgg_push_breadcrumb(gc_explode_translation($owner->name,$lang));




$offset = (int)get_input('offset', 0);
$limit = (int)get_input('limit', 16);

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'album',
	'container_guid' => $owner->getGUID(),
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

if (elgg_is_logged_in()) {
	if ($owner instanceof ElggGroup) {
		if ($owner->isMember(elgg_get_logged_in_user_entity())) {
			elgg_register_menu_item('title', array(
				'name' => 'addphotos',
				'href' => "ajax/view/photos/selectalbum/?owner_guid=" . $owner->getGUID(),
				'text' => elgg_echo("photos:addphotos"),
				'link_class' => 'elgg-button elgg-button-action elgg-lightbox btn btn-default btn-md'
			));
		}
	} else {
		elgg_register_menu_item('title', array(
			'name' => 'addphotos',
			'href' => "ajax/view/photos/selectalbum/?owner_guid=" . elgg_get_logged_in_user_guid(),
			'text' => elgg_echo("photos:addphotos"),
			'link_class' => 'elgg-button elgg-button-action elgg-lightbox btn btn-default btn-md'
		));
	}
}


$params = array(
	'filter_context' => 'mine',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('photos/sidebar_al', array('page' => 'owner')),
);

// don't show filter if out of filter context
if ($owner instanceof ElggGroup) {
	$params['filter'] = false;
}

if ($owner->getGUID() != elgg_get_logged_in_user_guid()) {
	$params['filter_context'] = '';
}

elgg_unregister_menu_item('title', 'addphotos');

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
