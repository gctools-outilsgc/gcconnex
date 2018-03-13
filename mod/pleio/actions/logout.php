<?php
if (!elgg_is_logged_in()) {
    forward("/");
}

$auth = elgg_get_plugin_setting('auth', 'pleio');
$auth_url = elgg_get_plugin_setting('auth_url', 'pleio', $CONFIG->pleio->url);

if ($auth == 'oidc') {
	$auth_url = str_replace("openid", "", $auth_url);
}

$result = logout();
if ($result) {
    forward($auth_url . "action/logout");
} else {
    register_error(elgg_echo('logouterror'));
}