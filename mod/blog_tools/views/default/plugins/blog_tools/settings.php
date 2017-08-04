<?php
	
$plugin = elgg_extract('entity', $vars);

// define possible values
$align_options = [
	'none' => elgg_echo('blog_tools:settings:align:none'),
	'left' => elgg_echo('left'),
	'right' => elgg_echo('right'),
];

$size_options = [
	'tiny' => elgg_echo('blog_tools:settings:size:tiny'),
	'small' => elgg_echo('blog_tools:settings:size:small'),
	'medium' => elgg_echo('blog_tools:settings:size:medium'),
	'large' => elgg_echo('blog_tools:settings:size:large'),
	'master' => elgg_echo('blog_tools:settings:size:master'),
];

$strapline_options = [
	'default' => elgg_echo('blog_tools:settings:strapline:default'),
	'time' => elgg_echo('blog_tools:settings:strapline:time'),
];

$yesno_options = [
	'yes' => elgg_echo('option:yes'),
	'no' => elgg_echo('option:no'),
];

$noyes_options = array_reverse($yesno_options);

$show_full_owner_options = [
	'no' => elgg_echo('option:no'),
	'optional' => elgg_echo('blog_tools:settings:full:show_full_owner:optional'),
	'yes' => elgg_echo('option:yes'),
];

$show_full_related_options = [
	'no' => elgg_echo('option:no'),
	'full_view' => elgg_echo('blog_tools:settings:full:show_full_related:full_view'),
	'sidebar' => elgg_echo('blog_tools:settings:full:show_full_related:sidebar'),
];

// get settings
$listing_align = $plugin->listing_align;
$listing_size = $plugin->listing_size;
$full_align = $plugin->full_align;
$full_size = $plugin->full_size;

// make default settings
if (empty($listing_align)) {
	$listing_align = 'right';
}

if (empty($listing_size)) {
	$listing_size = 'small';
}

if (empty($full_align)) {
	$full_align = 'right';
}

if (empty($full_size)) {
	$full_size = 'large';
}

// icon settings
$settings_image = '<table>';

$settings_image .= '<tr>';
$settings_image .= elgg_format_element('td', [], elgg_echo('blog_tools:settings:listing:strapline'));
$settings_image .= elgg_format_element('td', [], elgg_view('input/select', [
	'name' => 'params[listing_strapline]',
	'options_values' => $strapline_options,
	'value' => $plugin->listing_strapline,
	'class' => 'mls',
]));
$settings_image .= '</tr>';

$settings_image .= '<tr>';
$settings_image .= elgg_format_element('td', [], elgg_echo('blog_tools:settings:listing:image_align'));
$settings_image .= elgg_format_element('td', [], elgg_view('input/select', [
	'name' => 'params[listing_align]',
	'options_values' => $align_options,
	'value' => $listing_align,
	'class' => 'mls',
]));
$settings_image .= '</tr>';

$settings_image .= '<tr>';
$settings_image .= elgg_format_element('td', [], elgg_echo('blog_tools:settings:listing:image_size'));
$settings_image .= elgg_format_element('td', [], elgg_view('input/select', [
	'name' => 'params[listing_size]',
	'options_values' => $size_options,
	'value' => $listing_size,
	'class' => 'mls',
]));
$settings_image .= '</tr>';

$settings_image .= '<tr>';
$settings_image .= elgg_format_element('td', [], elgg_echo('blog_tools:settings:full:image_align'));
$settings_image .= elgg_format_element('td', [], elgg_view('input/select', [
	'name' => 'params[full_align]',
	'options_values' => $align_options,
	'value' => $full_align,
	'class' => 'mls',
]));
$settings_image .= '</tr>';

$settings_image .= '<tr>';
$settings_image .= elgg_format_element('td', [], elgg_echo('blog_tools:settings:full:image_size'));
$settings_image .= elgg_format_element('td', [], elgg_view('input/select', [
	'name' => 'params[full_size]',
	'options_values' => $size_options,
	'value' => $full_size,
	'class' => 'mls',
]));
$settings_image .= '</tr>';

$settings_image .= '</table>';

echo elgg_view_module('inline', elgg_echo('blog_tools:settings:image'), $settings_image);

// full view options
$settings_full = '<table>';

$settings_full .= '<tr>';
$settings_full .= elgg_format_element('td', [], elgg_echo('blog_tools:settings:full:show_full_navigation'));
$settings_full .= elgg_format_element('td', [], elgg_view('input/select', [
	'name' => 'params[show_full_navigation]',
	'options_values' => $noyes_options,
	'value' => $plugin->show_full_navigation,
	'class' => 'mls',
]));
$settings_full .= '</tr>';

$settings_full .= '<tr>';
$settings_full .= elgg_format_element('td', [], elgg_echo('blog_tools:settings:full:show_full_owner'));
$settings_full .= elgg_format_element('td', [], elgg_view('input/select', [
	'name' => 'params[show_full_owner]',
	'options_values' => $show_full_owner_options,
	'value' => $plugin->show_full_owner,
	'class' => 'mls',
]));
$settings_full .= '</tr>';

$settings_full .= '<tr>';
$settings_full .= elgg_format_element('td', [], elgg_echo('blog_tools:settings:full:show_full_related'));
$settings_full .= elgg_format_element('td', [], elgg_view('input/select', [
	'name' => 'params[show_full_related]',
	'options_values' => $show_full_related_options,
	'value' => $plugin->show_full_related,
	'class' => 'mls',
]));
$settings_full .= '</tr>';

$settings_full .= '</table>';

echo elgg_view_module('inline', elgg_echo('blog_tools:settings:full'), $settings_full);

// other settings
$settings_other = '<table>';

$settings_other .= '<tr>';
$settings_other .= elgg_format_element('td', [], elgg_echo('blog_tools:settings:advanced_publication'));
$settings_other .= elgg_format_element('td', [], elgg_view('input/select', [
	'name' => 'params[advanced_publication]',
	'options_values' => $noyes_options,
	'value' => $plugin->advanced_publication,
	'class' => 'mls',
]));
$settings_other .= '</tr>';

$settings_other .= '<tr>';
$settings_other .= elgg_format_element('td', [
	'colspan' => 2,
	'class' => 'elgg-subtext',
], elgg_echo('blog_tools:settings:advanced_publication:description'));
$settings_other .= '</tr>';

$settings_other .= '</table>';

echo elgg_view_module('inline', elgg_echo('blog_tools:settings:other'), $settings_other);
