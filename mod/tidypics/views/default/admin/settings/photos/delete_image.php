<?php
/**
 * Deletion of a Tidypics image by GUID provided (if image entry does not get properly displayed on site and delete button can not be reached)
 *
 * iionly@gmx.de
 */

elgg_require_js('tidypics/broken_images');


echo elgg_view_form('photos/admin/delete_image');


// broken images
$title = elgg_echo('tidypics:utilities:broken_images');
$body = elgg_autop(elgg_echo('tidypics:utilities:broken_images:blurb'));
$submit = elgg_view('input/submit', array(
	'value' => elgg_echo('search'),
	'id' => 'elgg-tidypics-broken-images'
));

$body .=<<<HTML
	<p>
		$submit
	</p>
	<div id="elgg-tidypics-broken-images-results"></div>
HTML;

echo elgg_view_module('inline', $title, $body);
