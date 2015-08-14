<?php

$source = elgg_extract("saml_source", $vars);
$allow_registration = (bool) elgg_extract("allow_registration", $vars, false);

$label = simplesaml_get_source_label($source);
$login_class = "pam";

echo "<div class='mbm'>";
echo elgg_echo("simplesaml:no_linked_account:description", array($label));
echo "</div>";

echo "<div id='simplesaml-no-linked-account-module-wrapper'>";

// allow registration
if ($allow_registration) {
	$body_vars = array(
		"saml_source" => $source,
	);
	
	// show register box
	echo elgg_view_module("popup", elgg_echo("register"), elgg_view_form("simplesaml/register", null, $body_vars), array("class" => "pam mbl"));
	
	// show header for if you already have an account
	$login_class .= " hidden mtm";
	echo elgg_view("output/url", array("href" => "#simplesaml-no-linked-account-login", "text" => elgg_echo("simplesaml:no_linked_account:login"), "rel" => "toggle"));
}

// no registration link
$global_registration = elgg_get_config("allow_registration");
elgg_set_config("allow_registration", false);

echo elgg_view_module("popup", elgg_echo("login"), elgg_view_form("login"), array("class" => $login_class, "id" => "simplesaml-no-linked-account-login"));

// restore registration settings
elgg_set_config("allow_registration", $global_registration);

echo "</div>";
