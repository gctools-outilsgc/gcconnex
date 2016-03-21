<?php
/**
 * Download the custom trnslations for the provided plugin
 */
	
$current_language = get_input("current_language");
$plugin = get_input("plugin");

if (!translation_editor_is_translation_editor()) {
	register_error(elgg_echo("transation_editor:action:translate:error:not_authorized"));
	forward(REFERER);
}

// We'll be outputting a text file
header("Content-Type: text/plain");
	
// It will be called $lang.php
header('Content-Disposition: attachment; filename="' . $current_language . '.php"');

$translation = translation_editor_get_plugin($current_language, $plugin);
$translation = $translation['current_language'];

echo "<?php" . PHP_EOL;
echo "/**" . PHP_EOL;
echo " * This file was created by Translation Editor v" . elgg_get_plugin_from_id("translation_editor")->getManifest()->getVersion() . PHP_EOL;
echo " * On " . date("Y-m-d H:i") . "" . PHP_EOL;
echo " */" . PHP_EOL;
echo PHP_EOL;
echo "return ";
echo var_export($translation, true);
echo ";" . PHP_EOL;

exit();
