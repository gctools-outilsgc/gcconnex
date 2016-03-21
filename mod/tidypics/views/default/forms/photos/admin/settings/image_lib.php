<?php
/**
 * Image library settings
 */

$plugin = $vars['plugin'];

echo '<div class="mbs">';
echo elgg_echo('tidypics:settings:image_lib') . ': ';
echo elgg_view('input/select', array(
	'name' => 'params[image_lib]',
	'options_values' => tidypics_get_image_libraries(),
	'value' => $plugin->image_lib,
));
echo '</div>';

echo '<div class="mbs">';
echo elgg_echo('tidypics:settings:im_path') . ' ';
echo elgg_view("input/text", array('name' => 'params[im_path]', 'value' => $plugin->im_path));
echo '</div>';

echo '<div>' . elgg_echo('tidypics:settings:thumbnail_optimization') . ': ';
echo elgg_view('input/select', array(
	'name' => 'params[thumbnail_optimization]',
	'options_values' => array(
		'none' => elgg_echo('tidypics:settings:optimization:none'),
		'simple' => elgg_echo('tidypics:settings:optimization:simple'),
		'complex' => elgg_echo('tidypics:settings:optimization:complex'),
	),
	'value' => $plugin->thumbnail_optimization,
));
echo '<div class="elgg-subtext mbn">';
echo elgg_echo('tidypics:settings:thumbnail_optimization_explanation');
echo '</div></div>';
