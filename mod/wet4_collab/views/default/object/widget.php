<?php
/**
 * Widget object
 *
 * @uses $vars['entity']      ElggWidget
 * @uses $vars['show_access'] Show the access control in edit area? (true)
 * @uses $vars['class']       Optional additional CSS class
 *
 * GC_MODIFICATION
 * Description: widget accessibility changes
 * Author: Nick github.com/piet0024
 */

$widget = $vars['entity'];
if (!elgg_instanceof($widget, 'object', 'widget')) {
	return true;
}

$show_access = elgg_extract('show_access', $vars, true);

// @todo catch for disabled plugins
$widget_types = elgg_get_widget_types('all');

$handler = $widget->handler;

$title = $widget->getTitle();

// cyu - this file is overwriting the original file (.../mod/widget_manager/views/default/object/widget.php)
// missing following code snippet where widget title gets the URL
$widget_title_link = $widget->getURL();

/* MW - Fixes broken URL in Event Calendar widget */
if ($widget->handler == "event_calendar" && strpos( $widget_title_link, "/owner/group:" ) !== false) {
	$widget_title_link = str_replace("/owner/group:", "/group/", $widget_title_link);
}

if ($widget_title_link !== elgg_get_site_url()) {
	// only set usable widget titles
	$title = elgg_view("output/url", array("href" => $widget_title_link, "text" => $title, 'is_trusted' => true, "class" => "widget-manager-widget-title-link"));
}


$edit_area = '';
$can_edit = $widget->canEdit();
if ($can_edit) {
	$edit_area = elgg_view('object/widget/elements/settings', array(
		'widget' => $widget,
		'show_access' => $show_access,
	));
//don't make a list if the user can't edit the widget, this would make empty links for users who can't edit the widget, and its visually unappealing 
$controls = elgg_view('object/widget/elements/controls', array(
	'widget' => $widget,
	'show_edit' => $edit_area != '',
));
}
$content = elgg_view('object/widget/elements/content', $vars);

$widget_id = "elgg-widget-$widget->guid";
$widget_instance = preg_replace('/[^a-z0-9-]/i', '-', "elgg-widget-instance-$handler");
if ($can_edit) {
	$widget_class = "elgg-state-draggable $widget_instance";
    $aria_dnd = 'false'; //allows for accessible drag and drop aria control
    $aria_draggable = 'true';
    $tabindex = '0';
} else {
	$widget_class = "elgg-state-fixed $widget_instance";
    $aria_dnd ='';
    $aria_dnd = '';
    $tabindex = '';
}

$additional_class = elgg_extract('class', $vars, '');
if ($additional_class) {
	$widget_class = "$widget_class $additional_class";
}

// check if the widget is collapsed
$widget_body_class = "elgg-widget-content";
$widget_is_collapsed = false;
$widget_is_open = true;

if (elgg_is_logged_in()) {
    $widget_is_collapsed = widget_manager_check_collapsed_state($widget->guid, "widget_state_collapsed");
    $widget_is_open = widget_manager_check_collapsed_state($widget->guid, "widget_state_open");
}
/*
if (($widget->widget_manager_collapse_state === "closed" || $widget_is_collapsed) && !$widget_is_open) {
//$item->addLinkClass("elgg-widget-collapsed");
$widget_body_class .= " hidden wet-hidden";
}*/
// set collapsed
//it's not even taking this file :|
if ( $widget_is_collapsed && !$widget_is_open ){	// using the same relationship names, etc as in widget manager 5.0
    //	$minimized = 'style="display:none;"';
	$widget_body_class .= "  wet-hidden";
    $widget_head_class ="wet-collapsed";
}else{
    $widget_head_class = "wet-open";
}

$widget_header = <<<HEADER
	<div class="elgg-widget-handle clearfix $widget_head_class"><h3 class="elgg-widget-title pull-left">$title</h3>
	$controls
	</div>
HEADER;

$widget_body = <<<BODY
	$edit_area
	<div class="elgg-widget-content $widget_body_class" id="elgg-widget-content-$widget->guid">
		$content
	</div>
BODY;

echo elgg_view_module('widget', '', $widget_body, array(
	'class' => $widget_class,
	'id' => $widget_id,
	'header' => $widget_header,
    'aria-grabbed' => $aria_dnd,
    'draggable' => $aria_draggable,
    'tabindex' => $tabindex,
));
