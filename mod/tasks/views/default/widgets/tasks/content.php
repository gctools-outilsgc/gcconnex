<?php
/**
 * Elgg tasks widget
 *
 * @package ElggTasks
 */

$widget = elgg_extract("entity", $vars);

$num = (int) $widget->tasks_num;

$options = array(
	"type" => "object",
	"subtype" => "task_top",
	"limit" => $num,
	"full_view" => FALSE,
	"pagination" => FALSE,
);

if (!elgg_instanceof($widget->getOwnerEntity(), "site")) {
	$options["container_guid"] = $widget->getOwnerGUID();
}

$content = elgg_list_entities($options);

if ($content) {
	echo $content;
	
	$url = "";
	if (elgg_instanceof($widget->getOwnerEntity(), "site")) {
		$url = "tasks/all";
	} elseif (elgg_instanceof($widget->getOwnerEntity(), "user")) {
		$url = "tasks/owner/" . $widget->getOwnerEntity()->username;
	} elseif (elgg_instanceof($widget->getOwnerEntity(), "group")) {
		$url = "tasks/group/" . $widget->getOwnerGUID() . "/all";
	}
	
	$more_link = elgg_view("output/url", array(
		"href" => $url,
		"text" => elgg_echo("tasks:more"),
		"is_trusted" => true,
	));
	echo "<span class='elgg-widget-more'>" . $more_link . "</span>";
} else {
	echo elgg_echo("tasks:none");
}
