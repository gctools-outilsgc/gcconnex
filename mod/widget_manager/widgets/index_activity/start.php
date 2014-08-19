<?php 
/* init file for index_activity widget */

function widget_index_activity_init(){
	elgg_register_widget_type("index_activity", elgg_echo("activity"), elgg_echo("widget_manager:widgets:index_activity:description"), "index", true);
	elgg_register_plugin_hook_handler('widget_url', 'widget_manager', "widget_index_activity_url");
}

function widget_index_activity_url($hook_name, $entity_type, $return_value, $params){
	$result = $return_value;
	$widget = $params["entity"];
	if(empty($result) && ($widget instanceof ElggWidget) && $widget->handler == "index_activity"){
		$result = "/activity";
	}
	return $result;
}

elgg_register_event_handler("widgets_init", "widget_manager", "widget_index_activity_init");
