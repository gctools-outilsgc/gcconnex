<?php

namespace ColdTrick\WidgetManager;

class PageHandlers {
	
	/**
	 * Handles the extra contexts page
	 *
	 * @param array  $page    page elements
	 * @param string $handler handler of the current page
	 *
	 * @return boolean
	 */
	public static function extraContexts($page, $handler) {
	
		if (!widget_manager_is_extra_context($handler)) {
			return false;
		}
	
		echo elgg_view_resource('widget_manager/extra_contexts', ['handler' => $handler]);
		return true;
	}
	
	/**
	 * Function to take over the index page
	 *
	 * @param array  $page    page elements
	 * @param string $handler handler of the current page
	 *
	 * @return boolean
	 */
	public static function index($page, $handler) {
		echo elgg_view_resource('widget_manager/custom_index');
		return true;
	}
}