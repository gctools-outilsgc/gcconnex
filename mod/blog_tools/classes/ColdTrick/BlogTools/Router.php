<?php

namespace ColdTrick\BlogTools;

/**
 * Router handling
 *
 * @package    ColdTrick
 * @subpackage BlogTools
 */
class Router {
	
	/**
	 * Listen to the blog page handler, to takeover some pages
	 *
	 * @param string $hook         "route"
	 * @param string $type         "blog"
	 * @param array  $return_value the current page_handler params
	 * @param null   $params       null
	 *
	 * @return array|bool
	 */
	public static function blog($hook, $type, $return_value, $params) {
		
		if (empty($return_value) || !is_array($return_value)) {
			// someone else had a route hook
			return $return_value;
		}
		
		$page = elgg_extract("segments", $return_value);
		if (empty($page)) {
			return $return_value;
		}
		
		$pages_path = elgg_get_plugins_path() . "blog_tools/pages/";
		switch ($page[0]) {
			case "owner":
				$user = get_user_by_username($page[1]);
				if (!empty($user)) {
					$return_value = false;
					// push all blogs breadcrumb
					elgg_push_breadcrumb(elgg_echo("blog:blogs"), "blog/all");
					
					set_input("owner_guid", $user->guid);
					include($pages_path . "owner.php");
				}
				break;
			case "read": // Elgg 1.7 compatibility
			case "view":
				if (!elgg_is_logged_in()) {
					$setting = elgg_get_plugin_setting("advanced_gatekeeper", "blog_tools");
					if ($setting != "no") {
						if (isset($page[1]) && !get_entity($page[1])) {
							elgg_gatekeeper();
						}
					}
				}
				
				set_input("guid", $page[1]); // to be used in the blog_tools/full/related view
				break;
			case "add":
			case "edit":
				$return_value = false;
				// push all blogs breadcrumb
				elgg_push_breadcrumb(elgg_echo("blog:blogs"), "blog/all");
				
				set_input("page_type", $page[0]);
				if (isset($page[1])) {
					set_input("guid", $page[1]);
				}
				if (isset($page[2])) {
					set_input("revision", $page[2]);
				}
				
				include($pages_path . "edit.php");
				break;
			case "featured":
				$return_value = false;
				
				include($pages_path . "featured.php");
				break;
		}
		
		return $return_value;
	}
}