<?php
/**
 * Photo navigation
 *
 * @uses $vars['entity']
 */

$photo = $vars['entity'];

$album = $photo->getContainerEntity();
$previous_photo = $album->getPreviousImage($photo->getGUID());
$next_photo = $album->getNextImage($photo->getGUID());
$size = $album->getSize();
$index = $album->getIndex($photo->getGUID());

echo '<ul class="elgg-menu elgg-menu-hz tidypics-album-nav">';
echo '<li>';
echo elgg_view('output/url', array(
	'text' => '<i class="fa fa-arrow-left fa-lg icon-unsel"></i><span class="wb-inv">Previous Photo</span>',
	'href' => $previous_photo->getURL(),
));
echo '</li>';

echo '<li>';
echo '<span>' . elgg_echo('image:index', array($index, $size)) . '</span>';
echo '</li>';

echo '<li>';
echo elgg_view('output/url', array(
	'text' => '<i class="fa fa-arrow-right fa-lg icon-unsel"></i><span class="wb-inv">Next Photo</span>',
	'href' => $next_photo->getURL(),
));
echo '</li>';
echo '</ul>';
