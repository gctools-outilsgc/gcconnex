<?php

$widget = $vars["entity"];

$count = (int) $widget->wire_count;
if ($count < 1) {
	$count = 8;
}

echo "<div>";
echo elgg_echo("thewire:num");
echo elgg_view("input/text", array("name" => "params[wire_count]", "value" => $count, "size" => 4, "maxlength" => 4));
echo "</div>";

echo "<div>";
echo elgg_echo("widgets:thewire:filter");
echo elgg_view("input/text", array("name" => "params[filter]", "value" => $widget->filter, "class" => "mlm"));
echo "</div>";
