<?php
/**
 * Image album view
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

elgg_require_js('tidypics/tidypics');
elgg_load_js('lightbox');
elgg_load_css('lightbox');

$subject = $vars['item']->getSubjectEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$preview_size = elgg_get_plugin_setting('river_thumbnails_size', 'tidypics');
if(!$preview_size) {
	$preview_size = 'tiny';
}
$image = $vars['item']->getObjectEntity();
$attachments = elgg_view_entity_icon($image, $preview_size, array(
	'href' => $image->getIconURL('master'),
	'img_class' => 'tidypics-photo',
	'link_class' => 'tidypics-lightbox',
));

$image_link = elgg_view('output/url', array(
	'href' => $image->getURL(),
	'text' => $image->getTitle(),
	'is_trusted' => true,
));

$album_link = elgg_view('output/url', array(
	'href' => $image->getContainerEntity()->getURL(),
	'text' => $image->getContainerEntity()->getTitle(),
	'is_trusted' => true,
));

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'attachments' => $attachments,
	'summary' => elgg_echo('image:river:created', array($subject_link, $image_link, $album_link)),
));
