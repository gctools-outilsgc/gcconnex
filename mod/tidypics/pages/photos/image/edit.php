<?php
/**
 * Edit an image
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */
$lang = get_current_language();
$guid = (int) get_input('guid');

if (!$entity = get_entity($guid)) {
	// @todo either deleted or do not have access
	forward('photos/all');
}

if (!$entity->canEdit()) {
	// @todo cannot change it
	forward($entity->getContainerEntity()->getURL());
}

$album = $entity->getContainerEntity();
if (!$album) {

}

elgg_set_page_owner_guid($album->getContainerGUID());
$owner = elgg_get_page_owner_entity();

elgg_gatekeeper();
elgg_group_gatekeeper();

$title = elgg_echo('image:edit');

$group_title = gc_explode_translation($owner->title,$lang);

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
if (elgg_instanceof($owner, 'user')) {
	elgg_push_breadcrumb($group_title, "photos/owner/$owner->username");
} else {
	elgg_push_breadcrumb($group_title, "photos/group/$owner->guid/all");
}

elgg_push_breadcrumb(gc_explode_translation($album->title,$lang), $album->getURL());

elgg_push_breadcrumb(gc_explode_translation($entity->title,$lang), $entity->getURL());

elgg_push_breadcrumb($title);

$vars = tidypics_prepare_form_vars($entity);
$content = elgg_view_form('photos/image/save', array('method' => 'post'), $vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'sidebar' => elgg_view('photos/sidebar_im', array('page' => 'upload')),
));

echo elgg_view_page($title, $body);
