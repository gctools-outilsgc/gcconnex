<?php

// don't show content for default widgets
if (elgg_in_context('default_widgets')) {
	return;
}

$widget = elgg_extract('entity', $vars);
if (!elgg_instanceof($widget, 'object', 'widget')) {
	return;
}

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
	$content = elgg_view_deprecated("widgets/$handler/view", $vars, "Widgets use content as the display view", '1.8');
}

$custom_more_title = $widget->widget_manager_custom_more_title;
$custom_more_url = $widget->widget_manager_custom_more_url;

if ($custom_more_title && $custom_more_url) {
	$custom_more_link = elgg_view('output/url', [
		'text' => $custom_more_title,
		'href' => $custom_more_url,
	]);
	$content .= elgg_format_element('span', ['class' => 'elgg-widget-more'], $custom_more_link);
}

echo $content;

if ($cacheable) {
	// store for future use
	$widget->widget_manager_cached_data = $content;
}