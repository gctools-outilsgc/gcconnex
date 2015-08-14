<?php
/**
 * In this file all helper functions for this pluign can be found.
 */

/**
 * Get a readable label for a configured Service Provider (SP).
 *
 * The language key that is checked is 'simplesaml:sources:label:<source name>',
 * if this is not found the source name will be returned.
 *
 * @param string $source the name of the SP
 *
 * @return string the readable name for the SP
 */
function simplesaml_get_source_label($source) {
	$result = $source;
	
	if (!empty($source)) {
		$lan_key = "simplesaml:sources:label:" . $source;
		
		if (elgg_echo($lan_key) != $lan_key) {
			$result = elgg_echo($lan_key);
		}
	}
	
	return $result;
}

/**
 * Return an array of the configured SAML Service Providers (SP).
 *
 * @return bool|array an array with the configured SP's, or false on failure
 */
function simplesaml_get_configured_sources() {
	static $result;
	
	if (!isset($result)) {
		$result = false;
		
		if (class_exists("SimpleSAML_Auth_Source")) {
			// get SAML sources
			$sources = SimpleSAML_Auth_Source::getSourcesOfType("saml:SP");
			if (!empty($sources)) {
				$result = $sources;
			}
			
			// get CAS sources
			$sources = SimpleSAML_Auth_Source::getSourcesOfType("cas:CAS");
			if (!empty($sources)) {
				// check if we need to merge
				if (!empty($result)) {
					$result = array_merge($result, $sources);
				} else {
					$result = $sources;
				}
			}
		}
	}
	
	return $result;
}

/**
 * Return an array of all the enabled configured Service Providers (SP).
 *
 * To enable a Service Provider please check the plugin settings page.
 *
 * @see simplesaml_get_configured_sources()
 *
 * @return bool|array an array with the enabled SP's
 */
function simplesaml_get_enabled_sources() {
	static $result;
	
	if (!isset($result)) {
		$result = false;
		
		$sources = simplesaml_get_configured_sources();
		if (!empty($sources)) {
			$enabled_sources = array();
			
			foreach ($sources as $source) {
				$source_auth_id = $source->getAuthId();
				
				if (elgg_get_plugin_setting($source_auth_id . "_enabled", "simplesaml")) {
					$enabled_sources[] = $source_auth_id;
				}
			}
			
			if (!empty($enabled_sources)) {
				$result = $enabled_sources;
			}
		}
	}
	
	return $result;
}

/**
 * Find out if ther is an icon configured for the provided Service Provider (SP).
 *
 * To configure an icon please check the plugin settings page.
 *
 * @param string $source the name of the SP to check
 *
 * @return bool|string the url of the icon, or false if not configured
 */
function simplesaml_get_source_icon_url($source) {
	$result = false;
	
	if (!empty($source)) {
		$setting = elgg_get_plugin_setting($source . "_icon_url", "simplesaml");
		if (!empty($setting)) {
			$result = $setting;
		}
	}
	
	return $result;
}

/**
 * Check if a Serivce Provider (SP) is enabled in the plugin settings.
 *
 * @param string $source the name of the SP to check
 *
 * @return bool true is enabled, false in all other cases
 */
function simplesaml_is_enabled_source($source) {
	$result = false;
	
	if (!empty($source)) {
		$enabled_sources = simplesaml_get_enabled_sources();
		
		if (!empty($enabled_sources) && in_array($source, $enabled_sources)) {
			$result = true;
		}
	}
	
	return $result;
}

/**
 * Check if we can find a user that is linked to the user provided by the Service Provider (SP).
 *
 * @param string $source          the name of the SP
 * @param array  $saml_attributes an array with the attributes provided by the SP configuration
 *
 * @return bool|ElggUser the user that is linked, false if no user could be found
 */
function simplesaml_find_user($source, $saml_attributes) {
	$result = false;
	
	if (!empty($source) && !empty($saml_attributes) && is_array($saml_attributes)) {
		$saml_uid = elgg_extract("elgg:external_id", $saml_attributes);
		if (is_array($saml_uid)) {
			$saml_uid = $saml_uid[0];
		}
		
		if (!empty($saml_uid)) {
			// first check if we can find a user based on an existing link
			$options = array(
				"type" => "user",
				"limit" => 1,
				"site_guids" => false,
				"plugin_id" => "simplesaml",
				"plugin_user_setting_name_value_pairs" => array(
					$source . "_uid" => $saml_uid
				)
			);
			
			$users = elgg_get_entities_from_plugin_user_settings($options);
			if (!empty($users)) {
				$result = $users[0];
			}
			
			// no user found, can we auto link
			if (empty($result)) {
				// are we allowed to link an existing account based on information from the IDP
				$profile_field = elgg_get_plugin_setting($source . "_auto_link", "simplesaml");
				// is the external information provided
				$auto_link_value = elgg_extract("elgg:auto_link", $saml_attributes);
				if (is_array($auto_link_value)) {
					$auto_link_value = $auto_link_value[0];
				}
				
				if (!empty($profile_field) && !empty($auto_link_value)) {
					switch ($profile_field) {
						case "username":
							// find user based on username
							$user = get_user_by_username($auto_link_value);
							if (!empty($user)) {
								$result = $user;
							}
							
							break;
						case "email":
							// find user based on email address
							$users = get_user_by_email($auto_link_value);
							if (!empty($users) && (count($users) == 1)) {
								$result = $users[0];
							}
							
							break;
						default:
							// find user based on profile information
							$ia = elgg_set_ignore_access(true);
							
							$options = array(
								"type" => "user",
								"limit" => false,
								"site_guids" => false,
								"metadata_name_value_pairs" => array(
									"name" => $profile_field,
									"value" => $auto_link_value
								)
							);
							
							$users = elgg_get_entities_from_metadata($options);
							if (!empty($users) && (count($users) == 1)) {
								// only found 1 user so this is ok
								$result = $users[0];
							}
							
							// restore access
							elgg_set_ignore_access($ia);
					}
					
					if (!empty($result)) {
						// we have a result, so link the user for future use
						simplesaml_link_user($result, $source, $saml_uid);
					}
				}
			}
		}
	}
	
	return $result;
}

/**
 * Can user register with information provided by the supplied Service Provider (SP).
 *
 * @param string $source the name of the SP
 *
 * @return bool true is registration is allowed, false otherwise
 */
function simplesaml_allow_registration($source) {
	$result = false;
	
	if (!empty($source)) {
		if (elgg_get_plugin_setting($source . "_allow_registration", "simplesaml")) {
			$result = true;
		}
	}
	
	return $result;
}

/**
 * A helper function to undo the extensions on the login form view.
 *
 * @see elgg_extend()
 *
 * @return void
 */
function simplesaml_unextend_login_form() {
	global $CONFIG;
	
	if (isset($CONFIG->views)) {
		if (isset($CONFIG->views->extensions)) {
			
			if (isset($CONFIG->views->extensions["forms/login"])) {
				unset($CONFIG->views->extensions["forms/login"]);
			}
			
			if (isset($CONFIG->views->extensions["login/extend"])) {
				unset($CONFIG->views->extensions["login/extend"]);
			}
		}
	}
}

/**
 * Get the attributes from an SAML authentication exchange.
 *
 * These attributes can include all kinds of information, for example:
 * - firstname
 * - lastname
 * - email address
 * - etc.
 *
 * @param SimpleSAML_Auth_Simple $saml_auth the Authentication object from the SimpleSAMLPHP library
 * @param string                 $source    the name of the Service Provider
 *
 * @return bool|array an array with the provided attributes, false on failure
 */
function simplesaml_get_authentication_attributes(SimpleSAML_Auth_Simple $saml_auth, $source) {
	$result = false;
	
	if (!empty($saml_auth) && ($saml_auth instanceof SimpleSAML_Auth_Simple) && !empty($source)) {
		$result = $saml_auth->getAttributes();
		
		$auth_source = $saml_auth->getAuthSource();
		
		if ($auth_source instanceof sspmod_saml_Auth_Source_SP) {
			// only check extra data for SAML sources
			$setting = elgg_get_plugin_setting($source . "_external_id", "simplesaml");
			if (!empty($setting)) {
				$external_id = $saml_auth->getAuthData($setting);
				if (!empty($external_id)) {
					$result["elgg:external_id"] = array($external_id["Value"]);
				}
			}
		}
	}
	
	return $result;
}

/**
 * Link a user to a Service Provider (SP), so in the future the user can login using this SP.
 *
 * @param ElggUser $user        the user to link
 * @param string   $saml_source the name of the SP
 * @param string   $saml_uid    the unique ID of the user on the IDentity Provider side
 *
 * @return bool true is the user is successfully linked, false on failure
 */
function simplesaml_link_user(ElggUser $user, $saml_source, $saml_uid) {
	$result = false;
	
	if (!empty($user) && elgg_instanceof($user, "user", null, "ElggUser") && !empty($saml_source) && !empty($saml_uid)) {
		if (simplesaml_is_enabled_source($saml_source)) {
			// remove links from other users
			$options = array(
				"type" => "user",
				"limit" => false,
				"site_guids" => false,
				"plugin_id" => "simplesaml",
				"plugin_user_setting_name_value_pairs" => array(
					$saml_source . "_uid" => $saml_uid
				)
			);
			
			$users = elgg_get_entities_from_plugin_user_settings($options);
			if (!empty($users)) {
				foreach ($users as $other_user) {
					simplesaml_unlink_user($other_user, $saml_source);
				}
			}
			
			// now save the setting for this user
			$result = elgg_set_plugin_user_setting($saml_source . "_uid", $saml_uid, $user->getGUID(), "simplesaml");
		}
	}
	
	return $result;
}

/**
 * Remove an existing link between the user and a Service Provider (SP).
 *
 * @param ElggUser $user        the user to unlink
 * @param string   $saml_source the name of the SP
 *
 * @return bool true is the user is unlinked, false on failure
 */
function simplesaml_unlink_user(ElggUser $user, $saml_source) {
	$result = false;
	
	if (!empty($user) && elgg_instanceof($user, "user", null, "ElggUser") && !empty($saml_source)) {
		// cleanup the saml attributes
		simplesaml_save_authentication_attributes($user, $saml_source);
		
		// remove the link to the user
		$result = elgg_unset_plugin_user_setting($saml_source . "_uid", $user->getGUID(), "simplesaml");
	}
	
	return $result;
}

/**
 * Register a user in Elgg based on information provided by the Service Provider (SP).
 *
 * @param string $name        the (display)name of the new user
 * @param string $email       the email address of the user
 * @param string $saml_source the name of the SP this information came from
 * @param bool   $validate    do we need to validate the email address of this new users
 * @param string $username    the username provided by the SP (optional)
 *
 * @return bool|ElggUser the new user, false on failure
 */
function simplesaml_register_user($name, $email, $saml_source, $validate = false, $username = "") {
	$result = false;
	
	if (!empty($name) && !empty($email) && !empty($saml_source)) {
		
		// check which username to use
		if (!empty($username)) {
			// make sure the username is unique
			$username = simplesaml_generate_unique_username($username);
		} else {
			// create a username from email
			$username = simplesaml_generate_username_from_email($email);
		}
		
		if (!empty($username)) {
			// generate a random password
			$password = generate_random_cleartext_password();
			
			try {
				$user_guid = register_user($username, $password, $name, $email);
				if (!empty($user_guid)) {
					$new_user = get_user($user_guid);
					
					if (!$validate) {
						// no need for extra validation. We trust this user
						elgg_set_user_validation_status($new_user->getGUID(), true, "simplesaml");
					}
					
					$params = array(
						"user" => $new_user,
						"password" => $password,
						"friend_guid" => null,
						"invitecode" => null
					);
					
					if (!elgg_trigger_plugin_hook("register", "user", $params, true)) {
						register_error(elgg_echo("registerbad"));
					} else {
						$result = $new_user;
					}
				}
			} catch (Exception $e) {
				register_error($e->getMessage());
			}
		} else {
			register_error(elgg_echo("registration:usernamenotvalid"));
		}
	}
	
	return $result;
}

/**
 * Generate a unique username based on a provided email address.
 *
 * The first part (before @) of the email address will be used as a base.
 * Numbers will be added to the end to make it unique.
 *
 * @param string $email the email address to use
 *
 * @see simplesaml_generate_unique_username()
 *
 * @return bool|string a unique username, false on failure
 */
function simplesaml_generate_username_from_email($email) {
	$result = false;
	
	if (!empty($email) && validate_email_address($email)) {
		list($username) = explode("@", $email);
		
		// make sure the username is unique
		$result = simplesaml_generate_unique_username($username);
	}
	
	return $result;
}

/**
 * Make a username unique for use in the community.
 *
 * Some invalid characters will be filtered out,
 * and the username will be made unique by added numbers to the end.
 *
 * @param string $username the username to use as a base
 *
 * @return bool|string a unique username, false on failure
 */
function simplesaml_generate_unique_username($username) {
	$result = false;

	if (!empty($username)) {
		// filter invalid characters from username from validate_username()
		$username = preg_replace('/[^a-zA-Z0-9]/', "", $username);
			
		// check for min username length
		$minchars = (int) elgg_get_config("minusername");
		if (empty($minchars)) {
			$minchars = 4;
		}
			
		$username = str_pad($username, $minchars, "0", STR_PAD_RIGHT);
			
		// we have to be able to see all users
		$hidden = access_get_show_hidden_status();
		access_show_hidden_entities(true);
		
		$i = 1;
		// does this username exist
		if (get_user_by_username($username)) {
			// make a new one
			while (get_user_by_username($username . $i)) {
				$i++;
			}
				
			$result = $username . $i;
		} else {
			$result = $username;
		}
		
		// restore hidden entities
		access_show_hidden_entities($hidden);
	}

	return $result;
}

/**
 * Save the authenticaion attributes provided by the Service Provider (SP) for later use.
 *
 * @param ElggUser    $user        the user to store the attributes for
 * @param string      $saml_source the name of the Service Provider which provided the attributes
 * @param array|false $attributes  the attributes to save, false to remove all attributes
 *
 * @return void
 */
function simplesaml_save_authentication_attributes(ElggUser $user, $saml_source, $attributes = false) {

	if (!empty($user) && elgg_instanceof($user, "user") && !empty($saml_source) && simplesaml_is_enabled_source($saml_source)) {
		// remove the current attrributes
		elgg_unset_plugin_user_setting($saml_source . "_attributes", $user->getGUID(), "simplesaml");
		
		// are we allowed to save the attributes
		if (elgg_get_plugin_setting($saml_source . "_save_attributes", "simplesaml")) {
			// save settings
			if (!empty($attributes) && is_array($attributes)) {
				// filter some keys out of the attributes
				unset($attributes["elgg:firstname"]);
				unset($attributes["elgg:lastname"]);
				unset($attributes["elgg:email"]);
				unset($attributes["elgg:external_id"]);
				unset($attributes["elgg:username"]);
				unset($attributes["elgg:auto_link"]);
	
				elgg_set_plugin_user_setting($saml_source . "_attributes", json_encode($attributes), $user->getGUID(), "simplesaml");
			}
		}
	}
}

/**
 * Get the saved authentication attributes of a user.
 *
 * @param string      $saml_source    the name of the Service Provided to return the attributes from
 * @param bool|string $attribute_name if provided with an attribute name only that attribute will be returned, otherwise all attributes will be returned
 * @param int         $user_guid      the user GUID, defaults to the current logged in user
 *
 * @return bool|string|array array with attributes, or a string if attribute_name was provided, false on failure
 */
function simplesaml_get_authentication_user_attribute($saml_source, $attribute_name = false, $user_guid = 0) {
	$result = false;
	
	$user_guid = sanitise_int($user_guid, false);
	if (empty($user_guid)) {
		$user_guid = elgg_get_logged_in_user_guid();
	}
	
	if (!empty($user_guid)) {
		if (!empty($saml_source) && simplesaml_is_enabled_source($saml_source)) {
			$attributes = elgg_get_plugin_user_setting($saml_source . "_attributes", $user_guid, "simplesaml");
			if (!empty($attributes)) {
				$attributes = json_decode($attributes, true);
				
				if (!empty($attribute_name)) {
					$result = elgg_extract($attribute_name, $attributes, false);
				} else {
					$result = $attributes;
				}
			}
		}
	}
	
	return $result;
}

/**
 * Undo the extensions of the login form.
 *
 * @todo check the difference with simplesaml_unextend_login_form()
 * @see elgg_extend()
 *
 * @return void
 */
function simplesaml_undo_login_extends() {
	global $CONFIG;
	
	if (isset($CONFIG->views) && isset($CONFIG->views->extensions) && isset($CONFIG->views->extensions["forms/login"])) {
		foreach ($CONFIG->views->extensions["forms/login"] as $priority => $view) {
			if ($priority != 500) {
				unset($CONFIG->views->extensions["forms/login"][$priority]);
			}
		}
	}
	
	if (isset($CONFIG->views) && isset($CONFIG->views->extensions) && isset($CONFIG->views->extensions["login/extend"])) {
		$CONFIG->views->extensions["login/extend"] = array();
	}
}

/**
 * Get the user attributes for the provided IDendtity Provider (IDP) configuration.
 *
 * These attributes will be send to an external Service Provider.
 *
 * @param string $idp_auth_id the name of the IDP configuration
 *
 * @return array an array with all the configured attributes
 */
function simplesaml_get_user_attributes($idp_auth_id) {
	$result = null;
	
	$user = elgg_get_logged_in_user_entity();
	
	if (!empty($idp_auth_id) && !empty($user)) {
		$field_configuration = elgg_get_plugin_setting("idp_" . $idp_auth_id . "_attributes", "simplesaml");
		$site = elgg_get_site_entity();
		
		$result = array(
			"uid" => array($user->username . "@" . get_site_domain($site->getGUID()))
		);
		
		if (!empty($field_configuration)) {
			$field_configuration = json_decode($field_configuration, true);
			
			foreach ($field_configuration as $profile_field => $attribute_name) {
				if (!empty($attribute_name)) {
					
					$value = $user->$profile_field;
					if (!empty($value)) {
						if (!is_array($value)) {
							$value = array($value);
						}
						
						$result[$attribute_name] = $value;
					}
				}
			}

			/////////////////////////////////////////////////////////////////////////////
			 $obj = elgg_get_entities(array(
     			'type' => 'object',
     			'subtype' => 'gcpedia_account',
     			'owner_guid' => elgg_get_logged_in_user_guid()
			 ));
			 $gcpuser = $obj[0]->title;
			 $gcpemail =$obj[0]->description;
			 //if (elgg_get_context()=="saml"){
			 if ($gcpuser == NULL || $gcpuser == ""){
			 	forward("saml_link/link");
			 }
			//}
			 $result['GCPedia_user'] = array("GCPedia_user" =>$gcpuser);
			 $result['GCPedia_email'] = array("GCPedia_email" =>$gcpemail);
			 /////////////////////////////////////////////////////////////////////////////
		}
		
		$params = array(
			"user" => $user,
			"idp_auth_id" => $idp_auth_id,
			"attributes" => $result
		);
		$result = elgg_trigger_plugin_hook("idp_attributes", "simplesaml", $params, $result);
	}
	
	return $result;
}

/**
 * Get all the configured IDentity Providers (IDP) as configured in SimpleSAMLPHP.
 *
 * @return bool|array an array with the IDP configurations, false on failure
 */
function simplesaml_get_configured_idp_sources() {
	static $result;
	
	if (!isset($result)) {
		$result = false;
		
		if (class_exists("SimpleSAML_Auth_Source")) {
			$sources = SimpleSAML_Auth_Source::getSourcesOfType("authelgg:External");
			if (!empty($sources)) {
				$result = $sources;
			}
		}
	}
	
	return $result;
}

/**
 * Get a readable name for an IDentity Provider (IDP).
 *
 * The names can be provided in translation files by adding the key 'simplesaml:idp:label:<idp name>'.
 *
 * @param string $idp_source the name of the IDP
 *
 * @return string a readable name
 */
function simplesaml_get_idp_label($idp_source) {
	$result = $idp_source;

	if (!empty($idp_source)) {
		$lan_key = "simplesaml:idp:label:" . $idp_source;
			
		if (elgg_echo($lan_key) != $lan_key) {
			$result = elgg_echo($lan_key);
		}
	}

	return $result;
}

/**
 * This function checks if authentication needs to be forces over an authentication source.
 *
 * @return void
 */
function simplesaml_check_force_authentication() {
	if (elgg_is_logged_in()) {
		// no need to do anything if already logged in
		return;
	}
	
	if (isset($_GET["disable_sso"])) {
		// bypass for sso
		return;
	}
	
	if (strpos(current_page_url(), elgg_get_site_url() . "saml/no_linked_account") === 0) {
		// do not force authentication on the no_linked_account page
		return;
	}
	
	// get the plugin setting that defines force authentications
	$setting = elgg_get_plugin_setting("force_authentication", "simplesaml");
	if (!empty($setting)) {
		// check if the authentication source is enabled
		if (simplesaml_is_enabled_source($setting)) {
				
			// make sure we can forward you to the correct url
			if (!isset($_SESSION["last_forward_from"])) {
				$_SESSION["last_forward_from"] = current_page_url();
			}
			forward("saml/login/" . $setting);
		}
	}
}

/**
 * Check if auto creation of accounts is enabled for this source and we have all the required information.
 *
 * The required information is:
 * - email address (needed for all accounts in Elgg)
 * - firstname and/or lastname (for the displayname)
 * - external_id (so we can link accounts)
 *
 * @param string $source          the name of the authentication source
 * @param array  $auth_attributes the authentication attributes
 *
 * @return bool true is allowed and enough information, false otherwise
 */
function simplesaml_check_auto_create_account($source, $auth_attributes) {
	$result = false;
	
	if (!empty($source) && !empty($auth_attributes) && is_array($auth_attributes)) {
		// is the source enabled
		if (simplesaml_is_enabled_source($source)) {
			// check if auto create is enabled for this source
			if (elgg_get_plugin_setting($source . "_auto_create_accounts", "simplesaml")) {
				// do we have all the require information
				$email = elgg_extract("elgg:email", $auth_attributes);
				$firstname = elgg_extract("elgg:firstname", $auth_attributes);
				$lastname = elgg_extract("elgg:lastname", $auth_attributes);
				$external_id = elgg_extract("elgg:external_id", $auth_attributes);
				
				if (!empty($email) && (!empty($firstname) || !empty($lastname)) && !empty($external_id)) {
					$result = true;
				}
			}
		}
	}
	
	return $result;
}
