<?php

$presets = get_input("params");

// filter out invalid input
foreach ($presets as $index => $values) {
	if (!is_numeric($index)) {
		// the placeholder for cloning
		unset($presets[$index]);
	} elseif (!elgg_extract("title", $values)) {
		// title is required
		unset($presets[$index]);
	}
}

// reset array keys
if (!empty($presets)) {
	$presets = array_values($presets);
}

elgg_set_plugin_setting("group_tool_presets", json_encode($presets), "group_tools");

system_message(elgg_echo("group_tools:action:group_tool:presets:saved"));

forward(REFERER);