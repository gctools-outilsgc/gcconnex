<?php
/**
 * Add translations for the current plugin
 */
global $CONFIG;

// make sure all languages are loaded
translation_editor_reload_all_translations();

// Fixes for KSES filtering
// fix to allow javascript in href
$CONFIG->allowedprotocols[] = 'javascript';

// fix allowed tags
$CONFIG->allowedtags['a']['onclick'] = array();
$CONFIG->allowedtags['span']['id'] = array();

$translation = get_input('translation');

if (!translation_editor_is_translation_editor()) {
	register_error(elgg_echo('translation_editor:action:translate:error:not_authorized'));
	forward();
}

if (!is_array($translation)) {
	register_error(elgg_echo('translation_editor:action:translate:error:input'));
	forward(REFERER);
}

$trans = get_installed_translations();

foreach ($translation as $language => $plugins) {
	
	if (!array_key_exists($language, $trans)) {
		continue;
	}
	
	if (!is_array($plugins)) {
		continue;
	}
	
	foreach ($plugins as $plugin_name => $translate_input) {
		
		if (!is_array($translate_input)) {
			continue;
		}
		
		// get plugin translation
		$plugin_translation = translation_editor_get_plugin($language, $plugin_name);
		
		// merge with existing custom translations
		$custom_translation = elgg_extract('custom', $plugin_translation);
		if (!empty($custom_translation)) {
			$translate_input = array_merge($custom_translation, $translate_input);
		}
		
		// get original plugin keys
		$original_keys = elgg_extract('en', $plugin_translation);
		// only keep keys which are present in the plugin
		$translate_input = array_intersect_key($translate_input, $original_keys);
		
		// check if translated
		$translated = translation_editor_compare_translations($language, $translate_input);
		
		if (!empty($translated)) {
			if (translation_editor_write_translation($language, $plugin_name, $translated)) {
				system_message(elgg_echo('translation_editor:action:translate:success'));
			} else {
				register_error(elgg_echo('translation_editor:action:translate:error:write'));
			}
		} else {
			translation_editor_delete_translation($language, $plugin_name);
			system_message(elgg_echo('translation_editor:action:translate:success'));
		}
	}
	
	// merge translations
	translation_editor_merge_translations($language, true);
}

// invalidate cache
elgg_flush_caches();

forward(REFERER);
