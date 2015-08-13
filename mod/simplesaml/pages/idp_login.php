<?php

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

// disable registration for this page --- NOT - Troy T Lawson
elgg_set_config("allow_registration", true);

// get page elements
//$title_text = elgg_echo("<div class='myclass'>");
$title_text = elgg_echo("simplesaml:login:title");
$body= elgg_echo("simplesaml:login:body");
$body .= elgg_echo("simplesaml:login:body:other");
$body .= elgg_view_form("login");
$body .= elgg_echo("</div>");

// make the page
$page_data = elgg_view_layout("one_column", array(
	"title" => $title_text,
	"content" => $body
));

// draw the page
//echo elgg_get_context();
echo elgg_view_page($title_text, $page_data);
