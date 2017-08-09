<?php
/**
 * settings for the featured group widget
 */
$widget = elgg_extract('entity', $vars);

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 5;
}

echo '<div>';
echo elgg_echo('widget:numbertodisplay');
echo elgg_view('input/select', [
	'name' => 'params[num_display]',
	'options' => range(1, 10),
	'value' => $num_display,
	'class' => 'mls',
]);
echo '</div>';

echo '<div>';
echo elgg_echo('widgets:index_groups:show_members');
echo '<br />';
echo elgg_view('input/select', [
	'name' => 'params[show_members]',
	'options_values' => $noyes_options,
	'value' => $widget->show_members,
]);
echo '</div>';

echo '<div>';
echo elgg_echo('widgets:featured_groups:edit:show_random_group');
echo elgg_view('input/select', [
	'name' => 'params[show_random]',
	'options_values' => $noyes_options,
	'value' => $widget->show_random,
	'class' => 'mls',
]);
echo '</div>';
