<?php
/**
 * jQuery call to disable a set of languages
 */


$disabled_languages = get_input("disabled_languages");

if (!empty($disabled_languages)) {
	if (is_array($disabled_languages)) {
		$temp_string = implode(",", $disabled_languages);
	} else {
		$temp_string = $disabled_languages;
	}
	
	elgg_set_plugin_setting(TRANSLATION_EDITOR_DISABLED_LANGUAGE, $temp_string, "translation_editor");
} else {
	elgg_unset_plugin_setting(TRANSLATION_EDITOR_DISABLED_LANGUAGE, "translation_editor");
}
