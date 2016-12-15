<?php
/**
 * In this file all the event handlers are defined.
 *
 */

/**
 * Take some actions during the login event of a user
 *
 * @param string   $event  'login' is the event this function handles
 * @param string   $type   'user' is the type for this event
 * @param ElggUser $object the current user trying to login
 *
 * @return void
 */
function simplesaml_login_event_handler($event, $type, $object) {
	
	if (!empty($object) && elgg_instanceof($object, "user")) {
		
		if (isset($_SESSION["saml_attributes"]) && isset($_SESSION["saml_source"])) {
			
			$saml_attributes = $_SESSION["saml_attributes"];
			$source = $_SESSION["saml_source"];
			
			if (simplesaml_is_enabled_source($source)) {
				$saml_uid = elgg_extract("elgg:external_id", $saml_attributes);
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
				$_SESSION["saml_login_source"] = $source;
			}
			
			unset($_SESSION["saml_attributes"]);
			unset($_SESSION["saml_source"]);
		}
	}
	///////////////////////////////
	setcookie('connex_lang', elgg_get_logged_in_user_entity()->language, time()+(1000 * 60 * 60 * 24), '/');
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	//auto login to GCpedia
	
	$pageurl=$_SERVER['HTTP_REFERER'];
	
	$pageurl = strstr($pageurl, '?', true);
	//$pageurl = substr($pageurl, 0, strlen($pageurl));
	if ($pageurl != elgg_get_site_url()."saml/idp_login"){
		//system_message('this thing: '.$pageurl);
	//forward("http://www.google.com");	
	//change adds session for use with share button
	$session = elgg_get_session();
	if ($session->has('last_forward_from')) {
		$forward_url = $session->get('last_forward_from');
		$forward_source = 'last_forward_from';
	}else{
		$forward_url = elgg_get_site_url();
	}
	//forward(REFERER);
	$obj = elgg_get_entities(array(
     	'type' => 'object',
     	'subtype' => 'gcpedia_account',
     	'owner_guid' => elgg_get_logged_in_user_guid()
		));
		$gcpuser = $obj[0]->title;
		if ($gcpuser){
			forward("http://".$_SERVER[HTTP_HOST]."/simplesaml/saml2/idp/SSOService.php?spentityid=".elgg_get_plugin_setting('gcpedia_url','saml_link')."simplesaml/module.php/saml/sp/metadata.php/elgg-idp&RelayState=$forward_url");
		 	
		}
	//
	}
}
