<?php 
/* init file for widget */

function widget_content_by_tag_init(){
	if(elgg_is_active_plugin("blog") || elgg_is_active_plugin("file") || elgg_is_active_plugin("pages")){
		elgg_register_widget_type("content_by_tag", elgg_echo("widgets:content_by_tag:name"), elgg_echo("widgets:content_by_tag:description"), "profile,dashboard,index,groups", true);
	}
}

elgg_register_event_handler("widgets_init", "widget_manager", "widget_content_by_tag_init");