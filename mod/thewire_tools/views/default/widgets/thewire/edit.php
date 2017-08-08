<?php

$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 4;
}

$owner_options = [
	'mine' => elgg_echo('mine'),
	'friends' => elgg_echo('friends'),
	'all' => elgg_echo('all'),
];

$setting = elgg_echo('thewire:num');
$setting .= elgg_view('input/select', [
	'name' => 'params[num_display]',
	'options' => range(1, 10),
	'value' => $num_display,
	'class' => 'mlm',
]);
echo elgg_format_element('div', [], $setting);

$setting = elgg_echo('widgets:thewire:owner');
$setting .= elgg_view('input/select', [
	'name' => 'params[owner]',
	'options_values' => $owner_options,
	'value' => $widget->owner,
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