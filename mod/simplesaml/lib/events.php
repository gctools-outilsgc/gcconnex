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
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	//auto login to GCpedia
	
	$pageurl=$_SERVER['HTTP_REFERER'];
	$pageurl = strstr($pageurl, '?', true);
	//$pageurl = substr($pageurl, 0, strlen($pageurl));
	if ($pageurl != 'http://gcconnex.gc.ca/saml/idp_login'){
		//system_message('this thing: '.$pageurl);
		
	
	//forward(REFERER);
	$obj = elgg_get_entities(array(
     	'type' => 'object',
     	'subtype' => 'gcpedia_account',
     	'owner_guid' => elgg_get_logged_in_user_guid()
		));
		$gcpuser = $obj[0]->title;
		if ($gcpuser){
			forward("http://gcconnex.gc.ca/simplesaml/saml2/idp/SSOService.php?spentityid=http://www.gcpedia.gc.ca/simplesaml/module.php/saml/sp/metadata.php/elgg-idp&RelayState=http://gcconnex.gc.ca");
		 	//forward("http://gcconnex.gc.ca/saml/idp_login?ReturnTo=http%3A%2F%2Fgcconnex.gc.ca%2Fsimplesaml%2Fmodule.php%2Fauthelgg%2Fresume.php%3FState%3D_212d89efd0067695ec5654acc522617eb569e0c544%253Ahttp%253A%252F%252Fgcconnex.gc.ca%252Fsimplesaml%252Fsaml2%252Fidp%252FSSOService.php%253Fspentityid%253Dhttp%25253A%25252F%25252Fwww.gcpedia.gc.ca%25252Fsimplesaml%25252Fmodule.php%25252Fsaml%25252Fsp%25252Fmetadata.php%25252Felgg-idp%2526cookieTime%253D1426181995%2526RelayState%253Dhttp%25253A%25252F%25252Fgcconnex.gc.ca");
			//forward("http://www.google.com");
		}
	//
	}
}
