<?php
/**
 * Upload images
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

elgg_gatekeeper();

$album_guid = (int) get_input('guid');
if (!$album_guid) {
	// @todo
	forward();
}

$album = get_entity($album_guid);
if (!$album) {
	// @todo
	// throw warning and forward to previous page
	forward(REFERER);
}

if (!$album->getContainerEntity()->canWriteToContainer()) {
	// @todo have to be able to edit album to upload photos
	forward(REFERER);
}

// set page owner based on container (user or group)
elgg_set_page_owner_guid($album->getContainerGUID());
$owner = elgg_get_page_owner_entity();
elgg_group_gatekeeper();

$title = elgg_echo('album:addpix');

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:albums'), 'photos/all');
elgg_push_breadcrumb($owner->name, "photos/owner/$owner->username");
elgg_push_breadcrumb($album->getTitle(), $album->getURL());
elgg_push_breadcrumb(elgg_echo('album:addpix'));

$uploader = get_input('uploader');
if ($uploader == 'basic') {
	$content = elgg_view('forms/photos/basic_upload', array('entity' => $album));
} else {
	elgg_load_js('jquery.plupload-tp');
	elgg_load_js('jquery.plupload.ui-tp');
	elgg_load_js('jquery.plupload.ui.lang-tp');
	elgg_load_css('jquery.plupload.jqueryui-theme');
	elgg_load_css('jquery.plupload.ui');
	elgg_require_js('tidypics/uploading');
	$content = elgg_view('forms/photos/ajax_upload', array('entity' => $album));
}

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'sidebar' => elgg_view('photos/sidebar_im', array('page' => 'upload')),
));

echo elgg_view_page($title, $body);
