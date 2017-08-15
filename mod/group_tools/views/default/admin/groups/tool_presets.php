<?php

// description
echo elgg_view('output/longtext', [
	'value' => elgg_echo('group_tools:admin:group_tool_presets:description'),
]);

// get presets
$presets = group_tools_get_tool_presets();

// build elements
$title = elgg_echo('group_tools:admin:group_tool_presets:header');
$add_button = elgg_view('output/url', [
	'text' => elgg_echo('add'),
	'href' => '#',
	'class' => 'elgg-button elgg-button-action float-alt group-tools-admin-add-tool-preset',
]);

$form = elgg_view_form('group_tools/group_tool_presets', [], ['group_tool_presets' => $presets]);

// draw list
echo elgg_view_module('inline', $add_button . $title, $form);
