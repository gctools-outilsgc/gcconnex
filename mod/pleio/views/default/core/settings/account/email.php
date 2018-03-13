<?php
$auth_url = elgg_get_plugin_setting('auth_url', 'pleio', $CONFIG->pleio->url);

$user = elgg_get_page_owner_entity();
if ($user) {
    $title = elgg_echo("pleio:change_settings");
    
    $link = elgg_view("output/url", [
        "href" => $auth_url . "settings/user",
        "text" => "Pleio",
        "target" => "_blank"
    ]);

    $content = elgg_echo("pleio:change_settings:description", [$link]);

    echo elgg_view_module("info", $title, $content);
}
