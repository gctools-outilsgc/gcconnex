<?php 

	$plugin = $vars["entity"];

	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")		
	);

	$custom_index_options = array(
		"0|0" => elgg_echo('option:no'),
		"1|0" => elgg_echo('widget_manager:settings:custom_index:non_loggedin'),
		"0|1" => elgg_echo('widget_manager:settings:custom_index:loggedin'),
		"1|1" => elgg_echo('widget_manager:settings:custom_index:all')		
	);

	$widget_layout_options = array(
		"33|33|33" => elgg_echo('widget_manager:settings:widget_layout:33|33|33'),
		"50|25|25" => elgg_echo('widget_manager:settings:widget_layout:50|25|25'),
		"25|50|25" => elgg_echo('widget_manager:settings:widget_layout:25|50|25'),
		"25|25|50" => elgg_echo('widget_manager:settings:widget_layout:25|25|50'),	
		"75|25" => elgg_echo('widget_manager:settings:widget_layout:75|25'),		
		"60|40" => elgg_echo('widget_manager:settings:widget_layout:60|40'),		
		"50|50" => elgg_echo('widget_manager:settings:widget_layout:50|50'),		
		"40|60" => elgg_echo('widget_manager:settings:widget_layout:40|60'),		
		"25|75" => elgg_echo('widget_manager:settings:widget_layout:25|75')	
	);
	
	$index_top_row_options = array(
		"none" => elgg_echo('widget_manager:settings:index_top_row:none'),
		"full_row" => elgg_echo('widget_manager:settings:index_top_row:full_row'),
		"two_column_left" => elgg_echo('widget_manager:settings:index_top_row:two_column_left')
	);
	
	$settings_index = "<table>";
	
	$settings_index .= "<tr>";
	$settings_index .= "<td>" . elgg_echo('widget_manager:settings:custom_index') . "</td>";
	$settings_index .= "<td>" . elgg_view("input/dropdown", array("name" => "params[custom_index]", "value" => $plugin->custom_index, "options_values" => $custom_index_options)) . "</td>";
	$settings_index .= "</tr>";
	
	$settings_index .= "<tr>";
	$settings_index .= "<td>" . elgg_echo('widget_manager:settings:widget_layout') . "</td>";
	$settings_index .= "<td>" . elgg_view("input/dropdown", array("name" => "params[widget_layout]", "value" => $plugin->widget_layout, "options_values" => $widget_layout_options)) . "</td>";
	$settings_index .= "</tr>";
	
	$settings_index .= "<tr>";
	$settings_index .= "<td>" . elgg_echo('widget_manager:settings:index_top_row') . "</td>";
	$settings_index .= "<td>" . elgg_view("input/dropdown", array("name" => "params[index_top_row]", "value" => $plugin->index_top_row, "options_values" => $index_top_row_options)) . "</td>";
	$settings_index .= "</tr>";
	
	$settings_index .= "<tr>";
	$settings_index .= "<td>" . elgg_echo('widget_manager:settings:disable_free_html_filter') . "</td>";
	$settings_index .= "<td>" . elgg_view("input/dropdown", array("name" => "params[disable_free_html_filter]", "value" => $plugin->disable_free_html_filter, "options_values" => $noyes_options)) . "</td>";
	$settings_index .= "</tr>";
	
	$settings_index .= "</table>";

	echo elgg_view_module("inline", elgg_echo("widget_manager:settings:index"), $settings_index);

	$settings_group = "<table>";
	
	$settings_group .= "<tr>";
	$settings_group .= "<td>" . elgg_echo('widget_manager:settings:group:enable') . "</td>";
	$settings_group .= "<td>" . elgg_view("input/dropdown", array("name" => "params[group_enable]", "value" => $plugin->group_enable, "options_values" => $noyes_options)) . "</td>";
	$settings_group .= "</tr>";
	
	$settings_group .= "<tr>";
	$settings_group .= "<td>" . elgg_echo('widget_manager:settings:group:option_default_enabled') . "</td>";
	$settings_group .= "<td>" . elgg_view("input/dropdown", array("name" => "params[group_option_default_enabled]", "value" => $plugin->group_option_default_enabled, "options_values" => $noyes_options)) . "</td>";
	$settings_group .= "</tr>";
	
	$settings_group .= "<tr>";
	$settings_group .= "<td>" . elgg_echo('widget_manager:settings:group:option_admin_only') . "</td>";
	$settings_group .= "<td>" . elgg_view("input/dropdown", array("name" => "params[group_option_admin_only]", "value" => $plugin->group_option_admin_only, "options_values" => $noyes_options)) . "</td>";
	$settings_group .= "</tr>";
	
	$settings_group .= "</table>";
	
	echo elgg_view_module("inline", elgg_echo("widget_manager:settings:group"), $settings_group);

	$settings_multi_dashboard = "<table>";
	
	$settings_multi_dashboard .= "<tr>";
	$settings_multi_dashboard .= "<td>" . elgg_echo('widget_manager:settings:multi_dashboard:enable') . "</td>";
	$settings_multi_dashboard .= "<td>" . elgg_view("input/dropdown", array("name" => "params[multi_dashboard_enabled]", "value" => $plugin->multi_dashboard_enabled, "options_values" => $noyes_options)) . "</td>";
	$settings_multi_dashboard .= "</tr>";
	
	$settings_multi_dashboard .= "</table>";
	
	echo elgg_view_module("inline", elgg_echo("widget_manager:settings:multi_dashboard"), $settings_multi_dashboard);