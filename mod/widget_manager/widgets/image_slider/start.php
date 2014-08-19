<?php 
/* init file for image_slider widget */

function widget_image_slider_init(){
	elgg_extend_view("css/elgg", "widgets/image_slider/css");
	elgg_register_widget_type("image_slider", elgg_echo("widget_manager:widgets:image_slider:name"), elgg_echo("widget_manager:widgets:image_slider:description"), "index,groups", true);
}

elgg_register_event_handler("widgets_init", "widget_manager", "widget_image_slider_init");