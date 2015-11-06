<?php

$widget = $vars["entity"];

$num = (int) $widget->num_display;
if ($num < 1) {
	$num = 4;
}

$noyes_options = array(
	"no" => elgg_echo("option:no"),
	"yes" => elgg_echo("option:yes")
);

echo "<div>";
echo elgg_echo('blog:numbertodisplay') . ": ";
echo elgg_view("input/dropdown", array("options" => range(1, 10), "value" => $num, "name" => "params[num_display]"));
echo "</div>";

echo "<div>";
echo elgg_echo('blog_tools:widget:featured') . ": ";
echo elgg_view("input/dropdown", array("options_values" => $noyes_options, "value" => $widget->show_featured, "name" => "params[show_featured]"));
echo "</div>";
