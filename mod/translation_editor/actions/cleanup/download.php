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

$contents = file_get_contents($filename);
$removed = json_decode($contents, true);

$fh = tmpfile();
fputcsv($fh, ['Plugin ID', 'key', 'translation'], ';');

foreach ($removed as $plugin_id => $translations) {
	if (!is_array($translations)) {
		continue;
	}
	
	foreach ($translations as $key => $value) {
		fputcsv($fh, [$plugin_id, $key, $value], ';');
	}
}

// read the csv in to a var before output
$contents = '';
rewind($fh);
while (!feof($fh)) {
	$contents .= fread($fh, 2048);
}

// cleanup the temp file
fclose($fh);

// output the csv
header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=\"translations.csv\"");
header('Content-Length: ' . strlen($contents));

echo $contents;
exit();
