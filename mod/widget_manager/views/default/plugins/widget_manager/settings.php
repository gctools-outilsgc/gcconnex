<?php

elgg_require_js('widget_manager/settings_extra_contexts');

$plugin = elgg_extract('entity', $vars);

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

$groupenable_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('widget_manager:settings:group:enable:yes'),
	'forced' => elgg_echo('widget_manager:settings:group:enable:forced'),
];

$custom_index_options = [
	'0|0' => elgg_echo('option:no'),
	'1|0' => elgg_echo('widget_manager:settings:custom_index:non_loggedin'),
	'0|1' => elgg_echo('widget_manager:settings:custom_index:loggedin'),
	'1|1' => elgg_echo('widget_manager:settings:custom_index:all'),
];

$widget_layout_options = [
	'33|33|33' => elgg_echo('widget_manager:settings:widget_layout:33|33|33'),
	'50|25|25' => elgg_echo('widget_manager:settings:widget_layout:50|25|25'),
	'25|50|25' => elgg_echo('widget_manager:settings:widget_layout:25|50|25'),
	'25|25|50' => elgg_echo('widget_manager:settings:widget_layout:25|25|50'),
	'75|25' => elgg_echo('widget_manager:settings:widget_layout:75|25'),
	'60|40' => elgg_echo('widget_manager:settings:widget_layout:60|40'),
	'50|50' => elgg_echo('widget_manager:settings:widget_layout:50|50'),
	'40|60' => elgg_echo('widget_manager:settings:widget_layout:40|60'),
	'25|75' => elgg_echo('widget_manager:settings:widget_layout:25|75'),
	'100' => elgg_echo('widget_manager:settings:widget_layout:100'),
];

$index_top_row_options = [
	'none' => elgg_echo('widget_manager:settings:index_top_row:none'),
	'full_row' => elgg_echo('widget_manager:settings:index_top_row:full_row'),
	'two_column_left' => elgg_echo('widget_manager:settings:index_top_row:two_column_left'),
];

$settings_index = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('widget_manager:settings:custom_index'),
	'name' => 'params[custom_index]',
	'value' => $plugin->custom_index,
	'options_values' => $custom_index_options,
]);

$settings_index .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('widget_manager:settings:widget_layout'),
	'name' => 'params[widget_layout]',
	'value' => $plugin->widget_layout,
	'options_values' => $widget_layout_options,
]);

$settings_index .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('widget_manager:settings:index_top_row'),
	'name' => 'params[index_top_row]',
	'value' => $plugin->index_top_row,
	'options_values' => $index_top_row_options,
]) . '</td>';

echo elgg_view_module('inline', elgg_echo('widget_manager:settings:index'), $settings_index);

if (elgg_is_active_plugin('groups')) {
	$settings_group = elgg_view_field([
		'#type' => 'select',
		'#label' => elgg_echo('widget_manager:settings:group:enable'),
		'name' => 'params[group_enable]',
		'value' => $plugin->group_enable,
		'options_values' => $groupenable_options,
		'#help' => elgg_view('output/url', [
			'text' => elgg_echo('widget_manager:settings:group:force_tool_widgets'),
			'href' => 'action/widget_manager/force_tool_widgets',
			'confirm' => elgg_echo('widget_manager:settings:group:force_tool_widgets:confirm'),
		]),
	]);
	
	$settings_group .= elgg_view_field([
		'#type' => 'select',
		'#label' => elgg_echo('widget_manager:settings:group:option_default_enabled'),
		'name' => 'params[group_option_default_enabled]',
		'value' => $plugin->group_option_default_enabled,
		'options_values' => $noyes_options,
	]);
	
	$settings_group .= elgg_view_field([
		'#type' => 'select',
		'#label' => elgg_echo('widget_manager:settings:group:option_admin_only'),
		'name' => 'params[group_option_admin_only]',
		'value' => $plugin->group_option_admin_only,
		'options_values' => $noyes_options,
	]);
	
	echo elgg_view_module('inline', elgg_echo('widget_manager:settings:group'), $settings_group);
}
	
$default_widget_layout = $plugin->widget_layout;

$settings_extra_contexts = '<table id="widget-manager-settings-extra-contexts" class="elgg-table-alt">';
$settings_extra_contexts .= '<tr><th>' . elgg_echo('widget_manager:settings:extra_contexts:page') . '</th>';
$settings_extra_contexts .= '<th>' . elgg_echo('widget_manager:settings:extra_contexts:layout') . '</th>';
$settings_extra_contexts .= '<th>' . elgg_echo('widget_manager:settings:extra_contexts:top_row') . '</th>';
$settings_extra_contexts .= '<th>' . elgg_echo('widget_manager:settings:extra_contexts:manager') . '</th><th></th></tr>';

$contexts = string_to_tag_array($plugin->extra_contexts);

$contexts_config = json_decode($plugin->extra_contexts_config, true);
if (!is_array($contexts_config)) {
	$contexts_config = [];
}

if ($contexts) {
	foreach ($contexts as $context) {
		$context_config = elgg_extract($context, $contexts_config, array());
		$context_layout = elgg_extract('layout', $context_config, $default_widget_layout);
		$top_row = elgg_extract('top_row', $context_config);
		$context_manager = elgg_extract('manager', $context_config, '');
		
		$settings_extra_contexts .= '<tr>';
		$settings_extra_contexts .= '<td>' . elgg_view('input/text', [
			'name' => 'contexts[page][]',
			'value' => $context,
			'class' => 'pan phs',
		]) . '</td>';
		$settings_extra_contexts .= '<td>' . elgg_view('input/dropdown', [
			'name' => 'contexts[layout][]',
			'value' => $context_layout,
			'options_values' => $widget_layout_options,
		]) . '</td>';
		$settings_extra_contexts .= '<td>' . elgg_view('input/dropdown', [
			'name' => 'contexts[top_row][]',
			'value' => $top_row,
			'options_values' => $index_top_row_options,
		]) . '</td>';
		$settings_extra_contexts .= '<td>' . elgg_view('input/text', [
			'name' => 'contexts[manager][]',
			'value' => $context_manager,
			'class' => 'pan phs',
		]) . '</td>';
		$settings_extra_contexts .= '<td>' . elgg_view_icon('delete', ['class' => 'elgg-toggle']) . '</td>';
		$settings_extra_contexts .= '</tr>';
	}
}
$settings_extra_contexts .= '<tr class="hidden">';
$settings_extra_contexts .= '<td>' . elgg_view('input/text', [
	'name' => 'contexts[page][]',
	'class' => 'pan phs',
]) . '</td>';
$settings_extra_contexts .= '<td>' . elgg_view('input/dropdown', [
	'name' => 'contexts[layout][]',
	'value' => $default_widget_layout,
	'options_values' => $widget_layout_options,
]) . '</td>';
$settings_extra_contexts .= '<td>' . elgg_view('input/dropdown', [
	'name' => 'contexts[top_row][]',
	'options_values' => $index_top_row_options,
]) . '</td>';
$settings_extra_contexts .= '<td>' . elgg_view('input/text', [
	'name' => 'contexts[manager][]',
	'class' => 'pan phs',
]) . '</td>';
$settings_extra_contexts .= '<td>' . elgg_view_icon('delete', ['class' => 'elgg-toggle']) . '</td>';
$settings_extra_contexts .= '</tr>';

$settings_extra_contexts .= '</table>';

$settings_extra_contexts .= elgg_format_element('span', ['class' => 'elgg-subtext'], elgg_echo('widget_manager:settings:extra_contexts:description'));
	
$settings_extra_contexts_title = elgg_view('input/button', [
	'id' => 'widget-manager-settings-add-extra-context',
	'value' => elgg_echo('widget_manager:settings:extra_contexts:add'),
	'class' => 'float-alt elgg-button elgg-button-action pan phs man',
]);
$settings_extra_contexts_title .= elgg_echo('widget_manager:settings:extra_contexts');

echo elgg_view_module('inline', $settings_extra_contexts_title, $settings_extra_contexts);
