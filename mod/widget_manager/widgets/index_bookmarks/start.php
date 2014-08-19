<?php 
/* init file for index_bookmarks widget */

function widget_index_bookmarks_init(){
	if(elgg_is_active_plugin("bookmarks")){
		elgg_register_widget_type("index_bookmarks", elgg_echo("bookmarks"), elgg_echo("widget_manager:widgets:index_bookmarks:description"), "index", true);
		elgg_register_plugin_hook_handler('widget_url', 'widget_manager', "widget_index_bookmarks_url");
	}
}

function widget_index_bookmarks_url($hook_name, $entity_type, $return_value, $params){
	$result = $return_value;
	$widget = $params["entity"];
	if(empty($result) && ($widget instanceof ElggWidget) && $widget->handler == "index_bookmarks"){
		$result = "/bookmarks/all";
	}
	return $result;
}

elgg_register_event_handler("widgets_init", "widget_manager", "widget_index_bookmarks_init");