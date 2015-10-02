<?php
/**
 * show the list of available languages to translate
 */

$languages = elgg_extract("languages", $vars);
$current_language = elgg_extract("current_language", $vars);
$plugin = elgg_extract("plugin", $vars);
$disabled_languages = elgg_extract("disabled_languages", $vars);
$site_language = elgg_extract("site_language", $vars);

if (!empty($languages)) {
	$table_attributes = array(
		"id" => "translation_editor_language_table",
		"class" => "elgg-table mbm",
		"title" => elgg_echo("translation_editor:language_selector:title")
	);
	
	$list = "<table " . elgg_format_attributes($table_attributes) . ">";
	$list .= "<tr>";
	$list .= "<th class='translation_editor_flag'>&nbsp;</th>";
	$list .= "<th>" . elgg_echo("translation_editor:language") . "</th>";
	if (elgg_is_admin_logged_in()) {
		$list .= "<th class='translation_editor_enable'>" . elgg_echo("disable") . "</th>";
	}
	$list .= "</tr>";
	
	foreach ($languages as $language) {
		$list .= "<tr>";
		
		// flag
		$list .= "<td class='translation_editor_flag'>";
		$list .= elgg_view("output/te_flag", array("language" => $language));
		$list .= "</td>";
		
		// language
		$translated_language = $language;
		if (elgg_language_key_exists($language)) {
			$translated_language = elgg_echo($language);
		}
		
		$list .= "<td>";
		if ($language != $current_language) {
			$url = "translation_editor/" . $language . "/" . $plugin;
			
			if ($language != "en") {
				$completeness = translation_editor_get_language_completeness($language);
				$list .= elgg_view("output/url", array(
					"text" => "{$translated_language} ({$completeness}%)",
					"href" => $url
				));
				
				if (elgg_is_admin_logged_in() && empty($completeness)) {
					$list .= elgg_view("output/url", array(
						"href" => "action/translation_editor/delete_language?language=" . $language,
						"confirm" => elgg_echo("translation_editor:language_selector:remove_language:confirm"),
						"text" => elgg_view_icon("delete-alt")
					));
				}
			} else {
				$list .= elgg_view("output/url", array(
					"text" => $translated_language,
					"href" => $url
				));
			}
		} else {
			if ($language != "en") {
				$list .= "{$translated_language} (" . translation_editor_get_language_completeness($language) . "%)";
			} else {
				$list .= $translated_language;
			}
		}
		
		if ($site_language == $language) {
			$list .= "<span id='translation_editor_site_language'>" . elgg_echo("translation_editor:language_selector:site_language") . "</span>";
		}
		$list .= "</td>";
		
		// checkbox
		if (elgg_is_admin_logged_in()) {
			$list .= "<td class='translation_editor_enable'>";
			if ($language != "en") {
				$options = array(
					"name" => "disabled_languages[]",
					"value" => $language,
					"onchange" => "elgg.translation_editor.disable_language();",
					"default" => false
				);
				
				if (in_array($language, $disabled_languages)) {
					$options["checked"] = "checked";
				}
				
				$list .= elgg_view("input/checkbox", $options);
			}
			$list .= "</td>";
		}
		
		$list .= "</tr>";
	}
	
	$list .= "</table>";
	
	echo $list;
}

if (elgg_is_admin_logged_in()) {
	// add a new language
	echo elgg_view("translation_editor/add_language");
}
