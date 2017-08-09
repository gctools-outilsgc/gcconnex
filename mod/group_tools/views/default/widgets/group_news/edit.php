<?php
/**
 * settings for the group news widget
 */

$widget = elgg_extract('entity', $vars);

$blog_count = sanitise_int($widget->blog_count);
if ($blog_count < 1) {
	$blog_count = 5;
}

$options_values = [
	'' => elgg_echo('widgets:group_news:settings:no_project'),
];
$options = [
	'type' => 'group',
	'limit' => false,
	'joins' => [
		'JOIN ' . elgg_get_config('dbprefix') . 'groups_entity ge ON e.guid = ge.guid',
	],
	'order_by' => 'ge.name ASC',
];

$batch = new ElggBatch('elgg_get_entities', $options);
foreach ($batch as $group) {
	$options_values[$group->getGUID()] = $group->name;
}

for ($i = 1; $i < 6; $i++) {
	$metadata_name = "project_{$i}";
	
	echo '<div>';
	echo elgg_echo('widgets:group_news:settings:project');
	echo elgg_view('input/select', [
		'options_values' => $options_values,
		'name' => "params[{$metadata_name}]",
		'value' => $widget->$metadata_name,
		'class' => 'mls',
	]);
	echo '</div>';
}

echo '<div>';
echo elgg_echo('widgets:group_news:settings:blog_count');
echo elgg_view('input/select', [
	'options' => [1,2,3,4,5,6,7,8,9,10,15,20],
	'name' => 'params[blog_count]',
	'value' => $blog_count,
	'class' => 'mls',
]);
echo '</div>';

echo '<div>';
echo elgg_echo('widgets:group_news:settings:group_icon_size');
echo elgg_view('input/select', [
	'options_values' => [
		'medium' => elgg_echo('icon:size:medium'),
		'small' => elgg_echo('icon:size:small'),
	],
	'name' => 'params[group_icon_size]',
	'value' => $widget->group_icon_size,
	'class' => 'mls',
]);
echo '</div>';
