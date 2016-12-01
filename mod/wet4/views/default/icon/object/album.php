<?php
/**
 * Image icon view
 *
 * @uses $vars['entity']     The entity the icon represents - uses getIconURL() method
 * @uses $vars['size']       tiny, small (default), large, master
 * @uses $vars['href']       Optional override for link
 * @uses $vars['img_class']  Optional CSS class added to img
 * @uses $vars['link_class'] Optional CSS class added to link
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 *
 * GC_MODIFICATION
 * Description: added responsize class / layout changes
 * Author: GCTools Team
 */

$album = $vars['entity'];

$cover_guid = $album->getCoverImageGuid();
if ($cover_guid) {
	$vars['title'] = $album->getTitle();
	$vars['href'] = $album->getURL();
	echo elgg_view_entity_icon(get_entity($cover_guid), $vars['size'], $vars);
} else {
	$url = "mod/tidypics/graphics/empty_album_{$vars['size']}.png";
	$url = elgg_normalize_url($url);
	$img = elgg_view('output/img', array(
		'src' => $url,
		'class' => 'center-block img-responsive',
		'title' => $album->getTitle(),
		'alt' => $album->getTitle(),
	));

	$params = array(
		'href' => $album->getURL(),
		'text' => $img,
		'is_trusted' => true,
	);
	if (isset($vars['link_class'])) {
		$params['class'] = $vars['link_class'];
	}
	echo elgg_view('output/url', $params);
}
