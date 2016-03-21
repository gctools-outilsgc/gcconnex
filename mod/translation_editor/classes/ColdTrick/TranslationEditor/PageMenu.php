<?php

namespace ColdTrick\TranslationEditor;

/**
 * Add menu items to the page menu
 *
 * @package    ColdTrick
 * @subpackage TranslationEditor
 */
class PageMenu {
	
	/**
	 * Add menu items to the page menu
	 *
	 * @param string          $hook   the name of the hook
	 * @param string          $type   the type of the hook
	 * @param \ElggMenuItem[] $return current menu items
	 * @param array           $params provided params
	 *
	 * @return \ElggMenuItem[]
	 */
	public static function register($hook, $type, $return, $params) {
		
		if (!elgg_is_admin_logged_in()) {
			return $return;
		}
		
		if (!elgg_in_context("admin")) {
			return $return;
		}
		
		$return[] = \ElggMenuItem::factory(array(
			"name" => "translation_editor",
			"href" => "translation_editor",
			"text" => elgg_echo("translation_editor:menu:title"),
			"parent_name" => "appearance",
			"section" => "configure"
		));
		
		return $return;
	}
}