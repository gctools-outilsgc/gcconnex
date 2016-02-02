<?php

$plugin = elgg_extract("entity", $vars);

$options = array(
	"date" => elgg_echo("file_tools:usersettings:time:date"),
	"days" => elgg_echo("file_tools:usersettings:time:days")
);

$file_tools_time_display_value = $plugin->getUserSetting("file_tools_time_display", elgg_get_page_owner_guid());
if (empty($file_tools_time_display_value)) {
	$file_tools_time_display_value = elgg_get_plugin_setting("file_tools_default_time_display", "file_tools");
}

echo "<div class='mrgn-bttm-md'>";
echo elgg_echo("file_tools:usersettings:time:description");
echo "</div>";

echo "<div>";
echo '<label for="time">' . elgg_echo("file_tools:usersettings:time") . '</label>';
echo "&nbsp;" . elgg_view("input/dropdown", array(
	"name" => "params[file_tools_time_display]",
	"options_values" => $options,
    "id" => "time",
    "class" => 'mrgn-bttm-md',
	"value" => $file_tools_time_display_value
));
echo "</div>";

