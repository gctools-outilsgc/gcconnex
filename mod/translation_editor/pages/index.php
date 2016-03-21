<?php
/**
 * Get an overview of the translations, eighter a listing off all plugins or an overview of the available keys in a plugin
 */

translation_editor_gatekeeper();

elgg_require_js("translation_editor/edit");

// Build elements
$title_text = elgg_echo("translation_editor:menu:title");

elgg_push_breadcrumb($title_text, "translation_editor");

// Get inputs
$current_language = get_input("current_language", get_current_language());
$plugin = get_input("plugin");

$translations = get_installed_translations();
if (!(array_key_exists($current_language, $translations))) {
	forward("translation_editor");
}

$site_translations = elgg_get_config("translations");
$languages = array_keys($site_translations);

$disabled_languages = translation_editor_get_disabled_languages();
if (empty($disabled_languages)) {
	$disabled_languages = array();
}

$site_language = elgg_get_config("language");
if (empty($site_language)) {
	$site_language = "en";
}

$body = elgg_view("translation_editor/language_selector", array(
	"current_language" => $current_language,
	"plugin" => $plugin,
	"languages" => $languages,
	"disabled_languages" => $disabled_languages,
	"site_language" => $site_language
));

if (empty($plugin)) {
	// show plugin list
	elgg_push_breadcrumb(elgg_echo($current_language));
	
	$plugins = translation_editor_get_plugins($current_language);
	
	$form_vars = array(
		"id" => "translation_editor_search_form",
		"action" => "translation_editor/search",
		"disable_security" => true,
		"class" => "mbl"
	);
	$body_vars  = array(
		"current_language" => $current_language,
	);
	$body .= elgg_view_form("translation_editor/search", $form_vars, $body_vars);
	
	$body .= elgg_view("translation_editor/plugin_list", array("plugins" => $plugins, "current_language" => $current_language));
} else {
	// show plugin keys
	elgg_push_breadcrumb(elgg_echo($current_language), "translation_editor/" . $current_language);
	elgg_push_breadcrumb($plugin);
	
	$translation = translation_editor_get_plugin($current_language, $plugin);
	if (($plugin == "custom_keys") && elgg_is_admin_logged_in()) {
		$body .= elgg_view_form("translation_editor/add_custom_key", array("class" => "mbm"));
	}
	
	$body_vars = array(
		"plugin" => $plugin,
		"current_language" => $current_language,
		"translation" => $translation
	);
	$body .= elgg_view("translation_editor/plugin_edit", $body_vars);
}

// Build page
$page_data = elgg_view_layout("one_column", array(
	"title" => $title_text,
	"content" => $body
));

echo elgg_view_page($title_text, $page_data);
	