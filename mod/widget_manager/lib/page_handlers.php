<?php

/**
 * Page handlers for widget manager
 */

/**
 * Handles the multi dashboard page
 *
 * @param array $page page elements
 *
 * @return boolean
 */
function widget_manager_multi_dashboard_page_handler($page) {
	$result = false;
	
	switch ($page[0]) {
		case "edit":
			$result = true;
			
			if (!empty($page[1])) {
				set_input("guid", $page[1]);
			}
			
			include(dirname(dirname(__FILE__)) . "/pages/multi_dashboard/edit.php");
			break;
	}
	
	return $result;
}

/**
 * Handles the extra contexts page
 *
 * @param array  $page    page elements
 * @param string $handler handler of the current page
 * 
 * @return boolean
 */
function widget_manager_extra_contexts_page_handler($page, $handler) {
	$result = false;
	
	$extra_contexts = elgg_get_plugin_setting("extra_contexts", "widget_manager");
	if (widget_manager_is_extra_context($handler)) {
		$result = true;
				
		// make nice lightbox popup title
		add_translation(get_current_language(), array("widget_manager:widgets:lightbox:title:" . strtolower($handler) => $handler));
		
		// backwards compatibility
		set_input("handler", $handler);
		include(dirname(dirname(__FILE__)) . "/pages/extra_contexts.php");
	}
	
	return $result;
}

/**
 * Function to take over the index page
 *
 * @param array  $page    page elements
 * @param string $handler handler of the current page
 * 
 * @return boolean
 */
function widget_manager_index_page_handler($page, $handler) {
	include(elgg_get_plugins_path() . "/widget_manager/pages/custom_index.php");
	return true;
}
