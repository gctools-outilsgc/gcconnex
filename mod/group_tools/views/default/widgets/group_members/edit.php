<?php 

	$widget = $vars["entity"];

	$count = (int) $widget->num_display;
	if($count < 1){
		$count = 5;
	}

	echo elgg_echo("widget:numbertodisplay");
	echo "&nbsp;";
	echo elgg_view("input/text", array("name" => "params[num_display]", "value" => $count, "size" => "4", "maxlength" => "3"));