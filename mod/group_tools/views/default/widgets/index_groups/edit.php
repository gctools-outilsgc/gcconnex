<?php
/**
 * settings for the index group widget
 */

$widget = elgg_extract('entity', $vars);

$count = sanitise_int($widget->group_count, false);
if ($count < 1) {
	$count = 8;
}

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

// filter based on tag fields
$tag_fields = [];
$profile_fields = elgg_get_config('group');
if (!empty($profile_fields)) {
	foreach ($profile_fields as $name => $type) {
		if ($type !== 'tags') {
			continue;
		}
		
		$lan_key = "groups:{$name}";
		$label = $name;
		if (elgg_language_key_exists($lan_key)) {
			$label = elgg_echo($lan_key);
		}
		
		$tag_fields[$name] = $label;
	}
}

$sorting_options = [
	'newest' => elgg_echo('sort:newest'),
	'popular' => elgg_echo('sort:popular'),
	'ordered' => elgg_echo('group_tools:groups:sorting:ordered'),
];

$sorting_value = $widget->sorting;
if (empty($sorting_value) && ($widget->apply_sorting == 'yes')) {
	$sorting_value = 'ordered';
}

echo '<div>';
echo elgg_echo('widget:numbertodisplay');
echo elgg_view('input/text', [
	'name' => 'params[group_count]',
	'value' => $count,
	'size' => '4',
	'maxlength' => '4',
]);
echo '</div>';

echo '<div>';
echo elgg_echo('widgets:index_groups:show_members');
echo elgg_view('input/select', [
	'name' => 'params[show_members]',
	'options_values' => $noyes_options,
	'value' => $widget->show_members,
	'class' => 'mls',
]);
echo '</div>';

echo '<div>';
echo elgg_echo('widgets:index_groups:featured');
echo elgg_view('input/select', [
	'name' => 'params[featured]',
	'options_values' => $noyes_options,
	'value' => $widget->featured,
	'class' => 'mls',
]);
echo '</div>';

if (!empty($tag_fields)) {
	$tag_fields = array_reverse($tag_fields);
	$tag_fields[''] = elgg_echo('widgets:index_groups:filter:no_filter');
	$tag_fields = array_reverse($tag_fields);
	
	echo '<div>';
	echo elgg_echo('widgets:index_groups:filter:field');
	echo elgg_view('input/select', [
		'name' => 'params[filter_name]',
		'value' => $widget->filter_name,
		'options_values' => $tag_fields,
		'class' => 'mls',
	]);
	echo '<br />';
	
	echo elgg_echo('widgets:index_groups:filter:value');
	echo elgg_view('input/tags', [
		'name' => 'params[filter_value]',
		'value' => $widget->filter_value,
	]);
	echo '</div>';
}

echo '<div>';
echo elgg_echo('widgets:index_groups:sorting');
echo elgg_view('input/select', [
	'name' => 'params[sorting]',
	'options_values' => $sorting_options,
	'value' => $sorting_value,
	'class' => 'mls',
]);
echo '</div>';
