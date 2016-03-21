<?php
/**
 * content of the group news widget
 */
$widget = $vars["entity"];

$configured_projects = array();

for ($i = 1; $i < 6; $i++) {
	$metadata_name = "project_" . $i;
	if ($guid = $widget->$metadata_name) {
		$group = get_entity($guid);
		if (!empty($group) && elgg_instanceof($group, "group")) {
			$configured_projects[] = $group;
		}
	}
}

if (!empty($configured_projects)) {

	if (elgg_is_xhr()) {
		echo "<script type='text/javascript'>require(['group_tools/group_news']);</script>";
	} else {
		elgg_require_js("group_tools/group_news");
	}
	
	$blog_count = sanitise_int($widget->blog_count);
	if ($blog_count < 1) {
		$blog_count = 5;
	}
	
	$group_icon_size = $widget->group_icon_size;
	if ($group_icon_size !== "small") {
		$group_icon_size = "medium";
	}

	echo "<div class='widget_group_news_container'>";
	foreach ($configured_projects as $key => $group) {
		
		$body = "<h3>" . $group->name . "</h3>";
		$icon = elgg_view_entity_icon($group, $group_icon_size);
		
		$group_news = elgg_get_entities(array(
			"type" => "object",
			"subtype" => "blog",
			"container_guid" => $group->getGUID(),
			"limit" => $blog_count
		));
		if (!empty($group_news)) {
			$body .= "<ul>";
			foreach ($group_news as $news) {
				$body .= "<li><a href='" . $news->getURL() . "'>" . $news->title . "</a></li>";
			}
			$body .= "</ul>";
		} else {
			$body .= elgg_echo("widgets:group_news:no_news");
		}
		
		$class = "widget_group_news_" . ($key + 1) . "_" . $group->getGUID();
		if ($key !== 0) {
			$class .= " hidden";
		}
		echo elgg_view_image_block($icon, $body, array("class" => $class));
	}
	
	echo "</div>";
	
	$configured_projects = array_values($configured_projects);
	
	echo "<div class='widget_group_news_navigator'>";
	foreach ($configured_projects as $key => $group) {
		$class = "";
		if ($key == 0) {
			$class = " class='active'";
		}
		
		echo "<span rel='widget_group_news_" . ($key + 1) . "_" . $group->getGUID() . "'" . $class . ">" . ($key + 1) . "</span>";
	}
	echo "</div>";
} else {
	echo elgg_echo("widgets:group_news:no_projects");
}
	