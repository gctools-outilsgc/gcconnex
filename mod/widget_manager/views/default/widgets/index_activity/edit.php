<?php

$widget = $vars["entity"];

$count = sanitise_int($widget->activity_count, false);
if (empty($count)) {
	$count = 10;
}

$contents = array();

$registered_entities = elgg_get_config("registered_entities");

if (!empty($registered_entities)) {
	foreach ($registered_entities as $type => $ar) {
		if (count($registered_entities[$type])) {
			foreach ($registered_entities[$type] as $subtype) {
				$keyname = 'item:' . $type . ':' . $subtype;
				$contents[elgg_echo($keyname)] = "{$type},{$subtype}";
			}
		} else {
			$keyname = 'item:' . $type;
			$contents[elgg_echo($keyname)] = "{$type},";
		}
	}
}

?>
<div>
	<?php
	echo elgg_echo("widget:numbertodisplay");
	echo elgg_view("input/text", array("name" => "params[activity_count]", "value" => $count, "size" => "4", "maxlength" => "4"));
	?>
</div>

<div>
	<?php
	echo elgg_echo("filter");
	
	$activity_content = $vars["entity"]->activity_content;
	echo elgg_view("input/checkboxes", array("name" => "params[activity_content]", "options" => $contents, "value" => $activity_content));
	?>
</div>