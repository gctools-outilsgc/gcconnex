<?php
/**
 * user_menu.php
 *
 * Access profile/messages/colleagues/settings
 *
 * @package wet4
 * @author GCTools Team
 */
/*


// elgg tools menu
// need to echo this empty view for backward compatibility.
echo elgg_view_deprecated("navigation/topbar_tools", array(), "Extend the topbar menus or the page/elements/topbar view directly", 1.8);
*/

$site_url = elgg_get_site_url();
$user = elgg_get_logged_in_user_entity()->username;
$displayName = elgg_get_logged_in_user_entity()->name;
$user_avatar = elgg_get_logged_in_user_entity()->geticonURL('small');
$email = elgg_get_logged_in_user_entity()->email;


elgg_register_menu_item('user_menu_subMenu', array(
    'name' => 'profile_link',
    'text' => elgg_echo('userMenu:profile'),
    'href' => 'profile/' . $user,
    'priority' => 100,
));

elgg_register_menu_item('user_menu_subMenu', array(
    'name' => 'settings_link',
    'text' => elgg_echo('userMenu:account'),
    'href' => 'settings/user/' . $user,
    'priority' => 200,
));
elgg_register_menu_item('user_menu_subMenu', array(
    'name' => 'logout_link',
    'text' => elgg_echo('logout'),
    'href' => 'action/logout',
    'priority' => 300,
));

$dropdown = elgg_view_menu('user_menu_subMenu', array('class' => 'dropdown-menu'));


$focus_dd = '<a href="#" class="focus_dd_link" style="display:none;"><i class="fa fa-caret-down" aria-hidden="true"></i><span class="wb-inv">'.elgg_echo('wet:dd:expand').'</span></a>';

//admin link
//check to see if user is an admin
if(elgg_is_admin_logged_in()) {
    elgg_register_menu_item('user_menu', array(
        'name' => 'Admin',
        'href' => $site_url . 'admin',
        'text' => '<i class="fa fa-wrench fa-lg mrgn-rght-sm"></i>' . '<span class="hidden-xs">Admin</span>',
        'title' => 'Admin',
        'item_class' => 'brdr-rght',
        'class' => '',
        'priority' => '0',
    ));
}


//create initial badge

$breakup = explode('.', $email);
$initials = substr($breakup[0], 0, 1) . substr($breakup[1], 0, 1);
if ($user_avatar) { //show avatar if they have one
    $dropdown_avatar = '<span><img class="img-circle mrgn-rght-sm" src="'.$user_avatar.'"></span>';

    //EW - render to display badge instead
    $dropdown_avatar = elgg_view_entity_icon(elgg_get_logged_in_user_entity(), 'small', array('use_hover' => false, 'use_link' => false, 'class' => 'userMenuAvatar'));
} else { // show initials if the don't
    $dropdown_avatar = '<span class="init-badge">' . strtoupper($initials) . '</span>';
}


//create user menu
elgg_register_menu_item('user_menu', array(
    'name' => 'Profile',
    'text' => $dropdown_avatar. '<span class="hidden-xs">' . $displayName . '</span><i class="fa fa-caret-down fa-lg mrgn-lft-sm"></i>' . $dropdown,
    'title' => elgg_echo('userMenu:usermenuTitle'),
    'item_class' => 'brdr-lft dropdown',
    'data-toggle' => 'dropdown',
    'class' => 'dropdown-toggle  dropdownToggle dd-close',
    'priority' => '3',
    'aria-hidden' => 'true',
    'tab-index'=>'0', //If the tab index is gone perhaps the screen reader will skip it? What about sighted people with out mouse, need to test, just an idea :3
    //Google has some kind of tab loop when the the card is open, so when the user tabs they only tab through the options in the card
    ));


//screen reader links
elgg_register_menu_item('user_menu', array(
    'name' => 'sr_profile',
    'text' => elgg_echo('userMenu:profile'),
    'href' => 'profile/'.elgg_get_logged_in_user_entity()->username,
    'item_class' => 'wb-invisible sr_menu_item',
    'tabindex' => '-1',
));

elgg_register_menu_item('user_menu', array(
    'name' => 'sr_account',
    'text' => elgg_echo('userMenu:account'),
    'href' => 'settings/user/'.elgg_get_logged_in_user_entity()->username,
    'item_class' => 'wb-invisible sr_menu_item',
    'tabindex' => '-1',
));

elgg_register_menu_item('user_menu', array(
    'name' => 'sr_logout',
    'text' => elgg_echo('logout'),
    'href' => 'action/logout',
    'item_class' => 'wb-invisible sr_menu_item',
    'tabindex' => '-1',
));

// notifications inbox menu item
elgg_register_menu_item('user_menu', array(
    'name' => 'notifications',
    'text' =>'<i class="fa fa-bell mrgn-rght-sm mrgn-tp-sm fa-lg"></i><span class="hidden-xs" aria-hidden="true">' . elgg_echo('notifications:subscriptions:changesettings') . '</span>' . $msgbadge .'<span class="wb-inv">'.elgg_echo('userMenu:notifications') . $title.' </span></a>',
    'title' => elgg_echo('userMenu:notifications') . $title,
    'item_class' => 'brdr-lft messagesLabel close-notif-dd',
    'class' => '',
    'priority' => '2',
    'data-dd-type'=>'notif_dd',
    'href' => elgg_get_site_url()."messages/notifications/" . $user,
    ));


/*

Colleague menu item runs in start.php - sorry

*/

// cyu - remove the user menu when the gsa hits the page
if ( strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') !== false )
{
    // do nothing
} else {
	echo elgg_view_menu('user_menu', array('sort_by' => 'priority', 'id' => 'userMenu', 'class' => 'list-inline visited-link'));
}
