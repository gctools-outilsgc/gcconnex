<?php

$widget = elgg_extract('entity', $vars);

$count = (int) $widget->wire_count;
if ($count < 1) {
	$count = 8;
}

$setting = elgg_echo('thewire:num');
$setting .= elgg_view('input/text', [
	'name' => 'params[wire_count]',
	'value' => $count,
	'size' => 4,
	'maxlength' => 4,
]);
echo elgg_format_element('div', [], $setting);

$setting = elgg_echo('widgets:thewire:filter');
$setting .= elgg_view('input/text', [
	'name' => 'params[filter]',
	'value' => $widget->filter,
	'class' => 'mlm',
]);
echo elgg_format_element('div', [], $setting);
