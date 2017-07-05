<?php
/**
 * Edit the image information for a batch of images
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

elgg_gatekeeper();
$lang = get_current_language();
$guid = (int) get_input('guid');

if (!$batch = get_entity($guid)) {
	// @todo either deleted or do not have access
	forward('photos/all');
}

if (!$batch->canEdit()) {
	// @todo cannot change it
	forward('photos/all');
}

$album = $batch->getContainerEntity();

elgg_set_page_owner_guid($batch->getContainerEntity()->getContainerGUID());
$owner = elgg_get_page_owner_entity();

$title = elgg_echo('tidypics:editprops');

elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:albums'), 'photos/all');
elgg_push_breadcrumb(gc_explode_translation($owner->name,$lang), "photos/owner/$owner->username");
elgg_push_breadcrumb(gc_explode_translation($album->title,$lang), $album->getURL());
elgg_push_breadcrumb($title);

$content = elgg_view_form('photos/batch/edit', array(), array('batch' => $batch));

$body = elgg_view_layout('content', array(
	'filter' => false,
	'content' => $content,
	'title' => elgg_echo('tidypics:editprops'),
	'sidebar' => elgg_view('photos/sidebar_al', array('page' => 'upload')),
));

echo elgg_view_page($title, $body);
