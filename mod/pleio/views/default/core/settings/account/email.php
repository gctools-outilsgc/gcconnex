<?php
$auth = elgg_get_plugin_setting('auth', 'pleio');
$auth_url = elgg_get_plugin_setting('auth_url', 'pleio');

if ($auth == 'oidc') {
	$auth_url = str_replace("openid", "", $auth_url);
}

$user = elgg_get_page_owner_entity();
if ($user) {
    $title = elgg_echo("pleio:change_settings");
    
    $link = elgg_view("output/url", [
        "href" => $auth_url . "profile",
        "text" => "GCcollab Account",
        "target" => "_blank"
    ]);

    $content = elgg_echo("pleio:change_settings:description", [$link]);

    echo elgg_view_module("info", $title, $content);
}
