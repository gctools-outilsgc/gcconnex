<?php
/**
 * Elgg logout action
 *
 * @package Elgg
 * @subpackage Core
 */

// Log out
$result = logout();

// Set the system_message as appropriate
if ($result) {
	system_message(elgg_echo('logoutok'));
	//forward(elgg_get_site_url());
	//forward("http://gcconnex.gc.ca/simplesaml/saml2/idp/SingleLogoutService.php?ReturnTo=http://gcconnex.gc.ca");
} else {
	register_error(elgg_echo('logouterror'));
}