<?php
$css_url = 'mod/saml_link/vendor/special.css';
elgg_register_css('special', $css_url, -10);

elgg_register_action("saml_link/save", elgg_get_plugins_path() . "saml_link/actions/saml_link/save.php");
elgg_register_action("saml_link/link", elgg_get_plugins_path() . "saml_link/actions/saml_link/link.php");
elgg_register_action("saml_link/setting", elgg_get_plugins_path() . "saml_link/actions/saml_link/settings.php");

elgg_register_page_handler('saml_link', 'saml_link_page_handler');

function saml_link_page_handler($segments) {
    if ($segments[0] == 'add') {
        include elgg_get_plugins_path() . 'saml_link/pages/saml_link/add.php';
        return true;
    }
    if ($segments[0] == 'link') {
        include elgg_get_plugins_path() . 'saml_link/pages/saml_link/link.php';
        return true;
    }
    return false;
}