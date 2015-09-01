<?php

$widget = elgg_extract('entity', $vars);
$handler = $widget->handler;
$cacheable = widget_manager_is_cacheable_widget($widget);

if ($cacheable) {
	$cached_data = $widget->widget_manager_cached_data;
	if (!empty($cached_data)) {
		echo $cached_data;
		return;
	}
}

if (elgg_view_exists("widgets/$handler/content")) {
	$content = elgg_view("widgets/$handler/content", $vars);
} else {
	elgg_deprecated_notice("widgets use content as the display view", 1.8);
	$content = elgg_view("widgets/$handler/view", $vars);
}

$custom_more_title = $widget->widget_manager_custom_more_title;
$custom_more_url = $widget->widget_manager_custom_more_url;

if ($custom_more_title && $custom_more_url) {
	$custom_more_link = elgg_view("output/url", array(
		"text" => $custom_more_title,
		"href" => $custom_more_url
	));
	$content .= "<span class='elgg-widget-more'>" . $custom_more_link . "</span>";
}

echo $content;

if ($cacheable) {
	// store for future use
	$widget->widget_manager_cached_data = $content;
}