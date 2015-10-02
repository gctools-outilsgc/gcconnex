<?php

namespace ColdTrick\TranslationEditor;

/**
 * The pagehandler for nice url's
 *
 * @package    ColdTrick
 * @subpackage TranslationEditor
 */
class PageHandler {
	
	/**
	 * The page handler for the nice url's of this plugin
	 *
	 * @param array $page the url elements
	 *
	 * @return bool
	 */
	public static function translationEditor($page) {
		
		$base_path = elgg_get_plugins_path() . "translation_editor/pages/";
		
		switch ($page[0]) {
			case "search":
				$q = get_input("translation_editor_search");
				if (!empty($q)) {
					include($base_path . "search.php");
					break;
				}
			default:
				if (!empty($page[0])) {
					set_input("current_language", $page[0]);
					if (!empty($page[1])) {
						set_input("plugin", $page[1]);
					}
		
					include($base_path . "index.php");
				} else {
					$current_language = get_current_language();
					forward("translation_editor/" . $current_language);
				}
				break;
		}
		
		return true;
	}
}