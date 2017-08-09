<?php
/**
 * Widget object
 *
 * @uses $vars['entity']      ElggWidget
 * @uses $vars['show_access'] Show the access control in edit area? (true)
 */

$widget = elgg_extract('entity', $vars);
if (!elgg_instanceof($widget, 'object', 'widget')) {
	return true;
}

if (!($widget instanceof WidgetManagerWidget)) {
	// need this for newly created widgets (elgg_create_widget returns ElggWidget)
	$widget = new \WidgetManagerWidget($widget->toObject());
}

$show_access = elgg_extract('show_access', $vars, true);
elgg_set_config('widget_show_access', $show_access);

$handler = $widget->handler;
if (widget_manager_get_widget_setting($handler, 'hide', $widget->context)) {
	return true;
}

$title = $widget->getTitle();

$widget_title_link = $widget->getURL();
if ($widget_title_link !== elgg_get_site_url()) {
	// only set usable widget titles
	$title = elgg_view('output/url', [
		'href' => $widget_title_link,
		'text' => $title,
		'is_trusted' => true,
		'class' => 'widget-manager-widget-title-link',
	]);
}

$can_edit = $widget->canEdit();

$widget_header = '';
if (($widget->widget_manager_hide_header !== 'yes') || $can_edit) {
	$controls = elgg_view('object/widget/elements/controls', [
		'widget' => $widget,
		'show_edit' => $can_edit,
	]);
		
	$widget_header = "<div class='elgg-widget-handle clearfix'><h3 class='elgg-widget-title'>$title</h3>$controls</div>";
}

$widget_body_vars = [
	'id' => "elgg-widget-content-{$widget->guid}",
	'class' => ['elgg-widget-content'],
];

$fixed_height = sanitize_int($widget->widget_manager_fixed_height, false);
if ($fixed_height) {
	$widget_body_vars['style'] = "height: {$fixed_height}px; overflow-y: auto;";
}

if ($widget->showCollapsed()) {
	$widget_body_vars['class'][] = 'hidden';
}

$widget_body = elgg_format_element('div', $widget_body_vars, elgg_view('object/widget/elements/content', $vars));

$widget_module_vars = [
	'class' => $widget->getClasses(),
	'id' => "elgg-widget-{$widget->guid}",
	'header' => $widget_header,
];

echo elgg_view_module('widget', '', $widget_body, $widget_module_vars);
