<?php
/**
 * Import the custom translations for the provided import file
 */

$language = get_input('language');
$plugins = get_input('plugins');

if (empty($language) || empty($plugins)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$export[$language] = [];

foreach ($plugins as $plugin) {
	$export[$language][$plugin] = translation_editor_read_translation($language, $plugin);
}

header('Content-Type: application/json');
header('Content-Length: ' . strlen($export));
header("Content-Disposition: attachment; filename=export_plugins_{$language}.json");

header('Pragma: public');

echo json_encode($export, JSON_PRETTY_PRINT);

exit();
