<?php

namespace ColdTrick\SimpleSAML;

class Login {
	
	/**
	 * Take some actions during the login event of a user
	 *
	 * @param string   $event  the name of the event
	 * @param string   $type   type of the event
	 * @param ElggUser $object the current user trying to login
	 *
	 * @return void
	 */
	public static function loginEvent($event, $type, $object) {
		
		if (!($object instanceof \ElggUser)) {
			return;
		}
		
		$saml_attributes = simplesaml_get_from_session('saml_attributes');
		$source = simplesaml_get_from_session('saml_source');
		
		// simplesaml login?
		if (!isset($saml_attributes) || !isset($source)) {
			return;
		}
		
		// source enabled
		if (!simplesaml_is_enabled_source($source)) {
			return;
		}
		
		// validate additional authentication rules
		if (!simplesaml_validate_authentication_attributes($source, $saml_attributes)) {
			return;
		}
		
		// link the user to this source
		$saml_uid = elgg_extract('elgg:external_id', $saml_attributes);
		if (!empty($saml_uid)) {
			if (is_array($saml_uid)) {
				$saml_uid = $saml_uid[0];
			}
			
			// save the external id so the next login will go faster
			simplesaml_link_user($object, $source, $saml_uid);
		}
		
		// save the attributes to the user
		simplesaml_save_authentication_attributes($object, $source, $saml_attributes);
		
		// save source name for single logout
		simplesaml_store_in_session('saml_login_source', $source);
		
		// cleanup
		simplesaml_remove_from_session('saml_attributes');
		simplesaml_remove_from_session('saml_source');
	}
}
