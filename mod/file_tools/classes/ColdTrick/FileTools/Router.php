<?php

namespace ColdTrick\FileTools;

class Router {
	
	/**
	 * Listen to the /file pagehandler
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|false
	 */
	public static function file($hook, $type, $return_value, $params) {
		
		$page = elgg_extract('segments', $return_value, []);
		
		switch (elgg_extract(0, $page)) {
			case 'owner':
				if (file_tools_use_folder_structure()) {
					echo elgg_view_resource('file_tools/file/list');
					return false;
				}
				break;
			case 'group':
				if (file_tools_use_folder_structure()) {
					echo elgg_view_resource('file_tools/file/list');
					return false;
				}
				break;
			case 'bulk_download':
				echo elgg_view_resource('file_tools/file/bulk_download');
				return false;
				break;
		}
	}
}
