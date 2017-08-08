<?php

translation_editor_gatekeeper();

$language = get_input('language');
if (empty($language)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$base_path = elgg_get_data_path() . 'translation_editor' . DIRECTORY_SEPARATOR;
$filename = $base_path . $language . DIRECTORY_SEPARATOR . 'translation_editor_cleanup.json';
$filename = sanitise_filepath($filename, false);
if (!file_exists($filename)) {
	register_error(elgg_echo('translation_editor:action:cleanup:remove:error:no_file'));
	forward(REFERER);
}

if (unlink($filename)) {
	system_message(elgg_echo('translation_editor:action:cleanup:remove:success'));
} else {
	register_error(elgg_echo('translation_editor:action:cleanup:remove:error:remove'));
}

forward(REFERER);