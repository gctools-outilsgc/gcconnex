<?php
/**
 * Add a custom key to the translations.
 */

$key = get_input("key");
$translation = get_input("translation");

$translations = elgg_get_config("translations");

if (empty($key) || empty($translation)) {
	register_error(elgg_echo("translation_editor:action:add_custom_key:missing_input"));
	forward(REFERER);
}

if (is_numeric($key)) {
	register_error(elgg_echo("translation_editor:action:add_custom_key:key_numeric"));
	forward(REFERER);
}

if (!preg_match("/^[a-zA-Z0-9_:]{1,}$/", $key)) {
	register_error(elgg_echo("translation_editor:action:add_custom_key:invalid_chars"));
	forward(REFERER);
}

if (array_key_exists($key, $translations["en"])) {
	register_error(elgg_echo("translation_editor:action:add_custom_key:exists"));
	forward(REFERER);
}
	
// save
$custom_translations = translation_editor_get_plugin("en", "custom_keys");
if (!empty($custom_translations)) {
	$custom_translations = $custom_translations["en"];
} else {
	$custom_translations = array();
}

$custom_translations[$key] = $translation;

$base_dir = elgg_get_data_path() . "translation_editor" . DIRECTORY_SEPARATOR;
if (!file_exists($base_dir)) {
	mkdir($base_dir, 0755, true);
}

$location = $base_dir . "custom_keys" . DIRECTORY_SEPARATOR;
if (!file_exists($location)) {
	mkdir($location, 0755, true);
}

$file_contents = "<?php" . PHP_EOL;
$file_contents .= 'return ';
$file_contents .= var_export($custom_translations, true);
$file_contents .= ';' . PHP_EOL;

if (file_put_contents($location . "en.php", $file_contents)) {
	
	// invalidate cache
	translation_editor_invalidate_site_cache();
	
	system_message(elgg_echo("translation_editor:action:add_custom_key:success"));
} else {
	register_error(elgg_echo("translation_editor:action:add_custom_key:file_error"));
}

forward(REFERER);
