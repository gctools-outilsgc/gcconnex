<?php
/**
 * All page handlers for this plugin will be handled in this file
 */

/**
 * The page handler for all saml/ pages
 *
 * @param array $page the array of the different page elements
 *
 * @return bool true if we get a valid page, false on failure
 */
function simplesaml_page_handler($page) {
	$result = false;
	$include_file = "";
	
	switch ($page[0]) {
		case "login":
			if (!empty($page[1])) {
				set_input("saml_source", $page[1]);
			}
			
			$include_file = dirname(dirname(__FILE__)) . "/procedures/login.php";
			break;
		case "no_linked_account":
			if (!empty($page[1])) {
				set_input("saml_source", $page[1]);
			}
			
			$include_file = dirname(dirname(__FILE__)) . "/pages/no_linked_account.php";
			break;
		case "authorize":
			if (!empty($page[1])) {
				set_input("saml_source", $page[1]);
			}
		
			$include_file = dirname(dirname(__FILE__)) . "/procedures/authorize.php";
			break;
		case "idp_login":
			$include_file = dirname(dirname(__FILE__)) . "/pages/idp_login.php";
			break;
	}
	
	if (!empty($include_file)) {
		$result = true;
		
		include($include_file);
	}
	
	return $result;
}
