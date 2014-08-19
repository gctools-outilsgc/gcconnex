<?php

$plugin = elgg_extract("entity", $vars);

$noyes_options = array(
	"no" => elgg_echo("option:no"),
	"yes" => elgg_echo("option:yes")
);

$wire_length = (int) $plugin->wire_length;
if ($wire_length < 1) {
	$wire_length = 140;
}

// enable group support
echo "<div>";
echo elgg_echo("thewire_tools:settings:enable_group");
echo elgg_view("input/dropdown", array("name" => "params[enable_group]", "value" => $plugin->enable_group, "options_values" => $noyes_options, "class" => "mlm"));
echo "</div>";

// extend widgets
echo "<div>";
echo elgg_echo("thewire_tools:settings:extend_widgets");
echo elgg_view("input/dropdown", array("name" => "params[extend_widgets]", "value" => $plugin->extend_widgets, "options_values" => array_reverse($noyes_options, true), "class" => "mlm"));
echo "</div>";

// extend widgets
echo "<div>";
echo elgg_echo("thewire_tools:settings:extend_activity");
echo elgg_view("input/dropdown", array("name" => "params[extend_activity]", "value" => $plugin->extend_activity, "options_values" => $noyes_options, "class" => "mlm"));
echo "</div>";

// Set max wire length
// @todo: can be removed in Elgg 1.9
echo "<div>";
echo elgg_echo("thewire_tools:settings:wire_length");
echo elgg_view("input/text", array("name" => "params[wire_length]", "value" => $wire_length));
echo "</div>";
