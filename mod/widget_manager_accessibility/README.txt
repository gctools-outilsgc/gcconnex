
Accessibility / Usability issues addressed:
		(Github #22, #23, #68, #34, #71, #76, #69)

Overrides:
 functions from file js/lib/ui.widgets.js:
	elgg.ui.widgets.init
	elgg.ui.widgets.add
	elgg.ui.widgets.remove

 View:
 	page/layouts/widgets/add_button.php
 	page/layouts/widgets/add_panel.php


#34:
Requires removal of lines 30 in js/lib/ui.widget.js core:
$('a.elgg-widget-collapse-button').live('click', elgg.ui.widgets.collapseToggle);

Also requires patch to engine/lib/navigation.php:

function widget_check_collapsed_state($widget_guid, $state) {
	static $collapsed_widgets_state;
	$user_guid = elgg_get_logged_in_user_guid();
	//return $widget_guid;
	if (empty($user_guid)) {
	return false;
	}
	
	if (!isset($collapsed_widgets_state)) {
	$collapsed_widgets_state = array();
	$dbprefix = elgg_get_config("dbprefix");
	
	$query = "SELECT * FROM {$dbprefix}entity_relationships WHERE guid_one = $user_guid AND relationship IN ('widget_state_collapsed', 'widget_state_open')";
	$result = get_data($query);
	$i=0;
	if ($result) {
	foreach ($result as $row) {
	if (!isset($collapsed_widgets_state[$row->guid_two])) {
	$collapsed_widgets_state[$row->guid_two] = array();
	}
	$collapsed_widgets_state[$row->guid_two][] = $row->relationship;
	$ids[$i++] = $row->guid_two;
	}
	}
	}
	
	if (!array_key_exists($widget_guid, $collapsed_widgets_state)) {
	return -1;
	}
	
	if (in_array($state, $collapsed_widgets_state[$widget_guid])) {
	return true;
	}
	
	return false;
}
/**
* Widget menu is a set of widget controls
* @access private
*/
function elgg_widget_menu_setup($hook, $type, $return, $params) {
-
+// For Widget Manager collapse state storage function from elgg1.9 version of Widget Manager
+$widget_is_collapsed = false;
+$widget_is_open = true;
+	
$widget = $params['entity'];
+
+if (elgg_is_logged_in()) {
+	$widget_is_collapsed = widget_check_collapsed_state($widget->guid, "widget_state_collapsed");
+	$widget_is_open = widget_check_collapsed_state($widget->guid, "widget_state_open");
+}
+if ( $widget_is_collapsed && !$widget_is_open ) $collapse_class = "elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed";
+else $collapse_class = "elgg-widget-collapse-button";
+
+	
/* @var ElggWidget $widget */
$show_edit = elgg_extract('show_edit', $params, true);
@@ -449,7 +497,7 @@ function elgg_widget_menu_setup($hook, $type, $return, $params) {
'name' => 'collapse',
'text' => ' ',
'href' => "#elgg-widget-content-$widget->guid",
-	'class' => 'elgg-widget-collapse-button',
+	'class' => $collapse_class,
'rel' => 'toggle',
'priority' => 1
);
