<?php
/**
 * User Menu
 * Access profile/messages/colleagues/settings
 */
/*
// Elgg logo
echo elgg_view_menu('topbar', array('sort_by' => 'priority', array('elgg-menu-hz')));

// elgg tools menu
// need to echo this empty view for backward compatibility.
echo elgg_view_deprecated("navigation/topbar_tools", array(), "Extend the topbar menus or the page/elements/topbar view directly", 1.8);
*/

$site_url = elgg_get_site_url();

elgg_register_menu_item('login_menu', array(
    'name' => 'Log in',
    'href' => $site_url . 'login/',
    'text' => 'Login/Register',
    'title' => 'Log in',
    ));


echo elgg_view_menu('login_menu', array('sort_by' => 'priority', 'class' => 'list-inline'));
?>