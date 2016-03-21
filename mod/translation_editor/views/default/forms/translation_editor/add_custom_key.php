<?php
/**
 * Form to add a custom language key
 */

$form_body = "<div>";
$form_body .= "<label for='translation-editor-add-key-key'>" . elgg_echo("translation_editor:custom_keys:key") . "</label>";
$form_body .= elgg_view("input/text", array("name" => "key", "id" => "translation-editor-add-key-key"));

$form_body .= "<label for='translation-editor-add-key-value'>" . elgg_echo("translation_editor:custom_keys:translation") . "</label>";
$form_body .= elgg_view("input/plaintext", array("name" => "translation", "rows" => 3, "id" => "translation-editor-add-key-value"));
$form_body .= "<span class='elgg-quiet'>" . elgg_echo("translation_editor:custom_keys:translation_info") . "</span>";
$form_body .= "</div>";

$form_body .= elgg_view("input/submit", array("value" => elgg_echo("save")));

echo elgg_view_module("info", elgg_echo("translation_editor:custom_keys:title"), $form_body);
