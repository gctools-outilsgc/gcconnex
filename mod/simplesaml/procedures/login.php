<?php

$forward_url = REFERER;

if (!elgg_is_logged_in()) {
	$source = get_input("saml_source");
	
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
				// user is authenticated with IDP, so check in Elgg
				$saml_attributes = simplesaml_get_authentication_attributes($saml_auth, $source);
				
				// save the attributes for further use
				$_SESSION["saml_attributes"] = $saml_attributes;
				$_SESSION["saml_source"] = $source;
				
				// make sure we can find all users (even unvalidated)
				$hidden = access_get_show_hidden_status();
				access_show_hidden_entities(true);
				
				$user = simplesaml_find_user($source, $saml_attributes);
				if (!empty($user)) {
					// found a user, so login
					try {
						login($user);
						
						if (!empty($_SESSION["last_forward_from"])) {
						//	$forward_url = $_SESSION["last_forward_from"];
							unset($_SESSION["last_forward_from"]);
						} else {
							$forward_url = "";
						}
						
						system_message(elgg_echo("loginok"));
					} catch (Exception $e) {
						// report the error
						register_error($e->getMessage());
						
						// forward to front page
						$forward_url = "";
					}
					
					// unset session vars
					unset($_SESSION["saml_attributes"]);
					unset($_SESSION["saml_source"]);
					
				} else {
					// check if we can automaticly create an account for this user
					if (simplesaml_check_auto_create_account($source, $saml_attributes)) {
						// we have enough information to create the account so let's do that
						$forward_url = "action/simplesaml/register?saml_source=" . $source;
						$forward_url = elgg_add_action_tokens_to_url($forward_url);
					} else {
						// no user found, so forward to a different page
						$forward_url = "saml/no_linked_account/" . $source;
						
						system_message(elgg_echo("simplesaml:login:no_linked_account", array($label)));
					}
				}
				
				// restore hidden settings
				access_show_hidden_entities($hidden);
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

forward($forward_url);
