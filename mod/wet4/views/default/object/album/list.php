<?php
/**
 * Display an album as an item in a list
 *
 * @uses $vars['entity'] TidypicsAlbum
 *
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 * @author Cash Costello
 *
 * GC_MODIFICATION
 * Description: Language translation changes
 * Author: GCTools Team
 */

$album = elgg_extract('entity', $vars);
$owner = $album->getOwnerEntity();
$lang = get_current_language();

$owner_link = elgg_view('output/url', array(
	'href' => "photos/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($album->time_created);
$categories = elgg_view('output/categories', $vars);

$subtitle = "$author_text $date $categories";

$title_album = gc_explode_translation($album->title, $lang);

$title = elgg_view('output/url', array(
	'text' => $title_album,
	'href' => $album->getURL(),
));

$params = array(
	'entity' => $album,
	'title' => $title,
	'metadata' => null,
	'subtitle' => $subtitle,
	'tags' => elgg_view('output/tags', array('tags' => $album->tags)),
);
$params = $params + $vars;
$summary = elgg_view('object/elements/summary', $params);

$icon = elgg_view_entity_icon($album, 'tiny');

echo $header = elgg_view_image_block($icon, $summary);
