<?php
/**
 * Primary settings for Elgg
 */

$plugin = $vars['plugin'];

$checkboxes = array('tagging', 'restrict_tagging', 'view_count', 'uploader', 'exif', 'download_link' , 'slideshow');
foreach ($checkboxes as $checkbox) {
	echo '<div class="mbs">';
	echo elgg_view('input/checkbox', array(
		'name' => "params[$checkbox]",
		'value' => true,
		'checked' => (bool)$plugin->$checkbox,
		'label' => elgg_echo("tidypics:settings:$checkbox"),
	));
	echo '</div>';
}

echo '<div class="mbs">';
echo elgg_echo('tidypics:settings:site_menu_link') . ': ';
echo elgg_view('input/select', array(
	'name' => 'params[site_menu_link]',
	'options_values' => tidypics_get_image_libraries(),
	'options_values' => array(
		'photos' => elgg_echo('tidypics:settings:site_menu_photos'),
		'albums' => elgg_echo('tidypics:settings:site_menu_albums'),
	),
	'value' => $plugin->site_menu_link,
));
echo '</div>';

// max image size
echo '<div class="mbs">';
echo elgg_echo('tidypics:settings:maxfilesize');
echo elgg_view('input/text', array(
	'name' => 'params[maxfilesize]',
	'value' => $plugin->maxfilesize,
));
echo '</div>';

// Watermark Text
echo '<div class="mbs">' . elgg_echo('tidypics:settings:watermark');
echo elgg_view("input/text", array(
	'name' => 'params[watermark_text]',
	'value' => $plugin->watermark_text,
));
echo '</div>';

// Quota Size
$quota = $plugin->quota;
if (!$quota) {
	$quota = 0;
}
echo '<div class="mbs">' . elgg_echo('tidypics:settings:quota');
echo elgg_view('input/text', array(
	'name' => 'params[quota]',
	'value' => $quota,
));
echo '</div>';

// Max number of image allowed in one upload
$max_uploads = (int)$plugin->max_uploads;
if (!$max_uploads) {
	$max_uploads = 10;
}
echo '<div>' . elgg_echo('tidypics:settings:max_uploads');
echo elgg_view('input/text', array(
	'name' => 'params[max_uploads]',
	'value' => $max_uploads,
));
echo '<div class="elgg-subtext mbn">';
echo elgg_echo('tidypics:settings:max_uploads_explanation');
echo '</div></div>';
