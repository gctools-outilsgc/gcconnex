<?php

$source = elgg_extract("saml_source", $vars);
$label = simplesaml_get_source_label($source);

$saml_attributes = $_SESSION["saml_attributes"];

echo "<div class='mbm'>";
echo elgg_echo("simplesaml:forms:register:description", array($label));
echo "</div>";

// check for missing fields
// we need name and email
if (!elgg_extract("elgg:firstname", $saml_attributes) && !elgg_extract("elgg:lastname", $saml_attributes)) {
	// no name fields, so ask
	echo "<div>";
	echo "<label>" . elgg_echo("name") . "</label>";
	echo elgg_view("input/text", array("name" => "displayname"));
	echo "</div>";
}

if (!elgg_extract("elgg:email", $saml_attributes)) {
	// no email field, so ask
	echo "<div>";
	echo "<label>" . elgg_echo("email") . "</label>";
	echo elgg_view("input/email", array("name" => "email"));
	echo "</div>";
}

echo "<div class='elgg-foot'>";
echo elgg_view("input/hidden", array("name" => "saml_source", "value" => $source));
echo elgg_view("input/submit", array("value" => elgg_echo("register")));
echo "</div>";
