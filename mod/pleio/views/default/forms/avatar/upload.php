<?php
$auth = elgg_get_plugin_setting('auth', 'pleio');
$auth_url = elgg_get_plugin_setting('auth_url', 'pleio', $CONFIG->pleio->url);

if ($auth == 'oidc') {
    $auth_url = str_replace("openid", "", $auth_url);
}

$link = elgg_view("output/url", [
    "href" => $auth_url . "profile",
    "text" => "Pleio",
    "target" => "_blank"
]);

echo elgg_echo("pleio:change_settings:description", [$link]);
