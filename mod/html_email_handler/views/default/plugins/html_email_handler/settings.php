<?php

$plugin = elgg_extract("entity", $vars);

$noyes_options = array(
	"no" => elgg_echo("option:no"),
	"yes" => elgg_echo("option:yes")
);

$embed_options = array(
	"no" => elgg_echo("option:no"),
	"base64" => elgg_echo("html_email_handler:settings:embed_images:base64"),
	"attach" => elgg_echo("html_email_handler:settings:embed_images:attach"),
);

$site_email = elgg_get_site_entity()->email;

// present settings
echo "<div>";
echo elgg_echo("html_email_handler:settings:notifications:description");
echo "</div>";

echo "<div>";
echo elgg_echo("html_email_handler:settings:notifications");
echo elgg_view("input/select", array("name" => "params[notifications]", "options_values" => $noyes_options, "value" => $plugin->notifications, "class" => "mls"));
echo "<div class='elgg-subtext'>" . elgg_echo("html_email_handler:settings:notifications:subtext") . "</div>";
echo "</div>";

echo "<div>";
echo elgg_echo("html_email_handler:settings:sendmail_options");
echo elgg_view("input/text", array("name" => "params[sendmail_options]", "value" => $plugin->sendmail_options));
echo "<div class='elgg-subtext'>" . elgg_echo("html_email_handler:settings:sendmail_options:description", array($site_email)) . "</div>";
echo "</div>";

echo "<div>";
echo elgg_echo("html_email_handler:settings:limit_subject");
echo elgg_view("input/select", array("name" => "params[limit_subject]", "options_values" => $noyes_options, "value" => $plugin->limit_subject, "class" => "mls"));
echo "<div class='elgg-subtext'>" . elgg_echo("html_email_handler:settings:limit_subject:subtext") . "</div>";
echo "</div>";

echo "<div>";
echo elgg_echo("html_email_handler:settings:embed_images");
echo elgg_view("input/select", array("name" => "params[embed_images]", "options_values" => $embed_options, "value" => $plugin->embed_images, "class" => "mls"));
echo "<div class='elgg-subtext'>" . elgg_echo("html_email_handler:settings:embed_images:subtext") . "</div>";
echo "</div>";

echo "<div>";
echo elgg_echo("html_email_handler:settings:proxy_host");
echo elgg_view("input/text", array("name" => "params[proxy_host]", "value" => $plugin->proxy_host));
echo "</div>";

echo "<div>";
echo elgg_echo("html_email_handler:settings:proxy_port");
echo elgg_view("input/text", array("name" => "params[proxy_port]", "value" => $plugin->proxy_port));
echo "</div>";