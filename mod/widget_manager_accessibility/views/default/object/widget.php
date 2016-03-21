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

// @todo catch for disabled plugins
$widget_types = elgg_get_widget_types('all');

$handler = $widget->handler;

$title = $widget->getTitle();

$widget_title_link = $widget->getURL();
if($widget_title_link !== elgg_normalize_url("view/" . $widget->getGUID())){
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
}
$controls = elgg_view('object/widget/elements/controls', array(
	'widget' => $widget,
	'show_edit' => $edit_area != '',
));

// don't show content for default widgets
if (elgg_in_context('default_widgets')) {
	$content = '';
} else {
	if (elgg_view_exists("widgets/$handler/content")) {
		$content = elgg_view("widgets/$handler/content", $vars);
	} else {
		elgg_deprecated_notice("widgets use content as the display view", 1.8);
		$content = elgg_view("widgets/$handler/view", $vars);
	}
}

$widget_id = "elgg-widget-$widget->guid";
$widget_instance = "elgg-widget-instance-$handler";
$widget_class = "elgg-module elgg-module-widget";

if ($can_edit) {
	$widget_class .= " elgg-state-draggable $widget_instance";
} else {
	$widget_class .= " elgg-state-fixed $widget_instance";
}

if($widget->widget_manager_custom_class){
	// optional custom class for this widget
	$widget_class .= " " . $widget->widget_manager_custom_class;
}

if($widget->widget_manager_hide_header == "yes"){
	if(elgg_is_admin_logged_in()){
		$widget_class .= " widget_manager_hide_header_admin";
	} else {
		$widget_class .= " widget_manager_hide_header";
	}
}

if($widget->widget_manager_disable_widget_content_style == "yes"){
	$widget_class .= " widget_manager_disable_widget_content_style";
}

if(($widget->widget_manager_hide_header != "yes") || elgg_is_admin_logged_in()){
	$widget_header = <<<HEADER
		<div class="elgg-widget-handle clearfix"><h3>$title</h3>
		$controls
		</div>
HEADER;
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
	$widget_body_class .= " hidden wet-hidden";
} 
//else $minimized = '';

$widget_body = <<<BODY
	$edit_area
	<div class="$widget_body_class" id="elgg-widget-content-$widget->guid" >
		$content
	</div>
BODY;
echo elgg_view('page/components/module', array(
	'class' => $widget_class,
	'id' => $widget_id,
	'body' => $widget_body,
	'header' => $widget_header,
));