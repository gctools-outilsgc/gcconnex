<?php
/**
 * content of the group members widget
 */

$widget = $vars["entity"];

$count = (int) $widget->num_display;
if ($count < 1) {
	$count = 5;
}

$options = array(
	"type" => "user",
	"limit" => $count,
	"relationship" => "member",
	"relationship_guid" => $widget->getOwnerGUID(),
	"inverse_relationship" => true,
	"list_type" => "gallery",
	"gallery_class" => "elgg-gallery-users",
	"pagination" => false
);

$list = elgg_list_entities_from_relationship($options);
if (empty($list)) {
	$list = elgg_echo("widgets:group_members:view:no_members");
}

echo $list;
