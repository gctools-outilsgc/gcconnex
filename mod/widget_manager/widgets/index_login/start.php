<?php 
/* init file for index_login widget */

function widget_index_login_init(){
	elgg_register_widget_type("index_login", elgg_echo("login"), elgg_echo("widget_manager:widgets:index_login:description"), "index");	
}

elgg_register_event_handler("widgets_init", "widget_manager", "widget_index_login_init");