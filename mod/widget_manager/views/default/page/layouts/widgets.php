<?php
/**
 * Elgg widgets layout
 *
 * @uses $vars['content']          Optional display box at the top of layout
 * @uses $vars['num_columns']      Number of widget columns for this layout (3)
 * @uses $vars['show_add_widgets'] Display the add widgets button and panel (true)
 * @uses $vars['exact_match']      Widgets must match the current context (false)
 * @uses $vars['show_access']      Show the access control (true)
 */

$num_columns = (int) elgg_extract('num_columns', $vars, 3);
$show_add_widgets = elgg_extract('show_add_widgets', $vars, true);
$exact_match = elgg_extract('exact_match', $vars, false);
$show_access = elgg_extract('show_access', $vars, true);

$owner = elgg_get_page_owner_entity();

$context = elgg_get_context();

$available_widgets_context = elgg_trigger_plugin_hook('available_widgets_context', 'widget_manager', [], $context);

$widget_types = elgg_get_widget_types([
	'context' => $available_widgets_context,
	'exact' => $exact_match,
	'container' => $owner,
]);

elgg_push_context('widgets');

$widgets = elgg_extract('widgets', $vars);
if (!isset($vars['widgets'])) {
	$widgets = elgg_get_widgets($owner->guid, $context);
}

$top_row_used = elgg_extract('top_row_used', $vars);
if ($top_row_used) {
	unset($widgets[4]);
}

echo "<div class='elgg-layout-widgets layout-widgets-{$context}'>";

if (elgg_can_edit_widget_layout($context) && $show_add_widgets) {
	echo elgg_view('page/layouts/widgets/add_button', [
		'context' => $context,
		'exact_match' => $exact_match,
		'show_access' => $show_access,
	]);
}

if (empty($widgets) || $context !== 'dashboard') {
	echo elgg_extract('content', $vars);
}

if ($context == 'groups') {
	$groups_top_row = '';
	
	if (isset($widgets[3]) && (sizeof($widgets[3]) > 0)) {
		foreach ($widgets[3] as $widget) {
			if (array_key_exists($widget->handler, $widget_types)) {
				$groups_top_row .= elgg_view_entity($widget, ['show_access' => $show_access]);
			}
		}
	}
	
	echo elgg_format_element('div', [
		'id' => 'elgg-widget-col-3',
		'class' => 'elgg-col-1of1 elgg-widgets widget-manager-groups-widgets-top-row',
	], $groups_top_row);

} elseif (in_array($context, ['index', 'dashboard']) || widget_manager_is_extra_context($context)) {
	
	foreach ($widgets as $index => $column) {
		if ($index > $num_columns) {
			if (!isset($widgets[$num_columns])) {
				$widgets[$num_columns] = [];
			}
			
			// add overflow column widgets to the max column
			$widgets[$num_columns] = array_merge($widgets[$index], $widgets[$num_columns]);
			unset($widgets[$index]);
		}
	}
}

for ($column_index = 1; $column_index <= $num_columns; $column_index++) {
	$column_widgets = elgg_extract($column_index, $widgets, []);
	
	$column_content = '';
	foreach ($column_widgets as $widget) {
		if (array_key_exists($widget->handler, $widget_types)) {
			$column_content .= elgg_view_entity($widget, ['show_access' => $show_access]);
		}
	}
	
	echo elgg_format_element('div', [
		'id' => "elgg-widget-col-{$column_index}",
		'class' => "elgg-col-1of{$num_columns} elgg-widgets",
	], $column_content);
}

echo '</div>';

elgg_pop_context();

echo elgg_view('graphics/ajax_loader', ['id' => 'elgg-widget-loader']);
