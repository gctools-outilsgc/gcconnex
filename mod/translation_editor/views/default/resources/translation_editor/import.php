<?php

admin_gatekeeper();

$title_text = elgg_echo('translation_editor:import');

// breadcrumb
elgg_push_breadcrumb(elgg_echo('translation_editor:menu:title'), 'translation_editor');

$current_language = elgg_extract('current_language', $vars);
$translated_language = $current_language;
if (elgg_language_key_exists($current_language, $current_language)) {
	$translated_language = elgg_echo($current_language, [], $current_language);
} elseif (elgg_language_key_exists($current_language)) {
	$translated_language = elgg_echo($current_language);
}
elgg_push_breadcrumb($translated_language, "translation_editor/{$current_language}");

// build search form
$form_vars = [
	'enctype' => 'multipart/form-data',
];

$body_vars = [
	'current_language' => $current_language,
];
$body = elgg_view_form('translation_editor/import', $form_vars, $body_vars);

// Build page
$page_data = elgg_view_layout('one_column', [
	'title' => $title_text,
	'content' => $body,
]);

echo elgg_view_page($title_text, $page_data);
