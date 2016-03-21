<?php

$plugin_setting = elgg_get_plugin_setting("group_enable", "widget_manager");
if (!in_array($plugin_setting, array("yes", "forced"))) {
	register_error(elgg_echo("widget_manager:action:force_tool_widgets:error:not_enabled"));
	forward(REFERER);
}

$counter = 0;
$options = array(
	"type" => "group",
	"limit" => false
);
$batch = new ElggBatch("elgg_get_entities", $options);
foreach ($batch as $group) {
	$group->save();
	$counter++;
}

system_message(elgg_echo("widget_manager:action:force_tool_widgets:succes", array($counter)));
forward(REFERER);