<?php

gatekeeper();

$source = get_input("saml_source");

$user = elgg_get_logged_in_user_entity();
$forward_url = "settings/plugins/" . $user->username;

if (!empty($source)) {
	$label = simplesaml_get_source_label($source);
	
	if (simplesaml_is_enabled_source($source)) {
		
		try {
			$saml_auth = new SimpleSAML_Auth_Simple($source);
		} catch (Exception $e) {
			register_error(elgg_echo("simplesaml:error:class", array($e->getMessage())));
			forward($forward_url);
		}
		
		// make sure we can forward you to the correct url
		if (!isset($_SESSION["last_forward_from"])) {
			$_SESSION["last_forward_from"] = $_SERVER["REFERER"];
		}
		
		// login with SAML
		if (!$saml_auth->isAuthenticated()) {
			// not logged in on IDP, so do that
			$saml_auth->login();
		} else {
			// user is authenticated with IDP, so link in Elgg
			$saml_attributes = simplesaml_get_authentication_attributes($saml_auth, $source);
			if (!empty($saml_attributes)) {
				// get external id
				$saml_uid = elgg_extract("elgg:external_id", $saml_attributes);
				if (!empty($saml_uid)) {
					if (is_array($saml_uid)) {
						$saml_uid = $saml_uid[0];
					}
					
					if (simplesaml_link_user($user, $source, $saml_uid)) {
						system_message(elgg_echo("simplesaml:authorize:success", array($label)));
					} else {
						register_error(elgg_echo("simplesaml:authorize:error:link", array($label)));
					}
				} else {
					register_error(elgg_echo("simplesaml:authorize:error:external_id", array($label)));
				}
			} else {
				register_error(elgg_echo("simplesaml:authorize:error:attributes", array($label)));
			}
		}
	} else {
		register_error(elgg_echo("simplesaml:error:source_not_enabled", array($label)));
	}
} else {
	register_error(elgg_echo("simplesaml:error:no_source"));
}

forward($forward_url);
