<?php
/**
 * River integration
 */

$plugin = $vars['plugin'];

echo '<div class="mbs">';
echo elgg_echo('tidypics:settings:album_river_view') . ': ';
echo elgg_view('input/select', array(
	'name' => 'params[album_river_view]',
	'options_values' => array(
		'cover' => elgg_echo('tidypics:option:cover'),
		'set' => elgg_echo('tidypics:option:set'),
		'none' => elgg_echo('tidypics:option:none')
	),
	'value' => $plugin->album_river_view,
));
echo '</div>';
echo '<div class="mbs">';
echo elgg_echo('tidypics:settings:img_river_view') . ': ';
echo elgg_view('input/select', array(
	'name' => 'params[img_river_view]',
	'options_values' => array(
		'all' => elgg_echo('tidypics:option:all'),
		'1' => elgg_echo('tidypics:option:single'),
		'batch' =>  elgg_echo('tidypics:option:batch'),
		'none' => elgg_echo('tidypics:option:none')
	),
	'value' => $plugin->img_river_view,
));
echo '</div>';
echo '<div class="mbs">';
echo elgg_echo('tidypics:settings:river_comments_thumbnails') . ': ';
echo elgg_view('input/select', array(
	'name' => 'params[river_comments_thumbnails]',
	'options_values' => array(
		'show' => elgg_echo('tidypics:option:river_comments_include_preview'),
		'none' => elgg_echo('tidypics:option:river_comments_no_preview')
	),
	'value' => $plugin->river_comments_thumbnails,
));
echo '</div>';
echo '<div>';
echo elgg_echo('tidypics:settings:river_thumbnails_size') . ': ';
echo elgg_view('input/select', array(
	'name' => 'params[river_thumbnails_size]',
	'options_values' => array(
		'small' => elgg_echo('tidypics:option:river_comments_thumbnails_small'),
		'tiny' => elgg_echo('tidypics:option:river_comments_thumbnails_tiny')
	),
	'value' => $plugin->river_thumbnails_size,
));
echo '</div>';
