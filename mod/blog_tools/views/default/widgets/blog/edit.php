<?php

$widget = elgg_extract('entity', $vars);

$num = (int) $widget->num_display;
if ($num < 1) {
	$num = 4;
}

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

echo '<div>';
echo elgg_echo('blog:numbertodisplay');
echo elgg_view('input/select', [
	'options' => range(1, 10),
	'value' => $num,
	'name' => 'params[num_display]',
	'class' => 'mls',
]);
echo '</div>';

echo '<div>';
echo elgg_echo('blog_tools:widget:featured');
echo elgg_view('input/select', [
	'options_values' => $noyes_options,
	'value' => $widget->show_featured,
	'name' => 'params[show_featured]',
]);
echo '</div>';
