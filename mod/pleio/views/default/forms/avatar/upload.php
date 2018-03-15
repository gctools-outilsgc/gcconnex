<?php
$auth_url = elgg_get_plugin_setting('auth_url', 'pleio');

$link = elgg_view("output/url", [
    "href" => $auth_url . "profile",
    "text" => "Pleio",
    "target" => "_blank"
]);

echo elgg_echo("pleio:change_settings:description", [$link]);