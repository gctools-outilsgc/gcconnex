<?php

namespace ColdTrick\TranslationEditor;

/**
 * Add menu items to the user_hover menu
 *
 * @package    ColdTrick
 * @subpackage TranslationEditor
 */
class UserHoverMenu {
	
	/**
	 * Add menu items to the usericon dropdown
	 *
	 * @param string          $hook   the name of the hook
	 * @param string          $type   the type of the hook
	 * @param \ElggMenuItem[] $return the current menu items
	 * @param array           $params provided params to see who's dropdown menu we're handling
	 *
	 * @return \ElggMenuItem[]
	 */
	public static function register($hook, $type, $return, $params) {
		
		if (empty($params) || !is_array($params)) {
			// invalid input
			return $return;
		}
		
		if (!elgg_is_admin_logged_in()) {
			// only for admins
			return $return;
		}
		
		$user = elgg_extract("entity", $params);
		if (empty($user) || !elgg_instanceof($user, "user")) {
			// no user
			return $return;
		}
		
		if ($user->isAdmin()) {
			// user is admin, so is already editor
			return $return;
		}
		
		// TODO: replace with a single toggle editor action?
		$is_editor = translation_editor_is_translation_editor($user->getGUID());
		
		$return[] = \ElggMenuItem::factory(array(
			"name" => "translation_editor_make_editor",
			"text" => elgg_echo("translation_editor:action:make_translation_editor"),
			"href" => "action/translation_editor/make_translation_editor?user=" . $user->getGUID(),
			"is_action" => true,
			"section" => "admin",
			"item_class" => $is_editor ? "hidden" : "",
			"priority" => 500
		));
		
		$return[] = \ElggMenuItem::factory(array(
			"name" => "translation_editor_unmake_editor",
			"text" => elgg_echo("translation_editor:action:unmake_translation_editor"),
			"href" => "action/translation_editor/unmake_translation_editor?user=" . $user->getGUID(),
			"is_action" => true,
			"section" => "admin",
			"item_class" => $is_editor ? "" : "hidden",
			"priority" => 501
		));
				
		return $return;
	}
}