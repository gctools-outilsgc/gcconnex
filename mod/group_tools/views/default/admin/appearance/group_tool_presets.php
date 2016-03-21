<?php

echo elgg_view("output/longtext", array("value" => elgg_echo("group_tools:admin:group_tool_presets:description")));


$presets = group_tools_get_tool_presets();

$title = elgg_echo("group_tools:admin:group_tool_presets:header");
$add_button = elgg_view("output/url", array(
	"text" => elgg_echo("add"),
	"href" => "#", 
	"onclick" => "return elgg.group_tools_admin.add_tool_preset();",
	"class" => "elgg-button elgg-button-action float-alt"
));


$form = elgg_view_form("group_tools/group_tool_presets", array(), array("group_tool_presets" => $presets));

echo elgg_view_module("inline", $add_button . $title, $form);