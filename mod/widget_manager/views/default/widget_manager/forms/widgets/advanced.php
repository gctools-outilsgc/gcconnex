<?php
$widget = $vars["entity"];
$widget_context = $vars["widget_context"];

$yesno_options = array(
		"yes" => elgg_echo("option:yes"),
		"no" => elgg_echo("option:no")
);

$noyes_options = array_reverse($yesno_options, true);

$advanced = "<div class='hidden' id='widget-manager-widget-edit-advanced-" . $widget->getGUID() . "'>";

$advanced .= "<h3>" . elgg_echo("widget_manager:widgets:edit:advanced") . "</h3>";
$advanced .= "<fieldset>";

$advanced .= "<div>" . elgg_echo('widget_manager:widgets:edit:custom_title') . ": " . elgg_view('input/text', array('name' => 'params[widget_manager_custom_title]', 'value' => $widget->widget_manager_custom_title)) . "</div>";
$advanced .= "<div>" . elgg_echo('widget_manager:widgets:edit:custom_url') . ": " . elgg_view('input/text', array('name' => 'params[widget_manager_custom_url]', 'value' => $widget->widget_manager_custom_url)) . "</div>";

$advanced_context = elgg_trigger_plugin_hook("advanced_context", "widget_manager", array("entity" => $widget), array("index"));

if (is_array($advanced_context) && in_array($widget_context, $advanced_context)) {
	$collapse_state_options = array (
			"0" => elgg_echo("status:open"),
			"closed" => elgg_echo("status:closed")
	);

	$advanced .= "<div>" . elgg_echo('widget_manager:widgets:edit:custom_more_title') . ": " . elgg_view('input/text', array('name' => 'params[widget_manager_custom_more_title]', 'value' => $widget->widget_manager_custom_more_title)) . "</div>";
	$advanced .= "<div>" . elgg_echo('widget_manager:widgets:edit:custom_more_url') . ": " . elgg_view('input/text', array('name' => 'params[widget_manager_custom_more_url]', 'value' => $widget->widget_manager_custom_more_url)) . "</div>";

	$advanced .= "<div>" . elgg_echo('widget_manager:widgets:edit:hide_header') . ": " . elgg_view('input/dropdown', array('name' => 'params[widget_manager_hide_header]', 'value' => $widget->widget_manager_hide_header, 'options_values' => $noyes_options)) . "</div>";
	$advanced .= "<div>" . elgg_echo('widget_manager:widgets:edit:disable_widget_content_style') . ": " . elgg_view('input/dropdown', array('name' => 'params[widget_manager_disable_widget_content_style]', 'value' => $widget->widget_manager_disable_widget_content_style, 'options_values' => $noyes_options)) . "</div>";
	$advanced .= "<div>" . elgg_echo('widget_manager:widgets:edit:custom_class') . ": " . elgg_view('input/text', array('name' => 'params[widget_manager_custom_class]', 'value' => $widget->widget_manager_custom_class)) . "</div>";
	$advanced .= "<div>" . elgg_echo('widget_manager:widgets:edit:fixed_height') . ": " . elgg_view('input/text', array('name' => 'params[widget_manager_fixed_height]', 'value' => $widget->widget_manager_fixed_height)) . "</div>";
	$advanced .= "<div>" . elgg_echo('widget_manager:widgets:edit:collapse_disable') . ": " . elgg_view('input/dropdown', array('name' => 'params[widget_manager_collapse_disable]', 'value' => $widget->widget_manager_collapse_disable, 'options_values' => $noyes_options)) . "</div>";
	$advanced .= "<div>" . elgg_echo('widget_manager:widgets:edit:collapse_state') . ": " . elgg_view('input/dropdown', array('name' => 'params[widget_manager_collapse_state]', 'value' => $widget->widget_manager_collapse_state, 'options_values' => $collapse_state_options)) . "</div>";
}

$advanced .= "</fieldset>";
$advanced .= "</div>";
$advanced .= "<a rel='toggle' class='elgg-button elgg-button-action float-alt' href='#widget-manager-widget-edit-advanced-" . $widget->getGUID() . "'>" . elgg_echo("widget_manager:widgets:edit:advanced") . "</a>";

echo $advanced;