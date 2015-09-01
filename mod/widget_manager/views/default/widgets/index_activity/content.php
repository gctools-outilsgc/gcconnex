<?php
$widget = $vars["entity"];

$count = sanitise_int($widget->activity_count, false);
if (empty($count)) {
	$count = 10;
}

if ($activity_content = $widget->activity_content) {
	if (!is_array($activity_content)) {
		if ($activity_content == "all") {
			unset($activity_content);
		} else {
			$activity_content = explode(",", $activity_content);
		}
	}
}

$river_options = array(
	"pagination" => false,
	"limit" => $count,
	"type_subtype_pairs" => array()
);

if (empty($activity_content)) {
	$activity = elgg_list_river($river_options);
} else {
	foreach ($activity_content as $content) {
		list($type, $subtype) = explode(",", $content);
		if (!empty($type)) {
			$value = $subtype;
			if (array_key_exists($type, $river_options['type_subtype_pairs'])) {
				if (!is_array($river_options['type_subtype_pairs'][$type])) {
					$value = array($river_options['type_subtype_pairs'][$type]);
				} else {
					$value = $river_options['type_subtype_pairs'][$type];
				}
				
				$value[] = $subtype;
			}
			$river_options['type_subtype_pairs'][$type] = $value;
		}
	}
	
	$activity = elgg_list_river($river_options);
}

if (empty($activity)) {
	$activity = elgg_echo("river:none");
}

echo $activity;
