<?php

namespace ColdTrick\TranslationEditor;

/**
 * Add menu items to the site menu
 *
 * @package    ColdTrick
 * @subpackage TranslationEditor
 */
class TitleMenu {
	
	/**
	 * Add menu items to the title menu
	 *
	 * @param string          $hook   the name of the hook
	 * @param string          $type   the type of the hook
	 * @param \ElggMenuItem[] $return current menu items
	 * @param array           $params provided params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function register($hook, $type, $return, $params) {
		if (!elgg_in_context('translation_editor')) {
			return;
		}
			
		$current_language = get_input('current_language');
		$plugin_id = get_input('plugin_id');
		
		// show import/export buttons only on language page (not on plugins)
		if (elgg_is_admin_logged_in() && $current_language && empty($plugin_id)) {
			$return[] = \ElggMenuItem::factory([
				'name' => 'translation-editor-import',
				'text' => elgg_echo('import'),
				'href' => "translation_editor/import/{$current_language}",
				'link_class' => 'elgg-button elgg-button-action',
				'priority' => 210,
			]);
			$return[] = \ElggMenuItem::factory([
				'name' => 'translation-editor-export',
				'text' => elgg_echo('export'),
				'href' => "translation_editor/export/{$current_language}",
				'link_class' => 'elgg-button elgg-button-action',
				'priority' => 220,
			]);
		}
		
		// download button only on plugin page
		if (!empty($plugin_id)) {
			$return[] = \ElggMenuItem::factory([
				'name' => 'translation-editor-merge',
				'text' => elgg_echo('download'),
				'title' => elgg_echo('translation_editor:plugin_list:merge'),
				'href' => "action/translation_editor/merge?current_language={$current_language}&plugin={$plugin_id}",
				'link_class' => 'elgg-button elgg-button-action',
				'priority' => 300,
				'is_action' => true,
			]);
		}
		
		return $return;
	}
	
	/**
	 * Add language selector menu items to the title menu
	 *
	 * @param string          $hook   the name of the hook
	 * @param string          $type   the type of the hook
	 * @param \ElggMenuItem[] $return current menu items
	 * @param array           $params provided params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerLanguageSelector($hook, $type, $return, $params) {
		if (!elgg_in_context('translation_editor')) {
			return;
		}
		
		// language selector
		$return[] = \ElggMenuItem::factory([
			'name' => 'translation-editor-show-language-selector',
			'text' => elgg_echo('translation_editor:show_language_selector'),
			'href' => '#',
			'link_class' => 'elgg-button elgg-button-action',
			'priority' => 200,
			'rel' => 'toggle',
			'data-toggle-selector' => '#translation-editor-language-selection, .elgg-menu-title li[class*="language-selector"] a',
			'data-toggle-slide' => 0,
		]);
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'translation-editor-hide-language-selector',
			'text' => elgg_echo('translation_editor:hide_language_selector'),
			'href' => '#',
			'link_class' => 'elgg-button elgg-button-action',
			'priority' => 201,
			'style' => 'display: none;', // needed to prevent misallignment
			'rel' => 'toggle',
			'data-toggle-selector' => '#translation-editor-language-selection, .elgg-menu-title li[class*="language-selector"] a',
			'data-toggle-slide' => 0,
		]);

		return $return;
	}
}
