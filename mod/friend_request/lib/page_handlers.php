<?php
/**
 * All page handlers are bundled here
 */

/**
 * The friends request page handler
 *
 * @param array $page the page elements
 *
 * @return bool
 */
function friend_request_page_handler($page) {

	if (isset($page[0])) {
		set_input("username", $page[0]);
	}

	include(dirname(dirname(__FILE__)) . "/pages/index.php");
	return true;
}