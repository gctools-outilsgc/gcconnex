<?php
/**
 * show the list of available languages to translate
 */

$languages = elgg_extract('languages', $vars);
$current_language = elgg_extract('current_language', $vars);
$plugin = elgg_extract('plugin', $vars);
$disabled_languages = elgg_extract('disabled_languages', $vars);
$site_language = elgg_extract('site_language', $vars);

$content = '';

if (!empty($languages)) {
	$table_attributes = [
		'id' => 'translation_editor_language_table',
		'class' => 'elgg-table mbm',
		'title' => elgg_echo('translation_editor:language_selector:title'),
	];
	
	$list = '<table ' . elgg_format_attributes($table_attributes) . '>';
	$list .= '<thead>';
	$list .= '<tr>';
	$list .= '<th class="translation_editor_flag">&nbsp;</th>';
	$list .= '<th>' . elgg_echo('translation_editor:language') . '</th>';
	if (elgg_is_admin_logged_in()) {
		$list .= '<th class="translation_editor_enable">' . elgg_echo('disable') . '</th>';
	}
	$list .= '</tr>';
	$list .= '</thead>';
	
	$list .= '<tbody>';
	foreach ($languages as $language) {
		$list .= '<tr>';
		
		// flag
		$list .= '<td class="translation_editor_flag">';
		$list .= elgg_view('output/te_flag', ['language' => $language]);
		$list .= '</td>';
		
		// language
		$translated_language = $language;
		if (elgg_language_key_exists($language, $language)) {
			// display language in own language
			$translated_language = elgg_echo($language, [], $language);
		} elseif (elgg_language_key_exists($language)) {
			// fallback to English
			$translated_language = elgg_echo($language);
		}
		
		$list .= '<td>';
		if ($language != $current_language) {
			$url = 'translation_editor/' . $language . '/' . $plugin;
			
			if ($language != 'en') {
				$completeness = translation_editor_get_language_completeness($language);
				$list .= elgg_view('output/url', [
					'text' => "{$translated_language} ({$completeness}%)",
					'href' => $url,
				]);
				
				if (elgg_is_admin_logged_in() && empty($completeness)) {
					$list .= elgg_view('output/url', [
						'href' => "action/translation_editor/delete_language?language={$language}",
						'confirm' => elgg_echo('translation_editor:language_selector:remove_language:confirm'),
						'text' => elgg_view_icon('delete-alt', ['class' => 'mls']),
					]);
				}
			} else {
				$list .= elgg_view('output/url', [
					'text' => $translated_language,
					'href' => $url,
				]);
			}
		} else {
			if ($language != 'en') {
				$list .= "{$translated_language} (" . translation_editor_get_language_completeness($language) . "%)";
			} else {
				$list .= $translated_language;
			}
		}
		
		if ($site_language == $language) {
			$list .= elgg_format_element('span', ['class' => 'elgg-quiet mls'], elgg_echo('translation_editor:language_selector:site_language'));
		}
		$list .= '</td>';
		
		// checkbox
		if (elgg_is_admin_logged_in()) {
			$list .= '<td class="translation_editor_enable">';
			if ($language != 'en') {
				$options = [
					'name' => 'disabled_languages[]',
					'value' => $language,
					'onchange' => 'elgg.translation_editor.disable_language();',
					'default' => false,
				];
				
				if (in_array($language, $disabled_languages)) {
					$options['checked'] = 'checked';
				}
				
				$list .= elgg_view('input/checkbox', $options);
			}
			$list .= '</td>';
		}
		
		$list .= '</tr>';
	}
	$list .= '</tbody>';
	
	$list .= '</table>';
	
	$content .= $list;
}

if (elgg_is_admin_logged_in()) {
	// add a new language
	$content .= elgg_view('translation_editor/add_language');
}

if (empty($content)) {
	return;
}

elgg_register_plugin_hook_handler('register', 'menu:title', '\ColdTrick\TranslationEditor\TitleMenu::registerLanguageSelector');

echo elgg_format_element('div', ['id' => 'translation-editor-language-selection', 'class' => 'hidden'], $content);
