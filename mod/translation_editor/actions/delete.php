<?php
/**
 * Delete the custom translations for the provided plugin
 */

$lang = get_input("current_language");
$plugin = get_input("plugin");

if (empty($lang) || empty($plugin)) {
	register_error(elgg_echo("translation_editor:action:delete:error:input"));
	forward(REFERER);
}

if (translation_editor_delete_translation($lang, $plugin)) {
	// merge translations
	translation_editor_merge_translations($lang, true);
	
	system_message(elgg_echo("translation_editor:action:delete:success"));
} else {
	register_error(elgg_echo("translation_editor:action:delete:error:delete"));
}

forward("translation_editor/" . $lang);
