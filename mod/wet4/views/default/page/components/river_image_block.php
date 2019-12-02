<?php
/**
 * Elgg image block pattern
 *
 * Common pattern where there is an image, icon, media object to the left
 * and a descriptive block of text to the right.
 * 
 * ---------------------------------------------------------------
 * |          |                                      |    alt    |
 * |  image   |               body                   |   image   |
 * |  block   |               block                  |   block   |
 * |          |                                      | (optional)|
 * ---------------------------------------------------------------
 *
 * @uses $vars['body']        HTML content of the body block
 * @uses $vars['image']       HTML content of the image block
 * @uses $vars['image_alt']   HTML content of the alternate image block
 * @uses $vars['class']       Optional additional class (or an array of classes) for media element
 * @uses $vars['id']          Optional id for the media element
 */

$body = elgg_extract('body', $vars, '');
unset($vars['body']);

$image = elgg_extract('image', $vars, '');
unset($vars['image']);

$alt_image = elgg_extract('image_alt', $vars, '');
unset($vars['image_alt']);

$class = 'elgg-river-image-block clearfix panel';

$body = elgg_format_element('div', [
	'class' => 'elgg-river-body',
], $body);

if ($image) {
	$image = elgg_format_element('div', [
		'class' => 'elgg-image',
	], $image);
}

if ($alt_image) {
	$alt_image = elgg_format_element('div', [
		'class' => 'elgg-image-alt',
	], $alt_image);
}

$holder = elgg_format_element('div', [
  'class' => 'card-body panel-body',
], $body);

$params = $vars;
$params['class'] = $class;

echo elgg_format_element('article', $params, $holder);
