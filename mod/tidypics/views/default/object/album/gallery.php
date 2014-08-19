<?php
/**
 * Display an album in a gallery
 *
 * @uses $vars['entity'] TidypicsAlbum
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$album = elgg_extract('entity', $vars);

$album_cover = elgg_view_entity_icon($album, 'small');

$album_title = $album->getTitle();
if (strlen($album_title) > 20) {
        $album_title = substr($album_title, 0, 17).'...';
}

$header = elgg_view('output/url', array(
	'text' => $album_title,
	'href' => $album->getURL(),
	'is_trusted' => true,
	'class' => 'tidypics-heading',
));

$container = $album->getContainerEntity();
if ($container) {
        $footer = '<div class="elgg-subtext">' . elgg_echo('album:created_by') . elgg_view('output/url', array(
                'text' => $album->getContainerEntity()->name,
                'href' => $album->getContainerEntity()->getURL(),
                'is_trusted' => true,
        ));
        $footer .= '<br>' . elgg_echo('album:num', array($album->getSize())) . '</div>';
} else {
        $footer = '<div class="elgg-subtext">' . elgg_echo('album:created_by') . ' - ';
        $footer .= '<br>' . elgg_echo('album:num', array($album->getSize())) . '</div>';
}

$params = array(
	'footer' => $footer,
);
echo elgg_view_module('tidypics-album', $header, $album_cover, $params);
