<?php

namespace ColdTrick\TranslationEditor;

/**
 * Add menu items to the site menu
 *
 * @package    ColdTrick
 * @subpackage TranslationEditor
 */
class SiteMenu {
	
	/**
	 * Add menu items to the site menu
	 *
	 * @param string          $hook   the name of the hook
	 * @param string          $type   the type of the hook
	 * @param \ElggMenuItem[] $return current menu items
	 * @param array           $params provided params
	 *
	 * @return \ElggMenuItem[]
	 */
	public static function register($hook, $type, $return, $params) {
		
		if (!translation_editor_is_translation_editor()) {
			return $return;
		}
		
		$return[] = \ElggMenuItem::factory(array(
			"name" => "translation_editor",
			"text" => elgg_echo("translation_editor:menu:title"),
			"href" => "translation_editor"
		));
		
		return $return;
	}
}