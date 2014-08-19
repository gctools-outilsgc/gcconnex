<?php 
/* init file for free_html widget */

function widget_free_html_init(){
	elgg_register_widget_type("free_html", elgg_echo("widgets:free_html:title"), elgg_echo("widgets:free_html:description"), "groups,index,dashboard,profile", true);
}

elgg_register_event_handler("widgets_init", "widget_manager", "widget_free_html_init");