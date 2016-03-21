<?php
/**
 * Output a country flag
 *
 * @uses $vars['language'] hte language to find the flag for
 */

$language = elgg_extract("language", $vars);

if (empty($language)) {
	return "&nbsp;";
}

$flag_location = elgg_get_plugins_path() . "translation_editor/_graphics/flags/" . $language . ".gif";

if (!file_exists($flag_location)) {
	return "&nbsp;";
}

$title_alt = $language;
if (elgg_language_key_exists($language)) {
	$title_alt = elgg_echo($language);
}

echo elgg_view("output/img", array(
	"src" => "mod/translation_editor/_graphics/flags/" . $language . ".gif",
	"alt" => $title_alt,
	"title" => $title_alt
));
