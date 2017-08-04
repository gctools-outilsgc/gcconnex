<?php

namespace ColdTrick\FileTools;

class Groups {
	
	/**
	 * Add the folder management option to groups (if enabled)
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param arary  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function tools($hook, $type, $return_value, $params) {
		
		if (!file_tools_use_folder_structure()) {
			return;
		}
		
		$folder_management = new \stdClass;
		$folder_management->name = 'file_tools_structure_management';
		$folder_management->label = elgg_echo('file_tools:group_tool_option:structure_management');
		$folder_management->default_on = true;
		
		$return_value[] = $folder_management;
		
		return $return_value;
	}
}
