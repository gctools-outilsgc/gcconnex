<?php
/**
 * Show the login form to external users, so they can login to the external site using this sites credentials
 *
 * No credentials will be provided to the external site, only a name, email and a generated UID
 */

$relay = htmlspecialchars(urldecode($_GET["ReturnTo"]));
$relay = parse_url($relay, PHP_URL_QUERY);
$relay = strstr($relay,'RelayState=');
$relay = urldecode(strstr($relay,'http'));
$relay = parse_url($relay, PHP_URL_QUERY);
$lang = substr($relay, strpos($relay,'=')+1);

//$lang = htmlspecialchars($_GET["lang"]);

$clean_domain = str_replace(array('https://', 'http://', '/', 'www.'), '', elgg_get_site_url());
$domain = (strpos(elgg_get_site_entity()->name, 'collab') !== false) ? '.' . $clean_domain : $clean_domain;

if (!$lang){
	$lang = 'en';
}

if ($_COOKIE["connex_lang"]){

	if ($lang!=$_COOKIE["connex_lang"]){
		setcookie("connex_lang", $lang, 0, '/', $domain);
		header("Refresh:0");
	}
}else {
	setcookie("connex_lang", $lang, 0, '/', $domain);
	header("Refresh:0");
} 

elgg_load_css('special-saml');
// where to go after authentication
$returnTo = get_input("ReturnTo");
if (!empty($returnTo)) {
	if (elgg_is_logged_in()) {
		forward($returnTo);
	} else {
		$_SESSION["last_forward_from"] = $returnTo;
	}
}

// unset some extends
simplesaml_undo_login_extends();

// disable registration for this page
elgg_set_config("allow_registration", false);

// get page elements
$title_text = elgg_echo("simplesaml:login:title");
$body= elgg_echo("simplesaml:login:body");
$body .= elgg_echo("simplesaml:login:body:other");
$body .= elgg_view_form("login");
$body .= elgg_echo("simplesaml:register-password");
// make the page
$page_data = elgg_view_layout("one_column", array(
	"title" => $title_text,
	"content" => $body
));

// draw the page
echo elgg_view_page($title_text, $page_data);
