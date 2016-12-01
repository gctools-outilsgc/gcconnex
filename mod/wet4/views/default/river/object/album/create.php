<?php
/**
 * Album river view
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 *
 * GC_MODIFICATION
 * Description: fixes for ajax windows on river view
 * Author: GCTools Team
 */

elgg_require_js('tidypics/tidypics');
elgg_load_js('lightbox');
elgg_load_css('lightbox');

$album = $vars['item']->getObjectEntity();

$album_river_view = elgg_get_plugin_setting('album_river_view', 'tidypics');
$preview_size = elgg_get_plugin_setting('river_thumbnails_size', 'tidypics');
if(!$preview_size) {
	$preview_size = 'tiny';
}

if ($album_river_view == "set") {
	$images = $album->getImages(7);
	if (count($images)) {
		$attachments = '<ul class="tidypics-river-list">';
		foreach($images as $image) {
			$attachments .= '<li class="tidypics-photo-item">';
			$attachments .= elgg_view_entity_icon($image, $preview_size, array(
				//'href' => $image->getIconURL('master'),
				'href' => 'ajax/view/ajax/photo?guid=' . $image->guid,
	            'img_class' => 'tidypics-photo',
	            'link_class' => 'elgg-lightbox',
			));
			$attachments .= '</li>';
		}
		$attachments .= '</ul>';
	}
} else {
	$image = $album->getCoverImage();
	if ($image) {
		$attachments = elgg_view_entity_icon($image, $preview_size, array(
			//'href' => $image->getIconURL('master'),
			'href' => 'ajax/view/ajax/photo?guid=' . $image->guid,
	            'img_class' => 'tidypics-photo',
	            'link_class' => 'elgg-lightbox',
		));
	}
}

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'attachments' => $attachments,
));
