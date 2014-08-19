<?php 
/* init file for widget */

function widget_messages_init(){
	if(elgg_is_active_plugin("messages")){
		elgg_register_widget_type("messages", elgg_echo("messages"), elgg_echo("widgets:messages:description"), "dashboard,index", false);
		
		elgg_register_plugin_hook_handler('widget_url', 'widget_manager', "widget_messages_url");
	}
}

function widget_messages_url($hook_name, $entity_type, $return_value, $params){
	$result = $return_value;
	$widget = $params["entity"];
	if(empty($result) && ($widget instanceof ElggWidget) && $widget->handler == "messages"){
		if($user = elgg_get_logged_in_user_entity()){
			$result = "/messages/inbox/" . $user->username;
		}
	}
	return $result;
}

elgg_register_event_handler("widgets_init", "widget_manager", "widget_messages_init");