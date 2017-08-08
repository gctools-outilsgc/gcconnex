<?php
/**
 * Exports the custom translations for the selected plugins
 */

$language = get_input('language');

$files = elgg_get_uploaded_files('import');
$import = array_shift($files);
if (!$import || !$import->isValid()) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$json = file_get_contents($import->getPathname());

$translated_language = $language;
if (elgg_language_key_exists($language, $language)) {
	$translated_language = elgg_echo($language, [], $language);
} elseif (elgg_language_key_exists($language)) {
	$translated_language = elgg_echo($language);
}

$data = json_decode($json, true);
if (!array_key_exists($language, $data)) {
	return elgg_error_response(elgg_echo('translation_editor:action:import:incorrect_language', [$translated_language]));
}

$plugins = elgg_extract($language, $data);
if (empty($data[$language]) || !is_array($plugins)) {
	return elgg_error_response(elgg_echo('translation_editor:action:import:no_plugins'));
}

foreach ($plugins as $plugin => $translations) {
	if (empty($translations) || !is_array($translations)) {
		continue;
	}
	
	if (!elgg_get_plugin_from_id($plugin)) {
		continue;
	}
	
	translation_editor_write_translation($language, $plugin, $translations);
}

return elgg_ok_response('', elgg_echo('translation_editor:action:import:success'));
