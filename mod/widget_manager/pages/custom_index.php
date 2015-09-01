<?php
	
// set context
elgg_push_context('index');

elgg_set_page_owner_guid(elgg_get_site_entity()->getGUID()); // site owns the index widgets

$num_columns = 3;

$layout = elgg_get_plugin_setting("widget_layout", "widget_manager");
if (!empty($layout)) {
	$num_columns = count(explode("|", $layout));
}

$index_top_row = elgg_get_plugin_setting("index_top_row", "widget_manager");
$style = "";
$top_row = "";
$top_row_width = null;
$float = "";

switch ($layout) {
	case "33|33|33":
		$top_row_width = "66.6";
		break;
	case "50|50":
		break;
	default:
		$columns = array_reverse(explode("|", $layout));
		
		foreach ($columns as $index => $col_width) {
			$col_index = $index + 1;
			$style .= "#elgg-widget-col-" . $col_index . " { width: " . $col_width . "%; }";
		}
		
		// determine top row width
		if ($index_top_row == "two_column_left") {
			$top_row_width = 100 - $columns[0];
		}
		break;
}

if ($index_top_row == "full_row" || ($num_columns === 2)) {
	$top_row_width = 100;
} elseif ($index_top_row == "two_column_left") {
	$float = "float: left;";
}

$top_row_used = false;
if (!empty($index_top_row) && ($index_top_row != "none")) {
	$widget_types = elgg_get_widget_types("index", false);
	
	elgg_push_context('widgets');
	$widgets = elgg_get_widgets(elgg_get_page_owner_entity()->getGUID(), "index");
	$widget_content = "";
	
	if (isset($widgets[4])) {
		$column_widgets = $widgets[4];
		if (sizeof($column_widgets) > 0) {
			foreach ($column_widgets as $widget) {
				if (array_key_exists($widget->handler, $widget_types)) {
					$widget_content .= elgg_view_entity($widget, array('show_access' => true));
				}
			}
		}
	}
	
	$top_row = "<div id='elgg-widget-col-4' class='elgg-widgets'>" . $widget_content . "</div>";
	if (elgg_is_admin_logged_in()) {
		$min_height = "min-height: 50px !important;";
	} else {
		$min_height = "min-height: 0px !important;";
	}
	$style .= "#elgg-widget-col-4 { width: " . $top_row_width . "%;" . $min_height . $float . "}";
	elgg_pop_context();
	$top_row_used = true;
}

if ($style) {
	$style = "<style type='text/css'>" . $style . "</style>";
}

// draw the page
$params = array(
		'content' => $top_row,
		'top_row_used' => $top_row_used,
		'num_columns' => $num_columns,
		'exact_match' => true
);
$content = elgg_view_layout('widgets', $params);

$body = elgg_view_layout('one_column', array('content' => $style . $content));

echo elgg_view_page("", $body);
