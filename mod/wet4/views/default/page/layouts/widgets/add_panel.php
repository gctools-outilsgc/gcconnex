<?php
$context = $vars["context"];
$show_access = (int) $vars["show_access"];

$params = array(
	'name' => 'widget_context',
	'value' => $context
);

$md_guid = (int) get_input("multi_dashboard_guid");
if (!empty($md_guid)) {
	$params['value'] .= "_" . $md_guid;
}

echo elgg_view('input/hidden', $params);
echo elgg_view('input/hidden', array("name" => "show_access", "value" => $show_access));

if (elgg_is_xhr()) {
	echo "<script>require(['widget_manager/add_panel']);</script>";
} else {
	elgg_require_js("widget_manager/add_panel");
}
	
$widget_context = str_replace("default_", "", $context);

$available_widgets_context = elgg_trigger_plugin_hook("available_widgets_context", "widget_manager", array(), $widget_context);

$widgets = elgg_get_widget_types($available_widgets_context, $vars["exact_match"]);
widget_manager_sort_widgets($widgets);

$current_handlers = array();
if (!empty($vars["widgets"])) {
	// check for already used widgets
	foreach ($vars["widgets"] as $column_widgets) {
		// foreach column
		foreach ($column_widgets as $widget) {
			// for each widgets
			$current_handlers[] = $widget->handler;
		}
	}
}

$title = "<div id='widget_manager_widgets_search'>";
$title .= elgg_view('input/text', [
	'title' => elgg_echo('search'),
	'placeholder' => elgg_echo('widget_manager:filter_widgets'),					// GCconnex patch to clarify the purpose of the text box
	'onkeyup' => 'elgg.widget_manager.widgets_search($(this).val());'
]);
$title .= "</div>";
$title .= elgg_echo("widget_manager:widgets:lightbox:title:" . $context);

$body = "";
if (!empty($widgets)) {
	foreach ($widgets as $handler => $widget) {
		$can_add = widget_manager_get_widget_setting($handler, "can_add", $widget_context);
		$allow_multiple = $widget->multiple;
		$hide = widget_manager_get_widget_setting($handler, "hide", $widget_context);
		
		if ($can_add && !$hide) {
			$body .= "<div class='widget_manager_widgets_lightbox_wrapper clearfix mrgn-bttm-md'>";
			
			if (!$allow_multiple && in_array($handler, $current_handlers)) {
				$class = 'elgg-state-unavailable';
                //changing what the button says to manage the widgets
                $button_value = elgg_echo('widget:remove');
			} else {
				$class = 'elgg-state-available';
                $button_value = elgg_echo("widget_manager:button:add");
			}
			
			if ($allow_multiple) {
				$class .= ' elgg-widget-multiple';
			} else {
				$class .= ' elgg-widget-single';
			}
			
			$body .= "<span class='widget_manager_widgets_lightbox_actions'>";
			$body .= '<ul class="list-unstyled"><li class="' . $class . '" data-elgg-widget-type="' . $handler . '">';
			if (!$allow_multiple) {
				//$body .= "<span class='elgg-quiet'>" . elgg_echo('widget:unavailable') . "</span>";

			}
			$body .= elgg_view("input/button", array("class" => "elgg-button-submit", "value" => $button_value,));
			$body .= "</li></ul>";
			$body .= "</span>";
			
			$description = $widget->description;
			if (empty($description)) {
				$description = "&nbsp;"; // need to fill up for correct layout
			}
			
			$body .= "<div><b>" . $widget->name . "</b></div>";
			$body .= "<div class='elgg-quiet'>" . $description . "</div>";
			
			$body .= "</div>";
		}
	}
} else {
	$body = elgg_echo("notfound");
}

$module_type = "info";
if (elgg_in_context("admin")) {
	$module_type = "inline";
}

echo "<div class='elgg-widgets-add-panel hidden wb-invisible'>" . elgg_view_module($module_type, $title, $body, array("id" => "widget_manager_widgets_select")) . "</div>";
