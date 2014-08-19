<?php 
/* init file for index_members widget */

function widget_index_members_init(){
	elgg_register_widget_type("index_members", elgg_echo("widget_manager:widgets:index_members:name"), elgg_echo("widget_manager:widgets:index_members:description"), "index", true);
	elgg_register_plugin_hook_handler('widget_url', 'widget_manager', "widget_index_members_url");
}

function widget_index_members_url($hook_name, $entity_type, $return_value, $params){
	$result = $return_value;
	$widget = $params["entity"];
	if(empty($result) && ($widget instanceof ElggWidget) && $widget->handler == "index_members"){
		if(elgg_is_active_plugin("members")){
			$result = "/members";
		}
	}
	return $result;
}

elgg_register_event_handler("widgets_init", "widget_manager", "widget_index_members_init");
