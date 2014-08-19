<?php 

	gatekeeper();
	
	// get inputs
	$q = get_input("translation_editor_search");
	$language = get_input("language", "en");
	
	$found = translation_editor_search_translation($q, $language);
	$trans = get_installed_translations();
	
	if(!array_key_exists($language, $trans)){
		forward("translation_editor");
	}
	
	// build page elements
	$title_text = elgg_echo("translation_editor:search");
	$title = elgg_view_title($title_text);
	
	elgg_push_breadcrumb(elgg_echo("translation_editor:menu:title"), "translation_editor");
	elgg_push_breadcrumb(elgg_echo($language), "translation_editor/" . $language);
	elgg_push_breadcrumb($title_text);
	
	$body .= elgg_view("translation_editor/search", array("current_language" => $language, "query" => $q));
	$body .= elgg_view("translation_editor/search_results", array("results" => $found, "current_language" => $language));

	// Build page
	$page_data = elgg_view_layout('one_column', array(
		'content' => "<div class='elgg-head'>" . $title . "</div>" . $body
	));

	echo elgg_view_page($title_text, $page_data);
