<?php
/**
 * Batch river view; showing only the thumbnail of the first image of the badge
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 *
 */

elgg_require_js('tidypics/tidypics');
elgg_load_js('lightbox');
elgg_load_css('lightbox');

$batch = $vars['item']->getObjectEntity();

// Count images in batch
$images_count = elgg_get_entities_from_relationship(array(
	'relationship' => 'belongs_to_batch',
	'relationship_guid' => $batch->getGUID(),
	'inverse_relationship' => true,
	'type' => 'object',
	'subtype' => 'image',
	'offset' => 0,
	'count' => true
));

// Get first image related to this batch
$images = elgg_get_entities_from_relationship(array(
	'relationship' => 'belongs_to_batch',
	'relationship_guid' => $batch->getGUID(),
	'inverse_relationship' => true,
	'type' => 'object',
	'subtype' => 'image',
	'offset' => 0,
	'limit' => 1,
));

$album = $batch->getContainerEntity();
if (!$album) {
	// something went quite wrong - this batch has no associated album
	return true;
}
$album_link = elgg_view('output/url', array(
	'href' => $album->getURL(),
	'text' => $album->getTitle(),
	'is_trusted' => true,
));

$subject = $vars['item']->getSubjectEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$attachments = '';
if ($images) {
	$preview_size = elgg_get_plugin_setting('river_thumbnails_size', 'tidypics');
	if(!$preview_size) {
		$preview_size = 'tiny';
	}
	$attachments = elgg_view_entity_icon($images[0], $preview_size, array(
		'href' => $images[0]->getIconURL('master'),
		'img_class' => 'tidypics-photo',
		'link_class' => 'tidypics-lightbox',
	));

	$image_link = elgg_view('output/url', array(
		'href' => $images[0]->getURL(),
		'text' => $images[0]->getTitle(),
		'is_trusted' => true,
	));
}

if ($images_count > 1) {
	// View the comments of the album
	$vars['item']->object_guid = $album->guid;
	$responses = elgg_view('river/elements/responses', $vars);
	if ($responses) {
		$responses = "<div class=\"elgg-river-responses\">$responses</div>";
	}
	echo elgg_view('river/elements/layout', array(
			'item' => $vars['item'],
			'attachments' => $attachments,
			'summary' => elgg_echo('image:river:created_single_entry', array($subject_link, $image_link, $images_count-1, $album_link)),
		));
} else {
	// View the comments of the image
	$vars['item']->object_guid = $images[0]->guid;
	$responses = elgg_view('river/elements/responses', $vars);
	if ($responses) {
		$responses = "<div class=\"elgg-river-responses\">$responses</div>";
	}
	echo elgg_view('river/elements/layout', array(
			'item' => $vars['item'],
			'attachments' => $attachments,
			'summary' => elgg_echo('image:river:created', array($subject_link, $image_link, $album_link)),
		));
}