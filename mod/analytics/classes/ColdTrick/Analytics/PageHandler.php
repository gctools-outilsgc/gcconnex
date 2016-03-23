<?php

namespace ColdTrick\Analytics;

class PageHandler {
	
	/**
	 * Handler /analytics
	 *
	 * @param array $page url segments
	 *
	 * @return bool
	 */
	public static function analytics($page) {
		
		$include_file = false;
		$pages_path = elgg_get_plugins_path() . 'analytics/pages/';
		
		switch ($page[0]) {
			case 'ajax_success':
				$include_file = "{$pages_path}ajax_success.php";
				break;
		}
		
		if (!empty($include_file)) {
			include($include_file);
			return true;
		}
		
		return false;
	}
}
