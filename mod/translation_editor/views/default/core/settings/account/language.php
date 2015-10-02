<?php
/**
 * Provide a way of setting your language prefs
 *
 * @package Elgg
 * @subpackage Core
 */

$user = elgg_get_page_owner_entity();
if (empty($user) || !elgg_instanceof($user, "user")) {
	return;
}
	
translation_editor_unregister_translations();

$translations = get_installed_translations();

$value = $user->language;
if (empty($value)) {
	$value = elgg_get_config("language");
}

if (count($translations) > 1) {
	// there are languages to choose from
	$title = elgg_echo("user:set:language");
	
	$body = elgg_echo("user:language:label");
	$body .= elgg_view("input/hidden", array(		// changed to hidden, not needed (and not usable) with the language selector
		"name" => "language",
		"value" => $value,
		"options_values" => $translations,
		"class" => "mlm"
	));
	
	echo elgg_view_module("info", $title, $body);
} else {
	// only one language available, so set that language
	echo elgg_view("input/hidden", array("name" => "language", "value" => $value));
}
