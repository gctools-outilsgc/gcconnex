<?php
/**
 * Get an overview of the translations, eighter a listing off all plugins or an overview of the available keys in a plugin
 */

translation_editor_gatekeeper();

elgg_require_js('translation_editor/edit');

// Get inputs
$current_language = elgg_extract('current_language', $vars, get_current_language());
$plugin = elgg_extract('plugin_id', $vars);

$translations = get_installed_translations();
if (!(array_key_exists($current_language, $translations))) {
	forward('translation_editor');
}

// Build elements
$title_text = elgg_echo('translation_editor:menu:title');

// breadcrumb
elgg_push_breadcrumb($title_text, 'translation_editor');

// add current language to breadcrumb
$translated_language = $current_language;
if (elgg_language_key_exists($current_language, $current_language)) {
	$translated_language = elgg_echo($current_language, [], $current_language);
} elseif (elgg_language_key_exists($current_language)) {
	$translated_language = elgg_echo($current_language);
}
elgg_push_breadcrumb($translated_language, "translation_editor/{$current_language}");
set_input('current_language', $current_language);

// build page elements
$languages = array_keys($translations);

$disabled_languages = translation_editor_get_disabled_languages() ?: [];
$site_language = elgg_get_config('language') ?: 'en';

$body = elgg_view('translation_editor/language_selector', [
	'current_language' => $current_language,
	'plugin' => $plugin,
	'languages' => $languages,
	'disabled_languages' => $disabled_languages,
	'site_language' => $site_language
]);

if (empty($plugin)) {
	// show plugin list
	$plugins = translation_editor_get_plugins($current_language);
	
	$form_vars = [
		'id' => 'translation_editor_search_form',
		'action' => 'translation_editor/search',
		'disable_security' => true,
		'class' => 'mbl',
		'method' => 'GET',
	];
	$body_vars  = [
		'current_language' => $current_language,
	];
	$body .= elgg_view_form('translation_editor/search', $form_vars, $body_vars);
	
	$body .= elgg_view('translation_editor/cleanup', [
		'current_language' => $current_language,
	]);
	
	$body .= elgg_view('translation_editor/plugin_list', [
		'plugins' => $plugins,
		'current_language' => $current_language,
	]);
} else {
	// show plugin keys
	elgg_push_breadcrumb($plugin, "translation_editor/{$current_language}/{$plugin}");
	set_input('plugin_id', $plugin);
	
	// new title
	$title_text = elgg_echo('translation_editor:menu:title:plugin', [$plugin, $translated_language]);
	
	// page elements
	$translation = translation_editor_get_plugin($current_language, $plugin);
	if (($plugin == 'custom_keys') && elgg_is_admin_logged_in()) {
		$form = elgg_view_form('translation_editor/add_custom_key');
		
		$body .= elgg_view_module('info', elgg_echo('translation_editor:custom_keys:title'), $form);
	}
	
	$body_vars = [
		'plugin' => $plugin,
		'current_language' => $current_language,
		'translation' => $translation,
	];
	$body .= elgg_view('translation_editor/plugin_edit', $body_vars);
}

// Build page
$page_data = elgg_view_layout('one_column', [
	'title' => $title_text,
	'content' => $body
]);

echo elgg_view_page($title_text, $page_data);
	