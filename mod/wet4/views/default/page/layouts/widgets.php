<?php
/**
 * widgets.php 
 *
 * Elgg widgets layout
 *
 * @package wet4
 * @author GCTools Team
 *
 * @uses $vars['content']          Optional display box at the top of layout
 * @uses $vars['num_columns']      Number of widget columns for this layout (3)
 * @uses $vars['show_add_widgets'] Display the add widgets button and panel (true)
 * @uses $vars['exact_match']      Widgets must match the current context (false)
 * @uses $vars['show_access']      Show the access control (true)
 */

$num_columns = elgg_extract('num_columns', $vars, 3);
$show_add_widgets = elgg_extract('show_add_widgets', $vars, true);
$exact_match = elgg_extract('exact_match', $vars, false);
$show_access = elgg_extract('show_access', $vars, true);

$owner = elgg_get_page_owner_entity();

$context = elgg_get_context();

$available_widgets_context = elgg_trigger_plugin_hook("available_widgets_context", "widget_manager", array(), $context);

$widget_types = elgg_get_widget_types($available_widgets_context);
$md_object = null;

elgg_push_context('widgets');

if ($context == "dashboard" && widget_manager_multi_dashboard_enabled() && !elgg_in_context("admin")) {
	$md_guid = get_input("multi_dashboard_guid");
	
	if (!empty($md_guid)) {
		$md_object = get_entity($md_guid);
		if ($md_object) {
			$md_type = $md_object->getDashboardType();
			if (in_array($md_type, array("iframe", "internal"))) {
				elgg_push_context("iframe_dashboard");
			} else {
				$num_columns = $md_object->getNumColumns();
			}
		}
	}
	
	$options = array(
		"type" => "object",
		"subtype" => MultiDashboard::SUBTYPE,
		"limit" => false,
		"owner_guid" => elgg_get_logged_in_user_guid(),
		"order_by" => "e.time_created ASC"
	);
	
	$md_entities = elgg_get_entities($options);
	echo elgg_view("widget_manager/multi_dashboard/navigation", array("entities" => $md_entities));
}

if (!empty($md_object)) {
	$widgets = $md_object->getWidgets();
} else {
	if (($context == "dashboard") && !elgg_in_context("admin")) {
		// can't use elgg function because it gives all and we only need the widgets not related to a multidashboard entity
		$widgets = widget_manager_get_widgets($owner->guid, $context);
	} else {
		$widgets = elgg_get_widgets($owner->guid, $context);
	}
}

$top_row_used = elgg_extract("top_row_used", $vars);
if ($top_row_used) {
	unset($widgets[4]);
}

echo "<div class='elgg-layout-widgets layout-widgets-" . $context . "'>";

if (elgg_can_edit_widget_layout($context)) {
	if ($show_add_widgets) {
		echo elgg_view('page/layouts/widgets/add_button');
	}
	
	$params = array(
		'widgets' => $widgets,
		'context' => $context,
		'exact_match' => $exact_match,
		'show_access' => $show_access,
	);
	echo elgg_view('page/layouts/widgets/add_panel', $params);
}

if (elgg_in_context("iframe_dashboard")) {
	// undo iframe context
	elgg_pop_context();
	if ($md_object->getDashboardType() == "iframe") {
		$url = $md_object->getIframeUrl();
		$height = $md_object->getIframeHeight();
		
		echo "<iframe src='" . $url . "' style='width: 100%; height: " . $height . "px;'></iframe>";
		
	} elseif ($md_object->getDashboardType() == "internal") {
		$url = $md_object->getInternalUrl();
		
		?>
		<div id='widget-manager-multi-dashboard-internal-content'><?php echo elgg_view('graphics/ajax_loader', array("hidden" => false));?></div>
		<script type="text/javascript">

			$(document).ready(function() {
				$("#widget-manager-multi-dashboard-internal-content").load("<?php echo $url; ?>");
			});

		</script>
		<?php
	}
} else {
	if (empty($widgets) || $context !== "dashboard") {
		echo elgg_extract("content", $vars);
	}
	
	if ($context == "dashboard" && empty($md_object)) {
		// change styling of dashboard, but only for default dashboard
		$dashboard_widget_layout = elgg_get_plugin_setting("dashboard_widget_layout", "widget_manager");
		if (!empty($dashboard_widget_layout) && ($dashboard_widget_layout != "33|33|33")) {
			$style = "";
			$columns = array_reverse(explode("|", $dashboard_widget_layout));
			$num_columns = count($columns);
			
			foreach ($columns as $index => $col_width) {
				$col_index = $index + 1;
				$style .= "#elgg-widget-col-" . $col_index . " { width: " . $col_width . "%; }";
			}
				
			if ($style) {
				echo "<style type='text/css'>" . $style . "</style>";
			}
		}
	}
	
	if ($context == "groups") {
		echo "<div class=\"elgg-col-1of1 elgg-widgets widget-manager-groups-widgets-top-row\" id=\"elgg-widget-col-3\">";
		
		if (isset($widgets[3]) && (sizeof($widgets[3]) > 0)) {
			foreach ($widgets[3] as $widget) {
				if (array_key_exists($widget->handler, $widget_types)) {
					echo elgg_view_entity($widget, array('show_access' => $show_access));
				}
			}
		}
		echo "</div>";
	} elseif (in_array($context, array("index", "dashboard")) || widget_manager_is_extra_context($context)) {
		
		foreach ($widgets as $index => $column) { 
			if ($index > $num_columns) {
				if (!isset($widgets[$num_columns])) {
					$widgets[$num_columns] = array();
				}
				
				// add overflow column widgets to the max column
				$widgets[$num_columns] = array_merge($widgets[$index], $widgets[$num_columns]);
				unset($widgets[$index]);
			}
		}		
	}
	
	$widget_class = "elgg-col-1of{$num_columns}";
	for ($column_index = 1; $column_index <= $num_columns; $column_index++) {
		if (isset($widgets[$column_index])) {
			$column_widgets = $widgets[$column_index];
		} else {
			$column_widgets = array();
		}
	
		echo "<div class=\"$widget_class elgg-widgets\" id=\"elgg-widget-col-$column_index\">";
		if (sizeof($column_widgets) > 0) {
			foreach ($column_widgets as $widget) {
				if (array_key_exists($widget->handler, $widget_types)) {
					echo elgg_view_entity($widget, array('show_access' => $show_access));
				}
			}
		}
		echo "</div>";
	}
}

echo "</div>";

elgg_pop_context();

echo elgg_view('graphics/ajax_loader', array('id' => 'elgg-widget-loader'));
