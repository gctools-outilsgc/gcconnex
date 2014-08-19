<?php
if(!function_exists("add_widget_title_link")){
	/**
	* @deprecated 1.7.  Use elgg_register_plugin_hook_handler("widget_url", "widget_manager")
	*
	* @param $handler
	* @param $link
	*/
	function add_widget_title_link($handler, $link){
		elgg_deprecated_notice("add_widget_title_link() was deprecated by elgg_register_plugin_hook_handler('widget_url', 'widget_manager')", "1.7");
		widget_manager_add_widget_title_link($handler, $link);
	}	
}

/**
* Register a widget title
*
* @deprecated 1.8.  Use elgg_register_plugin_hook_handler("widget_url", "widget_manager")
*
* @param $handler
* @param $link
*/
function widget_manager_add_widget_title_link($handler, $link){
	global $CONFIG;
	elgg_deprecated_notice("widget_manager_add_widget_title_link() was deprecated by elgg_register_plugin_hook_handler('widget_url', 'widget_manager')", "1.8");
	
	if (!empty($handler) && !empty($link)) {
		if (isset($CONFIG->widgets) && isset($CONFIG->widgets->handlers) && isset($CONFIG->widgets->handlers[$handler])) {
			$CONFIG->widgets->handlers[$handler]->link = $link;
		}
	}
}