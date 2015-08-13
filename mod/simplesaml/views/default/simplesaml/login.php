<?php

$sources = simplesaml_get_enabled_sources();
if (!empty($sources)) {
	
	foreach ($sources as $source) {
		$label = simplesaml_get_source_label($source);
		
		$icon_url = simplesaml_get_source_icon_url($source);
		if (!empty($icon_url)) {
			$text = elgg_view("output/img", array("src" => $icon_url, "alt" => $label));
		} else {
			$text = $label;
		}
		
		echo "<div>";
		echo elgg_view("output/url", array("text" => $text, "title" => $label, "href" => "saml/login/" . $source));
		echo "</div>";
	}
}
