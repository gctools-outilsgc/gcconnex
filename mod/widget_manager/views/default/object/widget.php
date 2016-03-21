<?php
/**
 * Widget object
 *
 * @uses $vars['entity']      ElggWidget
 * @uses $vars['show_access'] Show the access control in edit area? (true)
 */

$widget = $vars['entity'];
if (!elgg_instanceof($widget, 'object', 'widget')) {
	return true;
}

$show_access = elgg_extract('show_access', $vars, true);
elgg_set_config("widget_show_access", $show_access);

// @todo catch for disabled plugins
$widget_types = elgg_get_widget_types('all');

$handler = $widget->handler;
$widget_context = $widget->context;

if (widget_manager_get_widget_setting($handler, "hide", $widget_context)) {
	return true;
}

$title = $widget->getTitle();

$widget_title_link = $widget->getURL();
if ($widget_title_link !== elgg_get_site_url()) {
	// only set usable widget titles
	$title = elgg_view("output/url", array("href" => $widget_title_link, "text" => $title, 'is_trusted' => true, "class" => "widget-manager-widget-title-link"));
}

$can_edit = $widget->canEdit();

$controls = elgg_view('object/widget/elements/controls', array(
	'widget' => $widget,
	'show_edit' => $can_edit,
));

// don't show content for default widgets
if (elgg_in_context('default_widgets')) {
	$content = '';
} else {
	$content = elgg_view('object/widget/elements/content', $vars);
}

$widget_id = "elgg-widget-$widget->guid";
$widget_instance = "elgg-widget-instance-$handler";
$widget_class = "elgg-module elgg-module-widget";
$widget_header = "";

if ($can_edit) {
	$widget_class .= " elgg-state-draggable $widget_instance";
} else {
	$widget_class .= " elgg-state-fixed $widget_instance";
}

if ($widget->widget_manager_custom_class) {
	// optional custom class for this widget
	$widget_class .= " " . $widget->widget_manager_custom_class;
}

if ($widget->widget_manager_hide_header == "yes") {
	if ($can_edit) {
		$widget_class .= " widget_manager_hide_header_admin";
	} else {
		$widget_class .= " widget_manager_hide_header";
	}
}

if ($widget->widget_manager_disable_widget_content_style == "yes") {
	$widget_class .= " widget_manager_disable_widget_content_style";
}

if (($widget->widget_manager_hide_header != "yes") || $can_edit) {
	$widget_header = <<<HEADER
		<div class="elgg-widget-handle clearfix"><h3 class="elgg-widget-title">$title</h3>
		$controls
		</div>
HEADER;
}

$fixed_height = sanitize_int($widget->widget_manager_fixed_height, false);

$widget_body_class = "elgg-widget-content";

if ($widget->widget_manager_collapse_disable !== "yes") {
	$widget_is_collapsed = false;
	$widget_is_open = true;
	
	if (elgg_is_logged_in()) {
		$widget_is_collapsed = widget_manager_check_collapsed_state($widget->guid, "widget_state_collapsed");
		$widget_is_open = widget_manager_check_collapsed_state($widget->guid, "widget_state_open");
	}
	if (($widget->widget_manager_collapse_state === "closed" || $widget_is_collapsed) && !$widget_is_open) {
	
		$widget_body_class .= " hidden";
	}

}

$widget_body = "<div class='" . $widget_body_class . "'";
if ($fixed_height) {
	$widget_body .= " style='height: " . $fixed_height . "px; overflow-y: auto;'";
}

$widget_body .= " id='elgg-widget-content-" . $widget->guid . "'>";
$widget_body .= $content;
$widget_body .= "</div>";

echo elgg_view_module('widget', '', $widget_body, array(
		'class' => $widget_class,
		'id' => $widget_id,
		'header' => $widget_header,
));
