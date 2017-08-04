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
	 * @param string $hook         'route'
	 * @param string $type         'blog'
	 * @param array  $return_value the current page_handler params
	 * @param null   $params       null
	 *
	 * @return void|false
	 */
	public static function blog($hook, $type, $return_value, $params) {
		
		$page = elgg_extract('segments', $return_value);
		if (empty($page)) {
			return;
		}
		
		$include_file = false;
		$resouce_loaded = false;
		$pages_path = elgg_get_plugins_path() . 'blog_tools/pages/';
		
		switch ($page[0]) {
			case 'read': // Elgg 1.7 compatibility
			case 'view':
				set_input('guid', $page[1]); // to be used in the blog_tools/full/related view
				break;
			case 'featured':
				$resouce_loaded = true;
				echo elgg_view_resource('blog_tools/blog/featured');
				break;
		}
		
		if (!empty($resouce_loaded)) {
			return false;
		} elseif (!empty($include_file)) {
			include($include_file);
			return false;
		}
	}
}
