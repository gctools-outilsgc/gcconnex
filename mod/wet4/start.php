<?php
/**
 * WET 4 Theme plugin
 *
 * @package wet4Theme
 */

elgg_register_event_handler('init','system','wet4_theme_init');

function wet4_theme_init() {
    
	elgg_register_event_handler('pagesetup', 'system', 'wet4_theme_pagesetup', 1000);
    elgg_register_event_handler('pagesetup', 'system', 'messages_notifier');

	// theme specific CSS
	elgg_extend_view('css/elgg', 'wet4_theme/css');

	elgg_unextend_view('page/elements/header', 'search/header');
	elgg_extend_view('page/elements/sidebar', 'search/header', 0);
	
	elgg_register_plugin_hook_handler('head', 'page', 'wet4_theme_setup_head');
    
	// non-members do not get visible links to RSS feeds
	if (!elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('output:before', 'layout', 'elgg_views_add_rss_link');
	}
    
    
    
    
    
    
}

/**
 * Rearrange menu items
 */
function wet4_theme_pagesetup() {

	if (elgg_is_logged_in()) {

		elgg_register_menu_item('topbar', array(
			'name' => 'account',
			'text' => elgg_echo('account'),
			'href' => "#",
			'priority' => 100,
			'section' => 'alt',
			'link_class' => 'elgg-topbar-dropdown',
		));

		if (elgg_is_active_plugin('dashboard')) {
			$item = elgg_unregister_menu_item('topbar', 'dashboard');
			if ($item) {
				$item->setText(elgg_echo('dashboard'));
				$item->setSection('default');
				elgg_register_menu_item('site', $item);
			}
		}
		
		$item = elgg_get_menu_item('topbar', 'usersettings');
		if ($item) {
			$item->setParentName('account');
			$item->setText(elgg_echo('settings'));
			$item->setPriority(103);
		}

		$item = elgg_get_menu_item('topbar', 'logout');
		if ($item) {
			$item->setParentName('account');
			$item->setText(elgg_echo('logout'));
			$item->setPriority(104);
		}

		$item = elgg_get_menu_item('topbar', 'administration');
		if ($item) {
			$item->setParentName('account');
			$item->setText(elgg_echo('admin'));
			$item->setPriority(101);
		}

		if (elgg_is_active_plugin('site_notifications')) {
			$item = elgg_get_menu_item('topbar', 'site_notifications');
			if ($item) {
				$item->setParentName('account');
				$item->setText(elgg_echo('site_notifications:topbar'));
				$item->setPriority(102);
			}
		}

		if (elgg_is_active_plugin('reportedcontent')) {
			$item = elgg_unregister_menu_item('footer', 'report_this');
			if ($item) {
				$item->setText(elgg_view_icon('report-this'));
				$item->setPriority(500);
				$item->setSection('default');
				elgg_register_menu_item('extras', $item);
			}
		}
	}
    
    
/*
*    Control colleague requests in topbar menu
*    taken from friend_request module
*    edited to place badge on colleagues instead of creating new icon
*/
    $user = elgg_get_logged_in_user_entity();
    
    $params = array(
				"name" => "Colleagues",
				"href" => "friends/" . $user->username,
				"text" => elgg_echo("friends"),
				"title" => elgg_echo('friends'),
                "class" => 'friend-icon',
                'item_class' => 'brdr-rght',
				'priority' => '3'
			);
			
			elgg_register_menu_item("user_menu", $params);
    
    
    $context = elgg_get_context();
	$page_owner = elgg_get_page_owner_entity();
	
	// Remove link to friendsof
	elgg_unregister_menu_item("page", "friends:of");
	
	
	if (!empty($user)) {
		$options = array(
			"type" => "user",
			"count" => true,
			"relationship" => "friendrequest",
			"relationship_guid" => $user->getGUID(),
			"inverse_relationship" => true
		);
		
		$count = elgg_get_entities_from_relationship($options);
		if (!empty($count)) {
            
            //user menu
            
			$params = array(
				"name" => "Colleagues",
				"href" => "friends/" . $user->username,
				"text" => elgg_echo("friends") . "<span class='badge'>" . $count . "</span>",
				"title" => elgg_echo('friends') . ' - Requests(' . $count .')',
                "class" => 'friend-icon',
                'item_class' => 'brdr-rght',
				'priority' => '3'
			);
			
			elgg_register_menu_item("user_menu", $params);
            
            
            
            //topbar
            
            $params = array(
				"name" => "friends",
				"href" => "friends/" . $user->username,
				"text" => elgg_echo("friends") . "<span class='badge'>" . $count . "</span>",
				"title" => elgg_echo('friends') . ' - Requests(' . $count .')',
                "class" => 'friend-icon',

		
			);
			
			elgg_register_menu_item("topbar", $params);
            
		}
	}
    
    
    
    
    $item = elgg_get_menu_item('entity', 'likes');
		if ($item) {
			$item->setText('likes');
            $item->setItemClass('msg-icon');

		}
	
	
    
    
}

/**
 * Register items for the html head
 *
 * @param string $hook Hook name ('head')
 * @param string $type Hook type ('page')
 * @param array  $data Array of items for head
 * @return array
 */
function wet4_theme_setup_head($hook, $type, $data) {
	$data['metas']['viewport'] = array(
		'name' => 'viewport',
		'content' => 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0',
	);

	$data['links']['apple-touch-icon'] = array(
		'rel' => 'apple-touch-icon',
		'href' => elgg_normalize_url('mod/wet4_theme/graphics/homescreen.png'),
	);

	return $data;
}









