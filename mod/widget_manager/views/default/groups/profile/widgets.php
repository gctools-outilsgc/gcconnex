<?php
/**
* Profile widgets/tools
* 
*/ 
	
if(elgg_get_plugin_setting("group_enable", "widget_manager") == "yes" && $vars["entity"]->widget_manager_enable == "yes"){
	$params = array(
				'num_columns' => 2, //GCChange - from['num_columns' => 3] -> to['num_columns' => 2]
				'exact_match' => true
	);
	
	// need context = groups to fix the issue with the new group_profile context
	elgg_push_context("groups");
	echo elgg_view_layout('widgets', $params);
	elgg_pop_context();
} else {
	// traditional view
	
	// tools widget area
	echo '<ul id="groups-tools" class="elgg-gallery elgg-gallery-fluid mtl clearfix">';
	
	// enable tools to extend this area
	echo elgg_view("groups/tool_latest", $vars);
	
	// backward compatibility
	$right = elgg_view('groups/right_column', $vars);
	$left = elgg_view('groups/left_column', $vars);
	if ($right || $left) {
		elgg_deprecated_notice('The views groups/right_column and groups/left_column have been replaced by groups/tool_latest', 1.8);
		echo $left;
		echo $right;
	}
	
	echo "</ul>";
}