<?php
/**
 * Edit the widget
 */

$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 10;
}

// filter activity
// get filter options
$filter_contents = [
	'0' => elgg_echo('all'),
];
$registered_entities = elgg_get_config('registered_entities');
if (!empty($registered_entities)) {
	foreach ($registered_entities as $type => $ar) {
		if ($type == 'user') {
			continue;
		} else {
			if (count($registered_entities[$type])) {
				foreach ($registered_entities[$type] as $subtype) {
					$keyname = "item:{$type}:{$subtype}";
					$filter_contents["{$type},{$subtype}"] = elgg_echo($keyname);
				}
			} else {
				$keyname = "item:{$type}";
				$filter_contents["{$type},"] = elgg_echo($keyname);
			}
		}
	}
}

$filter_selector = elgg_view('input/select', [
	'name' => 'params[activity_filter]',
	'value' => $widget->activity_filter,
	'options_values' => $filter_contents,
]);

if ($widget->context === 'groups') {
	echo '<div>';
	echo elgg_echo('widgets:group_river_widget:edit:num_display');
	echo elgg_view('input/select', [
		'options' => range(5, 25, 5),
		'value' => $num_display,
		'name' => 'params[num_display]',
		'class' => 'mls',
	]);
	echo '</div>';
	
	echo '<div>';
	echo elgg_echo('filter') . '<br />';
	echo $filter_selector;
	echo '</div>';
	
	return;
}

//the user of the widget
$owner = $widget->getOwnerEntity();

// get all groups
$options = [
	'type' => 'group',
	'limit' => false,
	'joins' => [
		'JOIN ' . elgg_get_config('dbprefix') . 'groups_entity ge ON e.guid = ge.guid',
	],
	'order_by' => 'ge.name ASC',
];

if ($owner instanceof ElggUser) {
	$options['relationship'] = 'member';
	$options['relationship_guid'] = $owner->getGUID();
}

$batch = new ElggBatch('elgg_get_entities_from_relationship', $options);
$batch->rewind(); // needed so the next call succeeds
if (!$batch->valid()) {
	echo elgg_echo('widgets:group_river_widget:edit:no_groups');
	return;
}

// get groups
$group_options_values = [];
foreach ($batch as $group) {
	$group_options_values[$group->name] = $group->getGUID();
}

// make options
echo '<div>';
echo elgg_echo('widgets:group_river_widget:edit:num_display');
echo elgg_view('input/select', [
	'options' => range(5, 25, 5),
	'value' => $num_display,
	'name' => 'params[num_display]',
	'class' => 'mls',
]);
echo '</div>';

echo '<div>';
echo elgg_echo('filter') . '<br />';
echo $filter_selector;
echo '</div>';

echo '<div>';
echo elgg_echo('widgets:group_river_widget:edit:group');
echo elgg_view('input/checkboxes', [
	'name' => 'params[group_guid]',
	'value' => $widget->group_guid,
	'options' => $group_options_values,
]);
echo '</div>';
