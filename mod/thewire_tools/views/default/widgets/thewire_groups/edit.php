<?php

$widget = elgg_extract('entity', $vars);

$count = (int) $widget->wire_count;
if ($count < 1) {
	$count = 5;
}

$setting = elgg_echo('thewire:num');
$setting .= elgg_view('input/select', [
	'name' => 'params[wire_count]',
	'options' => range(1, 10),
	'value' => $count,
	'class' => 'mlm',
]);
echo elgg_format_element('div', [], $setting);

$setting = elgg_echo('widgets:thewire:filter');
$setting .= elgg_view('input/text', [
	'name' => 'params[filter]',
	'value' => $widget->filter,
	'class' => 'mlm',
]);
echo elgg_format_element('div', [], $setting);