<?php

$plugin = elgg_extract('entity', $vars);

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

$display_options = [
	'username' => elgg_echo('thewire_tools:settings:mention_display:username'),
	'displayname' => elgg_echo('thewire_tools:settings:mention_display:displayname'),
];

// enable group support
$setting = elgg_echo('thewire_tools:settings:enable_group');
$setting .= elgg_view('input/select', [
	'name' => 'params[enable_group]',
	'value' => $plugin->enable_group,
	'options_values' => $noyes_options,
	'class' => 'mlm',
]);
echo elgg_format_element('div', [], $setting);

// extend widgets
$setting = elgg_echo('thewire_tools:settings:extend_widgets');
$setting .= elgg_view('input/select', [
	'name' => 'params[extend_widgets]',
	'value' => $plugin->extend_widgets,
	'options_values' => array_reverse($noyes_options, true),
	'class' => 'mlm',
]);
echo elgg_format_element('div', [], $setting);

// extend widgets
$setting = elgg_echo('thewire_tools:settings:extend_activity');
$setting .= elgg_view('input/select', [
	'name' => 'params[extend_activity]',
	'value' => $plugin->extend_activity,
	'options_values' => $noyes_options,
	'class' => 'mlm',
]);
echo elgg_format_element('div', [], $setting);

$setting = elgg_echo('thewire_tools:settings:mention_display');
$setting .= elgg_view('input/select', [
	'name' => 'params[mention_display]',
	'value' => $plugin->mention_display,
	'options_values' => $display_options,
	'class' => 'mlm',
]);
echo elgg_format_element('div', [], $setting);
