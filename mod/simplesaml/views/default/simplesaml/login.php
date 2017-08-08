<?php
/**
 * Append the configured SAML/CAS sources to the login form
 */

$sources = simplesaml_get_enabled_sources();
if (empty($sources)) {
	return;
}

foreach ($sources as $source) {
	$label = simplesaml_get_source_label($source);
	
	$icon_url = simplesaml_get_source_icon_url($source);
	if (!empty($icon_url)) {
		$text = elgg_view('output/img', [
			'src' => $icon_url,
			'alt' => $label,
		]);
	} else {
		$text = $label;
	}
	
	echo elgg_format_element('div', [], elgg_view('output/url', [
		'text' => $text,
		'title' => $label,
		'href' => "saml/login/{$source}",
	]));
}
