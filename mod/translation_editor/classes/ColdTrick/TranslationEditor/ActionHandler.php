<?php

namespace ColdTrick\TranslationEditor;

/**
 * Listen to some actions
 *
 * @package    ColdTrick
 * @subpackage TranslationEditor
 */
class ActionHandler {
	
	/**
	 * Listen to some plugin actions in order to reset the translation files
	 *
	 * @param string $hook   'action'
	 * @param string $type   different plugin related actions
	 * @param bool   $return true, return false to stop the action
	 * @param null   $params no params
	 *
	 * @return void
	 */
	public static function invalidateCache($hook, $type, $return, $params) {
		
		// invalidate site cache
		translation_editor_invalidate_site_cache();
	}
}