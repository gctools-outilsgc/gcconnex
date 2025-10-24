<?php
$auth_url = elgg_get_plugin_setting('auth_url', 'pleio');

$result = logout();

if ($result) {
    forward($auth_url . "logout");
} else {
    register_error(elgg_echo('logouterror'));
}
