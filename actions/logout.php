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
    //forward to login screen on logout - Nick 
	
	// cyu - if saml plugin is enabled, forward the url to saml link. otherwise forward to normal url.
	if (elgg_is_active_plugin('saml_link') || elgg_is_active_plugin('simplesaml'))
		forward("http://gcconnex.gc.ca/simplesaml/saml2/idp/SingleLogoutService.php?ReturnTo=".elgg_get_site_url(). 'login');
	else
		forward(elgg_get_site_url(). 'login');

} else {
	register_error(elgg_echo('logouterror'));
}