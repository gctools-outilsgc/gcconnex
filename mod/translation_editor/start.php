<?php
/**
 * The main file for this plugin
 */

define('TRANSLATION_EDITOR_DISABLED_LANGUAGE', 'disabled_languages');

require_once(dirname(__FILE__) . '/lib/functions.php');

// plugin init
elgg_register_event_handler('plugins_boot', 'system', 'translation_editor_plugins_boot_event', 50); // before normal execution to prevent conflicts with plugins like language_selector
elgg_register_event_handler('init', 'system', 'translation_editor_init');

/**
 * This function is executed during the 'plugins_boot' event, before most plugins are initialized
 *
 * @return void
 */
function translation_editor_plugins_boot_event() {
	
	// add the custom_keys_locations to language paths
	$custom_keys_path = elgg_get_data_path() . 'translation_editor' . DIRECTORY_SEPARATOR . 'custom_keys' . DIRECTORY_SEPARATOR;
	if (is_dir($custom_keys_path)) {
		register_translations($custom_keys_path);
	}
	
	// force creation of static to prevent reload of unwanted translations
	reload_all_translations();
	
	if (elgg_in_context('translation_editor') || elgg_in_context('settings') || elgg_in_context('admin')) {
		translation_editor_reload_all_translations();
	}
	
	translation_editor_load_custom_languages();
	
	if (!elgg_in_context('translation_editor')) {
		// remove disabled languages
		translation_editor_unregister_translations();
	}
	
	// load custom translations
	$user_language = get_current_language();
	$elgg_default_language = 'en';
	
	$load_languages = [
		$user_language,
		$elgg_default_language,
	];
	$load_languages = array_unique($load_languages);
	
	$disabled_languages = translation_editor_get_disabled_languages();
	
	foreach ($load_languages as $language) {
		if (empty($disabled_languages) || !in_array($language, $disabled_languages)) {
			// add custom translations
			translation_editor_load_translations($language);
		}
	}
}

/**
 * This function is executed during the 'init' event, when all plugin are initialized
 *
 * @return void
 */
function translation_editor_init() {
	
	// extend JS/CSS
	elgg_extend_view('css/elgg', 'css/translation_editor/site.css');
	elgg_extend_view('js/elgg', 'js/translation_editor/site.js');
	
	elgg_register_page_handler('translation_editor', '\ColdTrick\TranslationEditor\PageHandler::translationEditor');
	
	// register hooks
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', '\ColdTrick\TranslationEditor\UserHoverMenu::register');
	elgg_register_plugin_hook_handler('register', 'menu:page', '\ColdTrick\TranslationEditor\PageMenu::register');
	elgg_register_plugin_hook_handler('register', 'menu:site', '\ColdTrick\TranslationEditor\SiteMenu::register');
	elgg_register_plugin_hook_handler('register', 'menu:title', '\ColdTrick\TranslationEditor\TitleMenu::register');
	
	// register events
	elgg_register_event_handler('cache:flush', 'system', '\ColdTrick\TranslationEditor\CacheHandler::resetTranslationCache');
	elgg_register_event_handler('upgrade', 'system', '\ColdTrick\TranslationEditor\Upgrade::cleanupCustomTranslations');
	
	// Register actions
	elgg_register_action('translation_editor/translate', dirname(__FILE__) . '/actions/translate.php');
	elgg_register_action('translation_editor/merge', dirname(__FILE__) . '/actions/merge.php');
	elgg_register_action('translation_editor/remove_cleanup', dirname(__FILE__) . '/actions/cleanup/remove.php');
	elgg_register_action('translation_editor/download_cleanup', dirname(__FILE__) . '/actions/cleanup/download.php');
	
	// Admin only actions
	elgg_register_action('translation_editor/make_translation_editor', dirname(__FILE__) . '/actions/make_translation_editor.php', 'admin');
	elgg_register_action('translation_editor/unmake_translation_editor', dirname(__FILE__) . '/actions/unmake_translation_editor.php', 'admin');
	elgg_register_action('translation_editor/delete', dirname(__FILE__) . '/actions/delete.php', 'admin');
	elgg_register_action('translation_editor/disable_languages', dirname(__FILE__) . '/actions/disable_languages.php', 'admin');
	elgg_register_action('translation_editor/add_language', dirname(__FILE__) . '/actions/add_language.php', 'admin');
	elgg_register_action('translation_editor/add_custom_key', dirname(__FILE__) . '/actions/add_custom_key.php', 'admin');
	elgg_register_action('translation_editor/delete_language', dirname(__FILE__) . '/actions/delete_language.php', 'admin');
	elgg_register_action('translation_editor/import', dirname(__FILE__) . '/actions/import.php', 'admin');
	elgg_register_action('translation_editor/export', dirname(__FILE__) . '/actions/export.php', 'admin');
}
