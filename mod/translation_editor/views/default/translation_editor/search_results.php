<?php
/**
 * Show the edit form for the search result translation keys
 */

$search_results = elgg_extract("results", $vars);
$current_language = elgg_extract("current_language", $vars);

$en_flag = elgg_view("output/te_flag", array("language" => "en"));
$lang_flag = elgg_view("output/te_flag", array("language" => $current_language));

$list = "";
foreach ($search_results as $plugin => $data) {
	$translated_language = elgg_extract("current_language", $data);
	
	$list .= "<table class='elgg-table translation_editor_translation_table translation-editor-translation-table-no-missing mbl'>";
	$list .= "<col class='first_col'/>";
	$list .= "<tr class='first_row'><th colspan='2'>";
	$list .= elgg_view("output/url", array("href" => "translation_editor/" . $current_language . "/" . $plugin, "text" => $plugin));
	$list .= "</th></tr>";
	
	foreach ($data["en"] as $key => $value) {
		
		$list .= elgg_view("input/te_translation", array(
			"english" => array(
				"key" => $key,
				"value" => $value
			),
			"translation" => array(
				"key" => $key,
				"value" => elgg_extract($key, $translated_language)
			),
			"plugin" => $plugin,
			"language" => $current_language
		));
	}
	
	$list .= "</table>";
}

echo $list;
