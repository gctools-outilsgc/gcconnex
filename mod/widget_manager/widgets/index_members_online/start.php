<?php 
/* init file for index_members_online widget */

function widget_index_members_online_init(){
	elgg_register_widget_type("index_members_online", elgg_echo("widget_manager:widgets:index_members_online:name"), elgg_echo("widget_manager:widgets:index_members_online:description"), "index", true);
	elgg_register_plugin_hook_handler('widget_url', 'widget_manager', "widget_index_members_online_url");
}

function widget_index_members_online_url($hook_name, $entity_type, $return_value, $params){
	$result = $return_value;
	$widget = $params["entity"];
	if(empty($result) && ($widget instanceof ElggWidget) && $widget->handler == "index_members_online"){
		if(elgg_is_active_plugin("members")){
			$result = "/members";
		}
	}
	return $result;
}

elgg_register_event_handler("widgets_init", "widget_manager", "widget_index_members_online_init");