<?php 
/* init file for twitter_search widget */

function widget_twitter_search_init(){
	elgg_register_widget_type("twitter_search", elgg_echo("widgets:twitter_search:name"), elgg_echo("widgets:twitter_search:description"), "profile,dashboard,index,groups", true);
	elgg_extend_view("css/elgg", "widgets/twitter_search/css");
}

elgg_register_event_handler("widgets_init", "widget_manager", "widget_twitter_search_init");
