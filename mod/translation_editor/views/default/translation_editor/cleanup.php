<?php
/**
 * Show a notification to the editor that some custom translations were cleaned
 */

$current_translation = elgg_extract('current_language', $vars);

$file_name = elgg_get_data_path() . 'translation_editor' . DIRECTORY_SEPARATOR . $current_translation . DIRECTORY_SEPARATOR . 'translation_editor_cleanup.json';
if (!file_exists($file_name)) {
	// nothing was cleaned up
	return;
}

$content = file_get_contents($file_name);
$cleaned = json_decode($content, true);
$count = 0;
foreach ($cleaned as $plugin_id => $removed_translations){
	$count += count($removed_translations);
}

$download = elgg_view('output/url', [
	'text' => elgg_echo('download'),
	'href' => "action/translation_editor/download_cleanup?language={$current_translation}",
	'is_action' => true,
	'class' => 'elgg-button elgg-button-action float-alt',
]);

$remove = elgg_view('output/url', [
	'text' => strtolower(elgg_echo('delete')),
	'href' => "action/translation_editor/remove_cleanup?language={$current_translation}",
	'is_action' => true,
	'confirm' => elgg_echo('deleteconfirm'),
]);

$content = elgg_format_element('div', [
	'class' => 'elgg-output mtn',
], elgg_echo('translation_editor:cleanup:description', [$count, $remove]));

echo elgg_format_element('div', [
	'class' => 'elgg-message elgg-state-notice mbm ptm pbl translation-editor-cleanup',
], $download . $content);
