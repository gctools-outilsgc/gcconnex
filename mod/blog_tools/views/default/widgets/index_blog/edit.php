<?php

$widget = elgg_extract('entity', $vars);

$count = (int) $widget->blog_count;
if ($count < 1) {
	$count = 8;
}

$view_mode_options_values = [
	'list' => elgg_echo('blog_tools:widgets:index_blog:view_mode:list'),
	'preview' => elgg_echo('blog_tools:widgets:index_blog:view_mode:preview'),
	'slider' => elgg_echo('blog_tools:widgets:index_blog:view_mode:slider'),
	'simple' => elgg_echo('blog_tools:widgets:index_blog:view_mode:simple'),
];

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

echo elgg_format_element('div', [], elgg_echo('blog:numbertodisplay'));
echo elgg_view('input/text', [
	'name' => 'params[blog_count]',
	'value' => $count,
	'size' => '4',
	'maxlength' => '4',
]);

echo elgg_format_element('div', [], elgg_echo('blog_tools:widgets:index_blog:view_mode'));
echo elgg_view('input/select', [
	'name' => 'params[view_mode]',
	'options_values' => $view_mode_options_values,
	'value' => $widget->view_mode,
]);

echo elgg_format_element('div', [], elgg_echo('blog_tools:widget:featured'));
echo elgg_view('input/select', [
	'name' => 'params[show_featured]',
	'options_values' => $noyes_options,
	'value' => $widget->show_featured,
]);
