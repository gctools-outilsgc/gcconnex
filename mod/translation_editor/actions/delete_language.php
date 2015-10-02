<?php
/**
 * Delete a custom added language
 */

$language = get_input("language");
if (empty($language) || ($language === "en")) {
	forward(REFERER);
}

// only remove untranslated languages
$completeness = translation_editor_get_language_completeness($language);
if ($completeness !== (float) 0) {
	forward(REFERER);
}

// get all the custom languages
$custom_languages = elgg_get_plugin_setting("custom_languages", "translation_editor");
if (empty($custom_languages)) {
	forward(REFERER);
}

$custom_languages = string_to_tag_array($custom_languages);

$index = array_search($language, $custom_languages);
if ($index !== false) {
	unset($custom_languages[$index]);
	
	$code = implode(",", array_unique($custom_languages));

	elgg_set_plugin_setting("custom_languages", $code, "translation_editor");
	system_message(elgg_echo("translation_editor:action:delete_language:success"));
}

forward(REFERER);
