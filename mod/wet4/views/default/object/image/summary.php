<?php
/**
 * Summary of an image for lists/galleries
 *
 * @uses $vars['entity'] TidypicsImage
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$image = elgg_extract('entity', $vars);

$img = elgg_view_entity_icon($image, 'medium');

$img_title = $image->getTitle();
if (strlen($img_title) > 20) {
        $img_title = substr($img_title, 0, 17).'...';
}

$header = elgg_view('output/url', array(
	'text' => $img_title,
	'href' => $image->getURL(),
	'is_trusted' => true,
	'class' => 'tidypics-heading',
));

$body = elgg_view('output/url', array(
	'text' => $img,
	'href' => $image->getURL(),
	'encode_text' => false,
	'is_trusted' => true,
    'class' => 'test ',
));

echo elgg_view_module('tidypics-image-wet4', $header, $body);
