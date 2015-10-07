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
$user = get_loggedin_user()->username;
$user_avatar = get_loggedin_user()->geticonURL('small');


//create dropdown menu
elgg_register_menu_item('user_menu_subMenu', array(
    'name' => 'Dashboard',
    'href' => 'dashboard',
    'text' => 'Dashboard',
    'title' => 'My Dashboard',
    'class' => 'brdr-bttm',
    ));

elgg_register_menu_item('user_menu_subMenu', array(
    'name' => 'Account Settings',
    'href' => 'settings',
    'text' => 'Account Settings',
    'title' => 'Account Settings',
    'class' => 'brdr-bttm mrgn-bttm-sm',
    ));

elgg_register_menu_item('user_menu_subMenu', array(
    'name' => 'Log out',
    'href' => $site_url . 'action/logout',
    'text' => 'Log out',
    'title' => 'Log out',
    ));


$dropdown = elgg_view_menu('user_menu_subMenu', array('class' => 'dropdown-menu pull-right subMenu'));


//create user menu
elgg_register_menu_item('user_menu', array(
    'name' => 'Profile',
    'href' => $site_url . 'profile/' . $user,
    'text' => 'Profile',
    'title' => 'My Profile',
    'item_class' => 'brdr-rght',
    'class' => 'profile-avatar',
    'priority' => '1',
    ));

if(elgg_is_active_plugin('messages')){
    $unread = messages_count_unread();
    
    $msgbadge = "<span class='badge'>" . $unread . "</span>";
    
    $title = ' - New(' . $unread . ')';
    
    if($unread == 0){
        $msgbadge = '';
        $title = '';
    }
} 
elgg_register_menu_item('user_menu', array(
    'name' => 'messages',
    'href' => 'messages/inbox/' . $user,
    'text' => 'Messages' . $msgbadge,
    'title' => 'My Messages' . $title,
    'item_class' => 'brdr-rght ',
    'class' => 'msg-icon',
    'priority' => '2',
    ));

/*elgg_register_menu_item('user_menu', array(
    'name' => 'Colleagues',
    'href' => 'friends/' . $user,
    'text' => 'Colleagues',
    'title' => 'My Colleagues',
    'item_class' => 'brdr-rght',
    'class' => 'friend-icon',
    'priority' => '3',
    ));*/

elgg_register_menu_item('user_menu', array(
    'name' => 'Settings',

    'text' => 'Settings' . $dropdown,
    'title' => 'My Settings Menu',
    'item_class' => 'dropdown',
    'data-toggle' => 'dropdown',
    'class' => ' dropdown-toggle settings-icon dropdownToggle',
    'priority' => '4',
    ));



echo elgg_view_menu('user_menu', array('sort_by' => 'priority', 'class' => 'list-inline'));
?>

<style>
    
    .subMenu .dropdownToggle {
        display: none;
    }
    
    .profile-avatar {
        padding-left: 27px;
        background: transparent url(<?php echo $user_avatar ?>) no-repeat left;
        background-size: 25px;
        height: 25px;
    }
    
    .msg-icon {
        padding-left: 23px;
        background: transparent url(<?php echo $site_url ?>/_graphics/elgg_sprites.png) no-repeat left;
        background-position: 0 -644px;
        height: 20px;
    }
    
    .msg-icon:hover {
        background-position: 0 -626px;
        
    }
    
    .friend-icon {
        padding-left: 23px;
        height: 20px;
        background: transparent url(<?php echo $site_url ?>/_graphics/elgg_sprites.png) no-repeat left;
        background-position: 0 -1492px;
    }
    
    .friend-icon:hover {
        background-position: 0 -1474px;
    }
    
    .settings-icon {
        padding-left: 23px;
        background: transparent url(<?php echo $site_url ?>/_graphics/elgg_sprites.png) no-repeat left;
        background-position: 0 -970px;
        height: 21px;
    }
    
    .settings-icon:hover {
        background-position: 0 -951px;
        height: 21px;
    }
</style>