<?php
/**
 * display the search results
 */

translation_editor_gatekeeper();

elgg_require_js('translation_editor/edit');

// get inputs
$q = get_input('q');
if (empty($q)) {
	forward(REFERER);
}

$language = get_input('language', 'en');

$found = translation_editor_search_translation($q, $language);
$trans = get_installed_translations();

if (!array_key_exists($language, $trans)) {
	forward('translation_editor');
}

$trans_lan = elgg_echo($language);
if (elgg_language_key_exists($language, $language)) {
	$trans_lan = elgg_echo($language, [], $language);
}

$title_text = elgg_echo('translation_editor:search', [$q, $trans_lan]);

// breadcrumb
elgg_push_breadcrumb(elgg_echo('translation_editor:menu:title'), 'translation_editor');
elgg_push_breadcrumb($trans_lan, "translation_editor/{$language}");

// build page elements

// build search form
$form_vars = [
	'id' => 'translation_editor_search_form',
	'action' => 'translation_editor/search',
	'disable_security' => true,
	'class' => 'mbl',
	'method' => 'GET',
];
$body_vars = [
	'current_language' => $language,
	'query' => $q,
];
$body = elgg_view_form('translation_editor/search', $form_vars, $body_vars);

// display search results
if (!empty($found)) {

	$body_vars = [
		'results' => $found,
		'current_language' => $language,
	];
	$body .= elgg_view('translation_editor/search_results', $body_vars);
} else {
	$body .= elgg_view('output/longtext', [
		'value' => elgg_echo('translation_editor:search_results:no_results')
	]);
}

// Build page
$page_data = elgg_view_layout('one_column', [
	'title' => $title_text,
	'content' => $body,
]);

echo elgg_view_page($title_text, $page_data);
