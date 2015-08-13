<?php

$user = elgg_get_logged_in_user_entity();
if (!empty($user)) {
	$widget = elgg_extract("entity", $vars);
	
	// there need to be saml source enaqbled
	$sources = simplesaml_get_enabled_sources();
	if (!empty($sources)) {
		$configured_source = $widget->samlsource;
		
		if (empty($configured_source) || ($configured_source === "all")) {
			// show all configured sources
			foreach ($sources as $source) {
				$label = simplesaml_get_source_label($source);
				
				$icon_url = simplesaml_get_source_icon_url($source);
				if (!empty($icon_url)) {
					$text = elgg_view("output/img", array("src" => $icon_url, "alt" => $label));
				} else {
					$text = $label;
				}
				
				echo "<div class='mbs'>";
				echo elgg_view("output/url", array("text" => $text, "title" => $label, "href" => "saml/login/" . $source));
				echo "</div>";
			}
		} elseif (!empty($configured_source) && simplesaml_is_enabled_source($configured_source)) {
			// show one saml source
			$label = simplesaml_get_source_label($configured_source);
			
			$icon_url = simplesaml_get_source_icon_url($configured_source);
			if (!empty($icon_url)) {
				$text = elgg_view("output/img", array("src" => $icon_url, "alt" => $label));
			} else {
				$text = $label;
			}
			
			echo "<div>";
			echo elgg_view("output/url", array("text" => $text, "title" => $label, "href" => "saml/login/" . $configured_source));
			echo "</div>";
		}
	}
} else {
	// user is already loggedin
	$site = elgg_get_site_entity();
	
	echo elgg_echo("simplesaml:widget:logged_in", array($user->name, $site->name));
}
