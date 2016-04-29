<?php
/**
 * Elgg login action
 *
 * @package Elgg.Core
 * @subpackage User.Authentication
 */

$session = elgg_get_session();
//break
// set forward url
if ($session->has('last_forward_from')) {
	$forward_url = $session->get('last_forward_from');
	$forward_source = 'last_forward_from';
} elseif (get_input('returntoreferer')) {
	$forward_url = REFERER;
	$forward_source = 'return_to_referer';
} else {
	// forward to main index page
	$forward_url = '';
	$forward_source = null;
}

$username = get_input('username');
$password = get_input('password', null, false);
$persistent = (bool) get_input("persistent");
$result = false;

if (empty($username) || empty($password)) {
	register_error(elgg_echo('login:empty'));
	forward();
}

// check if logging in with email address
if (strpos($username, '@') !== false && ($users = get_user_by_email($username))) {
	$username = $users[0]->username;
}

$result = elgg_authenticate($username, $password);
if ($result !== true) {
	register_error($result);
	forward(REFERER);
}

$user = get_user_by_username($username);
if (!$user) {
	register_error(elgg_echo('login:baduser'));
	forward(REFERER);
}

try {
	login($user, $persistent);
	// re-register at least the core language file for users with language other than site default
	register_translations(dirname(dirname(__FILE__)) . "/languages/");
} catch (LoginException $e) {
	register_error($e->getMessage());
	forward(REFERER);
}
//error_log($_SERVER['HTTP_REFERER']);
//error_log(elgg_get_site_url()."saml/idp_login");
// elgg_echo() caches the language and does not provide a way to change the language.
// @todo we need to use the config object to store this so that the current language
// can be changed. Refs #4171
$display_name = $user->name;
//setcookie('connex_lang', $user->language, time()+(1000 * 60 * 60 * 24), '/');
if ($user->language) {
//give user a custom welcome message
	$message = elgg_echo('wet:loginok', array($display_name));
} else {
	$message = elgg_echo('wet:loginok', array($display_name));
}

// clear after login in case login fails
$session->remove('last_forward_from');

$params = array('user' => $user, 'source' => $forward_source);



if (strpos($_SERVER['HTTP_REFERER'], elgg_get_site_url()."saml/idp_login")=== false){
	$forward_url = elgg_trigger_plugin_hook('login:forward', 'user', $params, $forward_url);
}else{
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
			 }else{
			 	$forward_url = "http://gcconnex.gc.ca/simplesaml/saml2/idp/SSOService.php?spentityid=http://www.gcpedia.gc.ca/simplesaml/module.php/saml/sp/metadata.php/elgg-idp&RelayState=http://www.gcpedia.gc.ca";
		 	
			 }
	
}

system_message($message);
//comment oout for SSO


forward($forward_url);
