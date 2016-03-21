<?php
/**
 * Add translations for the current plugin
 */
global $CONFIG;

// Fixes for KSES filtering
// fix to allow javascript in href
$CONFIG->allowedprotocols[] = "javascript";

// fix allowed tags
$CONFIG->allowedtags["a"]["onclick"] = array();
$CONFIG->allowedtags["span"]["id"] = array();

$translation = get_input("translation");

if (!translation_editor_is_translation_editor()) {
	register_error(elgg_echo("translation_editor:action:translate:error:not_authorized"));
	forward();
}

if (!is_array($translation)) {
	register_error(elgg_echo("translation_editor:action:translate:error:input"));
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
		
		// merge with existing custom translations
		$custom_translation = translation_editor_read_translation($language, $plugin_name);
		if (!empty($custom_translation)) {
			$translate_input = array_merge($custom_translation, $translate_input);
		}
			
		$translated = translation_editor_compare_translations($language, $translate_input);
			
		if (!empty($translated)) {
			if (translation_editor_write_translation($language, $plugin_name, $translated)) {
				system_message(elgg_echo("translation_editor:action:translate:success"));
			} else {
				register_error(elgg_echo("translation_editor:action:translate:error:write"));
			}
		} else {
			translation_editor_delete_translation($language, $plugin_name);
			system_message(elgg_echo("translation_editor:action:translate:success"));
		}
	}
	
	// merge translations
	translation_editor_merge_translations($language, true);
}

forward(REFERER);
