<?php

namespace ColdTrick\SimpleSAML;

class PageHandler {
	
	/**
	 * The page handler for all saml/ pages
	 *
	 * @param array $page the array of the different page elements
	 *
	 * @return bool
	 */
	public static function saml($page) {
		
		$pages_path = elgg_get_plugins_path() . 'simplesaml/pages/';
		$include_file = false;
		
		switch ($page[0]) {
			case 'login':
				if (!empty($page[1])) {
					set_input('saml_source', $page[1]);
				}
					
				$include_file = "{$pages_path}login.php";
				break;
			case 'no_linked_account':
				if (!empty($page[1])) {
					set_input('saml_source', $page[1]);
				}
					
				$include_file = "{$pages_path}no_linked_account.php";
				break;
			case 'authorize':
				if (!empty($page[1])) {
					set_input('saml_source', $page[1]);
				}
		
				$include_file = "{$pages_path}authorize.php";
				break;
			case 'idp_login':
				$include_file = "{$pages_path}idp_login.php";
				break;
		}
		
		if (!empty($include_file)) {
			include($include_file);
			return true;
		}
		
		return false;
	}
}
