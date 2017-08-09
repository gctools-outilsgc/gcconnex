<?php
/**
 * Edit view of the related groups widget
 */

$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 4;
}

echo '<div>';
echo elgg_echo('widget:numbertodisplay');
echo elgg_view('input/text', [
	'name' => 'params[num_display]',
	'value' => $num_display,
	'size' => '4',
	'maxlength' => '3',
]);
echo '</div>';
