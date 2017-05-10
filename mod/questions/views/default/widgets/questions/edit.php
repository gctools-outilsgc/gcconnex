<?php
/**
 * Questions widget settings
 */

$widget = elgg_extract('entity', $vars);

$limit = (int) $widget->limit;
if ($limit < 1) {
	$limit = 5;
}

if ($widget->context === 'dashboard') {
	$content_type_options = [
		'mine' => elgg_echo('mine'),
		'all' => elgg_echo('all')
	];
	if (questions_is_expert()) {
		$content_type_options['todo'] = elgg_echo('questions:todo');
	}
	
	echo '<div>';
	echo elgg_echo('widget:questions:content_type');
	echo elgg_view('input/select', [
		'name' => 'params[content_type]',
		'value' => $widget->content_type,
		'options_values' => $content_type_options,
		'class' => 'mls',
	]);
	echo '</div>';
}

echo '<div>';
echo elgg_echo('widget:numbertodisplay');
echo elgg_view('input/text', ['name' => 'params[limit]', 'value' => $limit]);
echo '</div>';

echo '<div>';
echo elgg_echo('tags');
echo elgg_view('input/text', ['name' => 'params[filter_tags]', 'value' => $widget->filter_tags]);
echo '</div>';
