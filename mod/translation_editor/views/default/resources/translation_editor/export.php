<?php

admin_gatekeeper();

$title_text = elgg_echo('translation_editor:export');

$current_language = elgg_extract('current_language', $vars);
$translated_language = $current_language;
if (elgg_language_key_exists($current_language, $current_language)) {
	$translated_language = elgg_echo($current_language, [], $current_language);
} elseif (elgg_language_key_exists($current_language)) {
	$translated_language = elgg_echo($current_language);
}

// breadcrumb
elgg_push_breadcrumb(elgg_echo('translation_editor:menu:title'), 'translation_editor');
elgg_push_breadcrumb($translated_language, "translation_editor/{$current_language}");

$plugins = translation_editor_get_plugins($current_language);
$exportable_plugins = [];
foreach ($plugins as $plugin_id => $plugin_stats) {
	
	if (empty($plugin_stats['custom'])) {
		continue;
	}
	$plugin = elgg_get_plugin_from_id($plugin_id);
	if (!($plugin instanceof ElggPlugin)) {
		continue;
	}
	
	$exportable_plugins[$plugin->getFriendlyName()] = $plugin_id;
}

if (empty($exportable_plugins)) {
	$body = elgg_echo('translation_editor:export:no_plugins');
} else {
	$body_vars = [
		'current_language' => $current_language,
		'exportable_plugins' => $exportable_plugins,
	];
	$body = elgg_view_form('translation_editor/export', [], $body_vars);
}

// Build page
$page_data = elgg_view_layout('one_column', [
	'title' => $title_text,
	'content' => $body,
]);

echo elgg_view_page($title_text, $page_data);
