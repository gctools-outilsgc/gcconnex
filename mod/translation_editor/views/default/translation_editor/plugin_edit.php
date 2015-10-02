<?php
/**
 * show a form to edit the language of a plugin
 */

$current_language = elgg_extract("current_language", $vars);
$plugin = elgg_extract("plugin", $vars);

$working_translation = elgg_extract("translation", $vars);
$english = elgg_extract("en", $working_translation);
$translated_language = elgg_extract("current_language", $working_translation);
$custom = elgg_extract("custom", $working_translation);

$missing_count = 0;
$equal_count = 0;
$params_count = 0;
$custom_count = 0;

$translation = "";
if (!empty($english)) {
	foreach ($english as $en_key => $en_value) {
		$en_params = translation_editor_get_string_parameters($en_value);
		$cur_params = 0;
		if (array_key_exists($en_key, $translated_language)) {
			$cur_params = translation_editor_get_string_parameters($translated_language[$en_key]);
		}
		
		$row_rel = "";
		if (!array_key_exists($en_key, $translated_language)) {
			$row_rel = "missing";
			$missing_count++;
		} elseif ($en_value == $translated_language[$en_key]) {
			$row_rel = "equal";
			$equal_count++;
		} elseif ($en_params != $cur_params) {
			$row_rel = "params";
			$params_count++;
		} elseif (array_key_exists($en_key, $custom)) {
			$row_rel = "custom";
			$custom_count++;
		}
		
		$translation .= elgg_view("input/te_translation", array(
			"english" => array(
				"key" => $en_key,
				"value" => $en_value
			),
			"translation" => array(
				"key" => $en_key,
				"value" => elgg_extract($en_key, $translated_language)
			),
			"plugin" => $plugin,
			"language" => $current_language,
			"row_rel" => $row_rel
		));
	}
}

$selected_view_mode = "missing";
$table_class = "translation_editor_translation_table mbl";
if (empty($missing_count)) {
	$selected_view_mode = "all";
	$table_class .= " translation-editor-translation-table-no-missing";
}

// toggle between different filters
$toggle = "<span id='translation_editor_plugin_toggle' class='float-alt'>";
	
$toggle .= elgg_echo("translation_editor:plugin_edit:show") . " ";

$missing_class = "";
$equal_class = "";
$params_class = "";
$custom_class = "";
$all_class = "";

switch ($selected_view_mode) {
	case "missing":
		$missing_class = "view_mode_active";
		break;
	case "all":
		$all_class = "view_mode_active";
		break;
	case "equal":
		$equal_class = "view_mode_active";
		break;
	case "custom":
		$custom_class = "view_mode_active";
		break;
	case "params":
		$params_class = "view_mode_active";
		break;
}

$toggle .= elgg_view("output/url", array(
	"text" => elgg_echo("translation_editor:plugin_edit:show:missing"),
	"class" => $missing_class,
	"onclick" => "elgg.translation_editor.toggle_view_mode('missing');",
	"href" => "javascript:void(0);",
	"rel" => "missing",
)) . " (" . $missing_count . "), ";

$toggle .= elgg_view("output/url", array(
	"text" => elgg_echo("translation_editor:plugin_edit:show:equal"),
	"class" => $equal_class,
	"onclick" => "elgg.translation_editor.toggle_view_mode('equal');",
	"href" => "javascript:void(0);",
	"rel" => "equal",
)) . " (" . $equal_count . "), ";

$toggle .= elgg_view("output/url", array(
	"text" => elgg_echo("translation_editor:plugin_edit:show:params"),
	"class" => $params_class,
	"onclick" => "elgg.translation_editor.toggle_view_mode('params');",
	"href" => "javascript:void(0);",
	"rel" => "params",
)) . " (" . $params_count . "), ";

$toggle .= elgg_view("output/url", array(
	"text" => elgg_echo("translation_editor:plugin_edit:show:custom"),
	"class" => $custom_class,
	"onclick" => "elgg.translation_editor.toggle_view_mode('custom');",
	"href" => "javascript:void(0);",
	"rel" => "custom",
)) . " (" . $custom_count . "), ";

$toggle .= elgg_view("output/url", array(
	"text" => elgg_echo("translation_editor:plugin_edit:show:all"),
	"class" => $all_class,
	"onclick" => "elgg.translation_editor.toggle_view_mode('all');",
	"href" => "javascript:void(0);",
	"rel" => "all",
)) . " (" . $vars['translation']['total'] . ")";
$toggle .= "</span>";

// build the edit table
$list = "<table class='elgg-table " . $table_class . "'>";
$list .= "<col class='first_col'/>";
$list .= "<tr class='first_row'><th colspan='2'>";
$list .= $toggle;
$list .= elgg_echo("translation_editor:plugin_edit:title") . " " . $plugin;
$list .= "</th></tr>";
$list .= $translation;
$list .= "</table>";

// show all
echo $list;
