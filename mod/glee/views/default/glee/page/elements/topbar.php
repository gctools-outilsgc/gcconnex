<?php
/**
 * Elgg topbar
 */

$site = elgg_get_site_entity();
$site_name = $site->name;
$site_url = elgg_get_site_url();


$content       = "";
$content_left  = "";
$content_right = "";

// BRAND NAME
$brand_name = <<<HTML
<a class="brand" href="$site_url">$site->name</a>
HTML;

// TOPBAR NAVIGATION
$topbar_menu = elgg_view_menu('topbar', array('sort_by' => 'priority', array('elgg-menu-hz')));

$content .= $brand_name;
$content .= $topbar_menu;


// LOGIN DROPDOWN
if (!elgg_is_logged_in()) {
    // drop-down login
    $login_dropdown =  elgg_view('core/account/login_dropdown');
    
    // add it to the left
    $content_left .= $login_dropdown;
}

// LOGIN TEXT
if (elgg_is_logged_in()) {
    // "logged in as [username]"
    $username = elgg_get_logged_in_user_entity()->name;
    $url = elgg_get_logged_in_user_entity()->getURL();
    
    $login_text = "<p class=\"navbar-text\">" . elgg_echo('admin:loggedin', array("<a href=\"$url\">$username</a>")) . "</p>";
    
    // add it to the right
    $content_right .= $login_text;
}

$output = <<<HTML
    <div class="pull-left">
        $content_left
    </div>
    $content
    <div class="pull-right">
        $content_right
    </div>
HTML;

echo $output;