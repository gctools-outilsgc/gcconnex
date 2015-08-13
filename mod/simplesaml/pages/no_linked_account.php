<?php

$source = get_input("saml_source");

$forward = true;

if (!elgg_is_logged_in()) {
	if (!empty($source)) {
		$label = simplesaml_get_source_label($source);
		
		if (simplesaml_is_enabled_source($source)) {
			if (!empty($_SESSION["saml_source"]) && ($_SESSION["saml_source"] == $source)) {
				$forward = false;
				simplesaml_unextend_login_form();
				$allow_registration = simplesaml_allow_registration($source);
				
				// prepare page elements
				$title_text = elgg_echo("simplesaml:no_linked_account:title", array($label));
				
				$content = elgg_view("simplesaml/no_linked_account", array("saml_source" => $source, "allow_registration" => $allow_registration));
				
				// build body
				$body = elgg_view_layout("one_column", array(
					"title" => $title_text,
					"content" => $content
				));
				
				// draw page
				echo elgg_view_page($title_text, $body);
			} else {
				register_error(elgg_echo("simplesaml:error:source_mismatch"));
			}
		} else {
			register_error(elgg_echo("simplesaml:error:source_not_enabled", array($label)));
		}
	} else {
		register_error(elgg_echo("simplesaml:error:no_source"));
	}
} else {
	register_error(elgg_echo("simplesaml:error:loggedin"));
}

if ($forward) {
	forward();
}
