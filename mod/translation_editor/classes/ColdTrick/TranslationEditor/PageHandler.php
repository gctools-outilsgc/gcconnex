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
	 * @param array $segments the url elements
	 *
	 * @return bool
	 */
	public static function translationEditor($segments) {

		$page = array_shift($segments);
		switch ($page) {
			case 'search':
				echo elgg_view_resource('translation_editor/search');
				return true;
			case 'import':
			case 'export':
				$current_language = array_shift($segments);
				set_input('current_language', $current_language);
				
				echo elgg_view_resource("translation_editor/{$page}", [
					'current_language' => $current_language,
				]);
				return true;
			default:
				if (empty($page)) {
					$language = get_current_language();
					$plugin_id = null;
				} else {
					$language = $page;
					$plugin_id = array_shift($segments);
					set_input('current_language', $language);
					set_input('plugin', $plugin_id);
				}

				echo elgg_view_resource('translation_editor/index', [
					'current_language' => $language,
					'plugin_id' => $plugin_id,
				]);
				return true;
		}
	}

}
