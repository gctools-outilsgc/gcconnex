<?php

$source = get_input("saml_source");
$displayname = get_input("displayname");
$user_email = get_input("email");

$forward_url = REFERER;

if (!elgg_is_logged_in()) {
	if (!empty($source) && !empty($_SESSION["saml_source"])) {
		$label = simplesaml_get_source_label($source);
		
		if (simplesaml_is_enabled_source($source)) {
			if ($source == $_SESSION["saml_source"]) {
				$error = false;
				$saml_attributes = $_SESSION["saml_attributes"];
				
				// prepare for registration
				$name = "";
				if (!empty($saml_attributes["elgg:firstname"]) || !empty($saml_attributes["elgg:lastname"])) {
					$firstname = elgg_extract("elgg:firstname", $saml_attributes);
					if (is_array($firstname)) {
						$firstname = $firstname[0];
					}
					$lastname = elgg_extract("elgg:lastname", $saml_attributes);
					if (is_array($lastname)) {
						$lastname = $lastname[0];
					}
					
					if (!empty($firstname)) {
						$name = $firstname;
					}
					
					if (!empty($lastname)) {
						if (!empty($name)) {
							$name .= " " . $lastname;
						} else {
							$name = $lastname;
						}
					}
				} elseif (!empty($displayname)) {
					$name = $displayname;
				} else {
					$error = true;
					register_error(elgg_echo("simplesaml:action:register:error:displayname"));
				}
				
				$email = "";
				$validate = false;
				if (!empty($saml_attributes["elgg:email"])) {
					$email = elgg_extract("elgg:email", $saml_attributes);
					
					if (is_array($email)) {
						$email = $email[0];
					}
				} elseif (!empty($user_email)) {
					$email = $user_email;
					$validate = true;
				} else {
					$error = true;
					register_error(elgg_echo("registration:emailnotvalid"));
				}
				
				$username = elgg_extract("elgg:username", $saml_attributes);
				if (is_array($username)) {
					$username = $username[0];
				}
				
				// register user
				if (empty($error)) {
					$user = simplesaml_register_user($name, $email, $source, $validate, $username);
					if (!empty($user)) {
						// link user to the saml source
						// make sure we can find hidden (unvalidated) users
						$hidden = access_get_show_hidden_status();
						access_show_hidden_entities(true);
						
						$saml_uid = elgg_extract("elgg:external_id", $saml_attributes);
						if (!empty($saml_uid)) {
							if (is_array($saml_uid)) {
								$saml_uid = $saml_uid[0];
							}
							simplesaml_link_user($user, $source, $saml_uid);
						}
						
						// save attributes
						simplesaml_save_authentication_attributes($user, $source,$saml_attributes);
						
						// restore hidden setting
						access_show_hidden_entities($hidden);
						
						// notify user about registration
						system_message(elgg_echo("registerok", array(elgg_get_site_entity()->name)));
						
						// cleanup session
						unset($_SESSION["saml_source"]);
						unset($_SESSION["saml_attributes"]);
						
						// try to login the user
						try {
							login($user);
							
							if (!empty($_SESSION["last_forward_from"])) {
								$forward_url = $_SESSION["last_forward_from"];
								unset($_SESSION["last_forward_from"]);
							} else {
								$forward_url = "";
							}
						} catch(Exception $e){
							$forward_url = "";
						}
					}
				}
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

forward($forward_url);
