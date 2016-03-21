<?php
/**
 * display the search results
 */

translation_editor_gatekeeper();

elgg_require_js("translation_editor/edit");

// get inputs
$q = get_input("translation_editor_search");
$language = get_input("language", "en");

$found = translation_editor_search_translation($q, $language);
$trans = get_installed_translations();

if (!array_key_exists($language, $trans)) {
	forward("translation_editor");
}

$title_text = elgg_echo("translation_editor:search");

// breadcrumb
elgg_push_breadcrumb(elgg_echo("translation_editor:menu:title"), "translation_editor");
elgg_push_breadcrumb(elgg_echo($language), "translation_editor/" . $language);
elgg_push_breadcrumb($title_text);

// build page elements
$title = elgg_view_title($title_text);

// build search form
$form_vars = array(
	"id" => "translation_editor_search_form",
	"action" => "translation_editor/search",
	"disable_security" => true,
	"class" => "mbl"
);
$body_vars  = array(
	"current_language" => $language,
	"query" => $q
);
$body .= elgg_view_form("translation_editor/search", $form_vars, $body_vars);

// display search results
if (!empty($found)) {

	$body_vars = array(
		"results" => $found,
		"current_language" => $language
	);
	$body .= elgg_view("translation_editor/search_results", $body_vars);
} else {
	$body .= elgg_view("output/longtext", array("value" => elgg_echo("translation_editor:search_results:no_results")));
}

// Build page
$page_data = elgg_view_layout("one_column", array(
	"content" => "<div class='elgg-head'>" . $title . "</div>" . $body,
));

echo elgg_view_page($title_text, $page_data);
