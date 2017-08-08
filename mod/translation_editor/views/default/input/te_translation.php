<?php
/**
 * Display a row in a table to be translated
 *
 * @uses $vars['english'] as array('key' => $language_key, 'value' => $english_value)
 * @uses $vars['translation'] as array('key' => $language_key, 'value' =>  => $translated_value)
 * @uses $vars['language'] the language being translated
 * @uses $vars['row_rel'] a special rel to put on the rows
 * @uses $vars['plugin'] plugin id
 */

$current_language = elgg_extract('language', $vars);
$english = elgg_extract('english', $vars);
$translation = elgg_extract('translation', $vars);
$plugin = elgg_extract('plugin', $vars);
$row_rel = elgg_extract('row_rel', $vars);

if (!empty($row_rel)) {
	$row_rel = 'rel="' . $row_rel . '"';
}

$en_flag = elgg_view('output/te_flag', ['language' => 'en']);
$lang_flag = elgg_view('output/te_flag', ['language' => $current_language]);

// English information
$row = '<tr ' . $row_rel . '>';
$row .= '<td>' . $en_flag . '</td>';
$row .= '<td>';
$row .= elgg_view_icon('key', ['title' => $english['key'], 'class' => 'float-alt translation-editor-translation-key']);
$row .= elgg_format_element('pre', ['class' => 'translation_editor_pre'], nl2br(htmlspecialchars($english['value'])));
$row .= '</td>';
$row .= '</tr>';

// Custom language information
$translation_value = elgg_extract('value', $translation);
$row_count = max(2, count(explode('\n', $translation_value)));
$key = elgg_extract('key', $translation);
$text_options = [
	'name' => "translation[{$current_language}][{$plugin}][{$key}]",
	'value' => $translation_value,
	'rows' => $row_count,
	'class' => 'translation-editor-input',
];

$row .= '<tr ' . $row_rel . '>';
$row .= '<td>' . $lang_flag . '</td>';
$row .= '<td>';
$row .= elgg_view('input/plaintext', $text_options);
$row .= '</td>';
$row .= '</tr>';

echo $row;
