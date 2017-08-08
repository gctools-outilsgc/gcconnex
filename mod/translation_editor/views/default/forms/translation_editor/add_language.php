<?php

$options = [];
$current_language = get_current_language();
$keys = Elgg\I18n\Translator::getAllLanguageCodes();
foreach ($keys as $lang_key) {
	$trans_key = $lang_key;
	if (elgg_language_key_exists($lang_key, $current_language) || elgg_language_key_exists($lang_key)) {
		$trans_key = elgg_echo($lang_key);
	}
	
	$options[$lang_key] = $trans_key;
}

$installed_languages = get_installed_translations();
foreach ($installed_languages as $index => $lang) {
	unset($options[$index]);
}

asort($options);

$form_body = elgg_view('input/dropdown', [
	'options_values' => $options,
	'name' => 'code',
]);
$form_body .= elgg_view('input/submit', [
	'value' => elgg_echo('save'),
	'class' => 'mls elgg-button-submit',
]);

echo $form_body;
