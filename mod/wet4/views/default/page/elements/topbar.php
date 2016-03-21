<?php
/**
 * Elgg topbar
 * The standard elgg top toolbar
 */

$site_url = elgg_get_site_url();
$user = get_loggedin_user()->username;
$user_avatar = get_loggedin_user()->geticonURL('small');



$item = elgg_get_menu_item('topbar', 'profile');
		if ($item) {
			$item->setText(elgg_echo('profile'));
            $item->setLinkClass('profile-avatar');
		}


$item = elgg_get_menu_item('topbar', 'friends');
		if ($item) {
			$item->setText(elgg_echo('friends'));
            $item->setLinkClass('friend-icon');
		}

$item = elgg_get_menu_item('topbar', 'messages');
		if ($item) {
			$item->setText(elgg_echo('messages'));
            $item->setItemClass('msg-icon');
		}


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



elgg_register_menu_item('topbar', array(
    'name' => 'Settings',

    'text' => 'Settings' . $dropdown,
    'title' => 'My Settings Dropdown',
    'item_class' => 'dropdown',
    'data-toggle' => 'dropdown',
    'class' => ' dropdown-toggle settings-icon dropdownToggle',
    'priority' => '800',
    ));

// Elgg logo
echo elgg_view_menu('topbar', array('sort_by' => 'priority', 'class' => 'list-inline',));

// elgg tools menu
// need to echo this empty view for backward compatibility.
echo elgg_view_deprecated("navigation/topbar_tools", array(), "Extend the topbar menus or the page/elements/topbar view directly", 1.8);







//we are styling

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
    
    .elgg-menu-topbar-alt {
        display: none;   
    }
    
    /*
     li.elgg-menu-item-friend-request {
        display: none;
        padding: 0;
    }
    
    .friend-request-new {
        display: none;
    }
    */
</style>