<?php

$widget = $vars["entity"];

//get the num of blog entries the user wants to display
$num = (int) $widget->num_display;

//if no number has been set, default to 4
if ($num < 1) {
	$num = 4;
}

$options = array(
	"type" => "object",
	"subtype" => "blog",
	"container_guid" => $widget->getOwnerGUID(),
	"limit" => $num,
	"full_view" => false,
	"pagination" => false,
	"metadata_name_value_pairs" => array()
);

if (!elgg_is_admin_logged_in() && !($widget->getOwnerGUID() == elgg_get_logged_in_user_guid())) {
	$options["metadata_name_value_pairs"][] = array(
		"name" => "status",
		"value" => "published"
	);
}

if ($widget->show_featured == "yes") {
	$options["metadata_name_value_pairs"][] = array(
		"name" => "featured",
		"value" => true
	);
}

$content = elgg_list_entities_from_metadata($options);
if (!empty($content)) {
	echo $content;
	
	echo "<div class='elgg-widget-more'>";
	$owner = $widget->getOwnerEntity();
	if (elgg_instanceof($owner, "group")) {
		echo elgg_view("output/url", array("href" => "blog/group/" . $owner->getGUID() . "/all", "text" => elgg_echo("blog:moreblogs")));
	} else {
		echo elgg_view("output/url", array("href" => "blog/owner/" . $owner->username, "text" => elgg_echo("blog:moreblogs")));
	}
	echo "</div>";
} else {
	echo elgg_echo("blog:noblogs");
}
