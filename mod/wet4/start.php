<?php
/**
 * WET 4 Theme plugin
 *
 * @package wet4Theme
 */

elgg_register_event_handler('init','system','wet4_theme_init');

function wet4_theme_init() {
    
    //reload groups library to have our sidebar changes
    elgg_register_library('elgg:groups', elgg_get_plugins_path() . 'wet4/lib/groups.php');
    elgg_register_library('GCconnex_logging', elgg_get_plugins_path() . 'wet4/lib/logging.php');
    elgg_register_library('GCconnex_display_in_language', elgg_get_plugins_path() . 'wet4/lib/translate_display.php');

    elgg_load_library('GCconnex_logging');
    elgg_load_library('GCconnex_display_in_language');
    //get rid of reply icon on river menu
    elgg_unregister_plugin_hook_handler('register', 'menu:river', 'discussion_add_to_river_menu');

    //change icons for blog entity
    elgg_unregister_plugin_hook_handler("register", "menu:entity", array("\ColdTrick\BlogTools\EntityMenu", "register"));
    elgg_register_plugin_hook_handler("register", "menu:entity", 'wet4_blog_entity_menu');
    //Friendly Time - Nick
    elgg_register_plugin_hook_handler('format', 'friendly:time', 'enhanced_friendly_time_hook');
	elgg_register_event_handler('pagesetup', 'system', 'wet4_theme_pagesetup', 1000);
    elgg_register_event_handler('pagesetup', 'system', 'wet4_riverItem_remove');
    elgg_register_event_handler('pagesetup', 'system', 'messages_notifier');

    elgg_register_plugin_hook_handler('register', 'menu:entity', 'wet4_elgg_entity_menu_setup');
    elgg_register_plugin_hook_handler('register', 'menu:widget', 'wet4_widget_menu_setup');
    elgg_register_plugin_hook_handler('register', 'menu:page', 'wet4_elgg_page_menu_setup');
    elgg_register_plugin_hook_handler('register', 'menu:river', 'wet4_elgg_river_menu_setup');
    elgg_register_plugin_hook_handler('register', 'menu:site', 'career_menu_hander');
    
    elgg_register_plugin_hook_handler('register', 'menu:entity', 'wet4_likes_entity_menu_setup', 400);
    //elgg_register_plugin_hook_handler('register', 'menu:entity', 'wet4_delete_entity_menu', 400);
    
	// theme specific CSS
	elgg_extend_view('css/elgg', 'wet4_theme/css');

    elgg_extend_view('forms/notificationsettings/save', 'forms/notificationsettings/groupsave');

    //register a page handler for friends
    elgg_unregister_page_handler('friends'); //unregister core page handler
    elgg_unregister_page_handler('dashboard'); //unregister dashboard handler to make our own
    elgg_register_page_handler('dashboard', 'wet4_dashboard_page_handler');
    elgg_register_page_handler('friends', '_wet4_friends_page_handler'); //register new page handler for data tables
	elgg_register_page_handler('friendsof', '_wet4_friends_page_handler');

    elgg_unregister_page_handler('messages', 'messages_page_handler');
    elgg_register_page_handler('messages', 'wet4_messages_page_handler');

    //datatables css file
	elgg_extend_view('css/elgg', '//cdn.datatables.net/1.10.10/css/jquery.dataTables.css');


	//elgg_unextend_view('page/elements/header', 'search/header');
	//elgg_extend_view('page/elements/sidebar', 'search/header', 0);
    
    //load datatables
    elgg_require_js("wet4/test");
    //elgg_require_js("wet4/elgg_dataTables");
    
    //elgg_register_js('removeMe', elgg_get_plugins_path() . 'wet4/js/removeMe.js');
    
    //the wire reply and thread
    elgg_register_ajax_view("thewire_tools/reply");
	elgg_register_ajax_view("thewire_tools/thread");

    elgg_register_ajax_view("friend_circle/edit");

    //file tools 
	elgg_register_ajax_view("file_tools/move");

	
	elgg_register_plugin_hook_handler('head', 'page', 'wet4_theme_setup_head');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'my_owner_block_handler');
    elgg_register_plugin_hook_handler('register', 'menu:title', 'my_title_menu_handler');
    elgg_register_plugin_hook_handler('register', 'menu:filter', 'my_filter_menu_handler');
    elgg_register_plugin_hook_handler('register', 'menu:site', 'my_site_menu_handler');
	elgg_register_plugin_hook_handler('register', 'menu:river', 'river_handler');
    
    elgg_register_simplecache_view('wet4/test.js');

    //added since goups didnt have this action but called it
    elgg_register_action("discussion_reply/delete", elgg_get_plugins_path() . "/wet4/actions/discussion/reply/delete.php");
    
	elgg_register_action("file/move_folder", elgg_get_plugins_path() . "/wet4/actions/file/move.php");
    elgg_register_action("friends/collections/add", elgg_get_plugins_path() . "/wet4/actions/friends/collections/add.php");
    elgg_register_action("login", elgg_get_plugins_path() . "/wet4/actions/login.php", "public");
    elgg_register_action("user/requestnewpassword", elgg_get_plugins_path() . "/wet4/actions/user/requestnewpassword.php", "public");
	// non-members do not get visible links to RSS feeds
	if (!elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('output:before', 'layout', 'elgg_views_add_rss_link');
	}

    // new widgets
    //registering wet 4 activity widget

    if(elgg_is_logged_in()){//for my the my groups widget on the home page
        $mygroups_title = elgg_echo('wet_mygroups:my_groups');
        $wet_activity_title = elgg_echo('wet4:colandgroupactivity');
    }else{
        $mygroups_title = elgg_echo('wet_mygroups:my_groups_nolog');
        $wet_activity_title = elgg_echo('wet4:colandgroupactivitynolog');
    }
    elgg_register_widget_type('wet_activity', $wet_activity_title, 'GCconnex Group and Colleague Activity', array('custom_index_widgets'),true);
    elgg_register_widget_type('profile_completness', elgg_echo('ps:profilestrength'), 'The "Profile Strength" widget', array('custom_index_widgets'),false);
    elgg_register_widget_type('suggested_friends', elgg_echo('sf:suggcolleagues'), elgg_echo('sf:suggcolleagues'), array('custom_index_widgets'),false);
    elgg_register_widget_type('user_summary_panel', 'user_summary_panel', 'user_summary_panel', array('custom_index_widgets'),false);

    //WET my groups widget
    elgg_register_widget_type('wet_mygroups_index', $mygroups_title, 'My Groups Index', array('custom_index_widgets'),true);
    elgg_register_widget_type('most_liked', elgg_echo('activity:module:weekly_likes'), elgg_echo('activity:module:weekly_likes'), array('custom_index_widgets'),true);

    
    //extend views of plugin files to remove unwanted menu items
    $active_plugins = elgg_get_plugins();
    foreach ($active_plugins as $plugin) {
		$plugin_id = $plugin->getID();
		if (elgg_view_exists("usersettings/$plugin_id/edit") || elgg_view_exists("plugins/$plugin_id/usersettings")) {

            elgg_extend_view("usersettings/$plugin_id/edit", "forms/usersettings/menus");
            elgg_extend_view("plugins/$plugin_id/usersettings", "forms/usersettings/menus");

		}
	}
    elgg_extend_view("core/settings/statistics", "forms/usersettings/menus");
    elgg_extend_view('forms/account/settings', 'core/settings/account/landing_page');


    //add profile strength to sidebar
    elgg_extend_view('profile/sidebar', 'profile/sidebar/profile_strength', 449);

    //menu item for career dropdown
    elgg_register_menu_item('site', array(
    		'name' => 'career',
    		'href' => '#career_menu',
    		'text' => elgg_echo('career') . '<span class="expicon glyphicon glyphicon-chevron-down"></span>'
    ));

    //set up metadata for user's landing page preference
    if(elgg_is_logged_in()){
        $user = elgg_get_logged_in_user_entity();
        if(!isset($user->landingpage)){
            $user->landingpage = 'news';
        }
    }

    //save new user settings on landing page
    elgg_register_plugin_hook_handler('usersettings:save', 'user', '_elgg_set_landing_page');

    // Replace the default index page with redirect
    elgg_register_plugin_hook_handler('index', 'system', 'new_index');
    elgg_register_page_handler('newsfeed', 'newsfeed_page_handler');
    elgg_register_page_handler('splash', 'splash_page_handler');

    elgg_register_page_handler('groups_autocomplete', 'groups_autocomplete');


    //jobs.gc.ca menu link
    $lang = get_language();
    if($lang == 'en'){
        elgg_register_menu_item('subSite', array(
            'name' => 'jobs',
            'text' => 'jobs.gc.ca <i class="fa fa-external-link mrgn-lft-sm"></i>',
            'href' => 'http://jobs-emplois.gc.ca/index-eng.htm',
            'target' => '_blank',
            ));
    } else {
        elgg_register_menu_item('subSite', array(
            'name' => 'jobs',
            'text' => 'emplois.gc.ca',
            'href' => 'http://jobs-emplois.gc.ca/index-fra.htm',
            'target' => '_blank',
            ));
    }

}

/*
 *  load lib for suggested group text input
 */

function groups_autocomplete() {
    require_once elgg_get_plugins_path() . 'wet4/lib/groups_autocomplete.php';
    return true;
}


/*
 *  Create news feed page
 */

function newsfeed_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/newsfeed.php");
    return true;
}
//Create splash page
function splash_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/splash.php");
    return true;
}

/*
 *  Set new index page to sort user's landing page preference
 */

function new_index() {
    return !include_once(dirname(__FILE__) . "/pages/index.php");
}

/*
 * Set landing page in user settings
 */

function _elgg_set_landing_page() {
	$page = strip_tags(get_input('landingpage'));
	$user_guid = get_input('guid');

	if ($user_guid) {
		$user = get_user($user_guid);
	} else {
		$user = elgg_get_logged_in_user_entity();
	}

	if ($user && $user->canEdit() && $page) {
		if ($page != $user->name) {
			$user->landingpage = $page;
			if ($user->save()) {
				
				return true;
			} else {
				
			}
		} else {
			// no change
			return null;
		}
	} else {
		
	}
	return false;
}


// function that handles moving jobs marketplace and micro missions into drop down menu
function career_menu_hander($hook, $type, $menu, $params){
    foreach ($menu as $key => $item){

        switch ($item->getName()) {
            case 'career':
                if(elgg_is_active_plugin('gcforums')){
                    $item->addChild(elgg_get_menu_item('subSite', 'Forum'));
                }
                if(elgg_is_active_plugin('missions')){
                    $item->addChild(elgg_get_menu_item('site', 'mission_main'));
                }
                $item->addChild(elgg_get_menu_item('subSite', 'jobs'));
                $item->setLinkClass('item');
                break;
        }
    }
}

/**
 * Rearrange menu items
 */
function wet4_theme_pagesetup() {
    
    //elgg_load_js('elgg/dev');
    //elgg_load_js('elgg/reportedcontent');
    //elgg_load_js('removeMe');
    
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
        /*
        if ($item->canEdit()) {
            $control = elgg_view("output/url",array(
            'href' => elgg_get_site_url() . "action/plugin_name/delete?guid=" . $entity->guid,
            'text' => 'Delete ME!',
            'is_action' => true,
            'is_trusted' => true,
            'confirm' => elgg_echo('deleteconfirm'),
            'class' => 'testing',
                   ));   
                }*/
        
        
        //style colleague requests tab
        $context = elgg_get_context();
        $page_owner = elgg_get_page_owner_entity();

        // Show menu link in the correct context
        if (in_array($context, array("friends", "friendsof", "collections", "messages"))) {
            $options = array(
                "type" => "user",
                "count" => true,
                "relationship" => "friendrequest",
                "relationship_guid" => $page_owner->getGUID(),
                "inverse_relationship" => true
            );

            $count = elgg_get_entities_from_relationship($options);
            $extra = "";
            if (!empty($count)) {
                if($count >= 10){
                    $count = '9+';
                }
                $extra = '<span class="notif-badge">' . $count . '</span>';
            }
            
            // add menu item
            $menu_item = array(
                "name" => "friend_request",
                "text" => elgg_echo("friend_request:menu") . $extra,
                "href" => "friend_request/" . $page_owner->username,
                "contexts" => array("friends", "friendsof", "collections", "messages")
            );

            elgg_register_menu_item("page", $menu_item);
            
            
        }
        
        if(elgg_in_context('messages')){
                elgg_unregister_menu_item("page", "friend_request");
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
				"text" => '<i class="fa fa-users mrgn-rght-sm mrgn-tp-sm fa-lg"></i><span class="hidden-xs">' . elgg_echo("friends") . '</span>',
				"title" => elgg_echo('friends'),
                "class" => '',
                'item_class' => '',
				'priority' => '1'
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
            
            $countTitle = $count;
            
            //display 9+ instead of huge numbers in notif badge
            if($count >= 10){
                $count = '9+';
            }
            
			$params = array(
				"name" => "Colleagues",
				"href" => "friends/" . $user->username,
				"text" => '<i class="fa fa-users mrgn-rght-sm mrgn-tp-sm fa-lg"></i><span class="hidden-xs">'. elgg_echo("friends") . "</span><span class='notif-badge'>" . $count . "</span>",
				"title" => elgg_echo('userMenu:colleagues') . ' - ' . $countTitle . ' ' . elgg_echo('friend_request') .'(s)',
                "class" => '',
                'item_class' => '',
				'priority' => '1'
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
    
    
    
    //likes and stuff yo
    $item = elgg_get_menu_item('entity', 'likes');
		if ($item) {
			$item->setText('likes');
            $item->setItemClass('msg-icon');
           
		}
    
    $item = elgg_get_menu_item('entity', 'delete');
		if ($item){
          echo '<div> What that mean?</div>';          
        }
    
    	if (elgg_is_logged_in() && elgg_get_config('allow_registration')) {
		$params = array(
			'name' => 'invite',
			'text' => elgg_echo('friends:invite'),
			'href' => "invite/". $user->username,
			'contexts' => array('friends'),
            'priority' => 300,
		);
		elgg_register_menu_item('page', $params);
	}
    
    
    //new folder button for files
    
    if(elgg_is_logged_in()){
        $user = elgg_get_logged_in_user_entity();
        if($user->canEdit()){
            $params = array(
                'name' => 'new_folder',
                'text' => elgg_echo("file_tools:new:title"),
                'href' => "#",
                "id" => "file_tools_list_new_folder_toggle",
                'item_class' => 'mrgn-lft-sm',
                'context' => 'file',
            );
            elgg_register_menu_item('title2', $params);
            
            
        }
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






function wet4_likes_entity_menu_setup($hook, $type, $return, $params) {
	// make the widget view produce the same entity menu as the other objects
    if (elgg_in_context('widgets')) {
		//return $return;
	}

	$entity = $params['entity'];
	/* @var ElggEntity $entity */

	if ($entity->canAnnotate(0, 'likes')) {
		$hasLiked = \Elgg\Likes\DataService::instance()->currentUserLikesEntity($entity->guid);
		
		// Always register both. That makes it super easy to toggle with javascript
		$return[] = ElggMenuItem::factory(array(
			'name' => 'likes',
			'href' => elgg_add_action_tokens_to_url("/action/likes/add?guid={$entity->guid}"),
			'text' => '<i class="fa fa-thumbs-up fa-lg icon-unsel"></i><span class="wb-inv">Like This</span>',
			'title' => elgg_echo('likes:likethis'),
			'item_class' => $hasLiked ? 'hidden' : '',
			'priority' => 1000,
		));
		$return[] = ElggMenuItem::factory(array(
			'name' => 'unlike',
			'href' => elgg_add_action_tokens_to_url("/action/likes/delete?guid={$entity->guid}"),
			'text' => '<i class="fa fa-thumbs-up fa-lg icon-sel"></i><span class="wb-inv">Like This</span>',
			'title' => elgg_echo('likes:remove'),
			'item_class' => $hasLiked ? 'pad-rght-xs' : 'hidden',
			'priority' => 1000,
		));
	}
    
    	
		
		
	
    // Always register both. That makes it super easy to toggle with javascript
    /*
    if($entity->canEditMetadata(1, 'delete')){
      $return[] = array(
			'name' => 'delete',
			'href' =>  elgg_get_site_url() . "action/plugin_name/delete?guid=" . $entity->guid,
			'text' => 'delete yo',
			'title' => elgg_echo('likes:likethis'),
			
			'priority' => 100,
		);  
    }
*/

	
	
	// likes count
	$count = elgg_view('likes/count', array('entity' => $entity));
	if ($count) {
		$options = array(
			'name' => 'likes_count',
			'text' => $count,
			'href' => false,
			'priority' => 1001,
            'item_class' => 'entity-menu-bubble',
		);
		$return[] = ElggMenuItem::factory($options);
	}


    
	return $return;
}

//Setup page menu for user settings
function wet4_elgg_page_menu_setup($hook, $type, $return, $params) {

    if(elgg_in_context('settings')){

        $user = elgg_get_page_owner_entity();

        $dropdown = '<ul class="dropdown-menu pull-right subMenu">';

        $active_plugins = elgg_get_plugins();

        foreach ($active_plugins as $plugin) {
            $plugin_id = $plugin->getID();
            if (elgg_view_exists("usersettings/$plugin_id/edit") || elgg_view_exists("plugins/$plugin_id/usersettings")) {
                $params = array(
                    'name' => $plugin_id,
                    'text' => $plugin->getFriendlyName(),
                    'href' => "settings/plugins/{$user->username}/$plugin_id",
                );

                $dropdown .= '<li><a href="' . elgg_get_site_url() . 'settings/plugins/' . $user->username . '/' . $plugin_id . '">' . $plugin->getFriendlyName() . '</a></li>';
            }
        }

        $dropdown .= '</ul>';
        
        $options = array(
                   'name' => 'plugin_tools',
                   'text' => elgg_echo('usersettings:plugins:opt:linktext') . '<b class="caret"></b>' . $dropdown,
                   
                   'priority' => 150,
                   'section' => 'configure',
                   'item_class' => 'dropdown',
                   'data-toggle' => 'dropdown',
                   'aria-expanded' => 'false',
                   'class' => 'dropdown-toggle  dropdownToggle',
               );
        $return[] = \ElggMenuItem::factory($options);


        return $return;

    }

}


function wet4_blog_entity_menu($hook, $entity_type, $returnvalue, $params) {
    if (empty($params) || !is_array($params)) {
        return $returnvalue;
    }

    $entity = elgg_extract("entity", $params);
    if (empty($entity) || !elgg_instanceof($entity, "object", "blog")) {
        return $returnvalue;
    }

    // only published blogs
    if ($entity->status == "draft") {
        return $returnvalue;
    }

    if (!elgg_in_context("widgets") && elgg_is_admin_logged_in()) {
        $returnvalue[] = \ElggMenuItem::factory(array(
            "name" => "blog-feature",
            "text" => elgg_echo("blog_tools:toggle:feature"),
            "href" => "action/blog_tools/toggle_metadata?guid=" . $entity->getGUID() . "&metadata=featured",
            "item_class" => empty($entity->featured) ? "" : "hidden",
            "is_action" => true,
            "priority" => 175
        ));
        $returnvalue[] = \ElggMenuItem::factory(array(
            "name" => "blog-unfeature",
            "text" => elgg_echo("blog_tools:toggle:unfeature"),
            "href" => "action/blog_tools/toggle_metadata?guid=" . $entity->getGUID() . "&metadata=featured",
            "item_class" => empty($entity->featured) ? "hidden" : "",
            "is_action" => true,
            "priority" => 176
        ));
    }

    if ($entity->canComment()) {
        $returnvalue[] = \ElggMenuItem::factory(array(
            "name" => "comments",
            "text" => '<i class="fa fa-lg fa-comment icon-unsel"><span class="wb-inv">' . elgg_echo("comment:this") . '</span></i>',
            "title" => elgg_echo("comment:this"),
            "href" => $entity->getURL() . "#comments"
        ));

        /*
        $comment_count = $entity->countComments();
        if ($comment_count) {
            $returnvalue[] = \ElggMenuItem::factory(array(
                "name" => "comments_count",
                "text" => $comment_count,
                "title" => elgg_echo("comments"),
                "href" => false
            ));
        }
        */
    }

    return $returnvalue;
}



function wet4_elgg_entity_menu_setup($hook, $type, $return, $params) {
	//Have widgets show the same entity menu
    if (elgg_in_context('widgets')) {
		//return $return;
	}
	
	$entity = $params['entity'];
	/* @var \ElggEntity $entity */
	$handler = elgg_extract('handler', $params, false);
    
    
       
        $blocked_subtypes = array('comment', 'discussion_reply');
        if(in_array($entity->getSubtype(), $blocked_subtypes) || elgg_instanceof($entity, 'user')){
            
            //do not let comments or discussion replies to be reshared on the wire
            
        } else {
        
        // check is this item was shared on thewire
			$count = $entity->getEntitiesFromRelationship(array(
				'type' => 'object',
				'subtype' => 'thewire',
				'relationship' => 'reshare',
				'inverse_relationship' => true,
				'count' => true
			));
			
			if ($count) {
                
                if($count >=2){
                    $share = elgg_echo('thewire:shares');
                } else {
                    $share = elgg_echo('thewire:share');
                }
                
				// show counter
				$return[] = \ElggMenuItem::factory(array(
					'name' => 'thewire_tools_reshare_count',
					'text' => $count . $share,
					'title' => elgg_echo('thewire_tools:reshare:count'),
					'href' => 'ajax/view/thewire_tools/reshare_list?entity_guid=' . $entity->getGUID(),
					'link_class' => 'elgg-lightbox',
                    'item_class' => ' entity-menu-bubble',
					'is_trusted' => true,
					'priority' => 501,
					'data-colorbox-opts' => json_encode(array(
						'maxHeight' => '85%'
					))
				));
			}
        
            
            if(elgg_is_logged_in()){

                //reshare on the wire
                $options = array(
                    'name' => 'thewire_tools_reshare',
                    'text' => '<i class="fa fa-share-alt fa-lg icon-unsel"><span class="wb-inv">Share this on the Wire</span></i>',
                    'title' => elgg_echo('thewire_tools:reshare'),
                    'href' => 'ajax/view/thewire_tools/reshare?reshare_guid=' . $entity->getGUID(),
                    'link_class' => 'elgg-lightbox',
                    'item_class' => 'pad-rght-xs',
                    'is_trusted' => true,
                    'priority' => 500
                );
                $return[] = \ElggMenuItem::factory($options); 
                
                $options = array(
			'name' => 'access',
                    'text' => '',
                    'item_class' => 'removeMe',
		);
		$return[] = \ElggMenuItem::factory($options);
                
            } else {
                $options = array(
                    'name' => 'thewire_tools_reshare',
                    'text' => '',
                    'item_class' => 'removeMe',
                );
                $return[] = \ElggMenuItem::factory($options); 
                
                //elgg_unregister_menu_item('entity', 'thewire_tools_reshare');
            }
        }
        
        //only show reply on the wire with logged in user
        if($entity->getSubtype() == 'thewire' && elgg_is_logged_in()){
            $options = array(
                'name' => 'reply',
                'text' => elgg_echo('reply'),
                'title' => elgg_echo('reply'),
                'href' => 'ajax/view/thewire_tools/reply?guid=' . $entity->getGUID(),
                'link_class' => 'elgg-lightbox',
                'is_trusted' => true,
                'priority' => 100
            );
            $return[] = \ElggMenuItem::factory($options); 
        }
          
	if (($entity->countEntitiesFromRelationship("parent") || $entity->countEntitiesFromRelationship("parent", true))) {
                $options = array(
                    'name' => 'thread',
                    'text' => elgg_echo('thewire:thread'),
                    'href' => 'ajax/view/thewire_tools/thread?thread_id=' . $entity->wire_thread,
                    'link_class' => 'elgg-lightbox',
                    'is_trusted' => true,
                    'priority' => 170,
                );
                $return[] = ElggMenuItem::factory($options);
            }
	if ($entity->canEdit() && $handler) {
		// edit link
    
        //checks so the edit icon is not placed on incorrect entities
        if($handler != 'group_operators'){
            if($entity->getSubtype() != 'thewire'){
                $options = array(
                    'name' => 'edit',
                    'text' => '<i class="fa fa-edit fa-lg icon-unsel"><span class="wb-inv">Edit This</span></i>',
                    'title' => elgg_echo('edit:this'),
                    'href' => "$handler/edit/{$entity->getGUID()}",
                    'priority' => 299,
                );
                $return[] = \ElggMenuItem::factory($options);
            }
		// delete link
		$options = array(
			'name' => 'delete',
			'text' => '<i class="fa fa-trash-o fa-lg icon-unsel"><span class="wb-inv">' . elgg_echo('delete:this') . '</span></i>',
			'title' => elgg_echo('delete:this'),
			'href' => "action/$handler/delete?guid={$entity->getGUID()}",
			'confirm' => elgg_echo('deleteconfirm'),
			'priority' => 300,
		);
		$return[] = \ElggMenuItem::factory($options);

        }


        
	}

    
    if($entity->getSubType() == 'file'){
        // download link
		$options = array(
			'name' => 'download',
			'text' => '<i class="fa fa-download fa-lg icon-unsel"><span class="wb-inv">Download File</span></i>',
			'title' => 'Download File',
			'href' => "file/download/{$entity->getGUID()}",
			'priority' => 299,
            'context' => array('file_tools_selector', 'file'),
		);
		$return[] = \ElggMenuItem::factory($options); 
    }
    
    
            if($entity->getSubType() == 'page_top'){
                //history icon
            $options = array(
                'name' => 'history',
                'text' => '<i class="fa fa-history fa-lg icon-unsel"><span class="wb-inv">' . elgg_echo('pages:history') . '</span></i>',
                'href' => "pages/history/$entity->guid",
                'priority' => 150,
            );
            $return[] = \ElggMenuItem::factory($options);      
        }

	return $return;
}

function _wet4_friends_page_handler($page, $handler) {
    //change the page handler for friends to user our own pages. This increases the limit of friends for data table parsing and such :)
	elgg_set_context('friends');

	if (isset($page[0]) && $user = get_user_by_username($page[0])) {
		elgg_set_page_owner_guid($user->getGUID());
	}

	if (!elgg_get_page_owner_guid()) {
		return false;
	}
    $plugin_path = elgg_get_plugins_path();
    //echo $plugin_path;
	switch ($handler) {
		case 'friends':
            //use the pages in our theme instead of the core pages
			require($plugin_path ."wet4/pages/friends/index.php");
			break;
		case 'friendsof':
        
			require($plugin_path ."wet4/pages/friends/of.php");
			break;
		default:
			return false;
	}
	return true;
}


function wet4_riverItem_remove(){
    elgg_unregister_menu_item('river', 'comment'); 
    elgg_unregister_menu_item('river', 'reply'); 
}

function wet4_elgg_river_menu_setup($hook, $type, $return, $params){
    
    
	if (elgg_is_logged_in()) {
		$item = $params['item'];
		/* @var \ElggRiverItem $item */
		$object = $item->getObjectEntity();
		// add comment link but annotations cannot be commented on
		if ($item->annotation_id == 0) {
			if ($object->canComment()) {
                /*
				$options = array(
					'name' => 'comment',
					'href' => "#comments-add-$object->guid",
					'text' => '<i class="fa fa-comment-o fa-lg icon-unsel"><span class="wb-inv">Comment on this</span></i>',
					'title' => elgg_echo('comment:this'),
					//'rel' => 'toggle',
                   'data-toggle' => 'collapse',
                    'aria-expanded' => 'false',
					'priority' => 50,
				);
				$return[] = \ElggMenuItem::factory($options);
                */
                
            }else{
                /*
                      $options = array(
					'name' => 'reply',
					'href' => "#comments-add-$object->guid",
					'text' => '<i class="fa fa-comment-o fa-lg icon-unsel"><span class="wb-inv">Comment on this</span></i>',
					'title' => 'Reply to this',
					//'rel' => 'toggle',
                         'data-toggle' => 'collapse',
                  'aria-expanded' => 'false',
					'priority' => 50,
				);
				$return[] = \ElggMenuItem::factory($options);  */
            }
            

    
		}
        

        
        	$object = $item->getObjectEntity();
	if (!$object || !$object->canAnnotate(0, 'likes')) {
		return;
	}

	$hasLiked = \Elgg\Likes\DataService::instance()->currentUserLikesEntity($object->guid);

	// Always register both. That makes it super easy to toggle with javascript
	$return[] = ElggMenuItem::factory(array(
		'name' => 'likes',
		'href' => elgg_add_action_tokens_to_url("/action/likes/add?guid={$object->guid}"),
		'text' => '<i class="fa fa-thumbs-up fa-lg icon-unsel"></i><span class="wb-inv">Like This</span>',
		'title' => elgg_echo('likes:likethis'),
		'item_class' => $hasLiked ? 'hidden' : '',
		'priority' => 100,
	));
	$return[] = ElggMenuItem::factory(array(
		'name' => 'unlike',
		'href' => elgg_add_action_tokens_to_url("/action/likes/delete?guid={$object->guid}"),
		'text' => '<i class="fa fa-thumbs-up fa-lg icon-sel"></i><span class="wb-inv">Like This</span>',
		'title' => elgg_echo('likes:remove'),
		'item_class' => $hasLiked ? '' : 'hidden',
		'priority' => 100,
	));

	// likes count
	$count = elgg_view('likes/count', array('entity' => $object));
	if ($count) {
		$return[] = ElggMenuItem::factory(array(
			'name' => 'likes_count',
			'text' => $count,
			'href' => false,
			'priority' => 101,
		));
	}
        
		
		if (elgg_is_admin_logged_in()) {
			$options = array(
				'name' => 'delete',
				'href' => elgg_add_action_tokens_to_url("action/river/delete?id=$item->id"),
				'text' => '<i class="fa fa-trash-o fa-lg icon-unsel"><span class="wb-inv">Delete This</span></i>',
				'title' => elgg_echo('river:delete'),
				'confirm' => elgg_echo('deleteconfirm'),
				'priority' => 200,
			);
			$return[] = \ElggMenuItem::factory($options);
		}
        

	}

	return $return;
}

//arrange filter menu menu
function my_filter_menu_handler($hook, $type, $menu, $params){
    foreach ($menu as $key => $item){
        if(elgg_in_context('thewire')){
        switch ($item->getName()) {
           
                case 'all':
                    $item->setPriority('1');

                    break;
                case 'friend':
                    $item->setPriority('2');

                    break;
                case 'mention':
                    $item->setText(elgg_echo('search'));
                    $item->setPriority('4');

                    break;
                case 'mine':
                    $item->setPriority('3');

                    break;
            }
        }
    }
}

//fix site menu
function my_site_menu_handler($hook, $type, $menu, $params){
    foreach ($menu as $key => $item){

            switch ($item->getName()) {

                case 'groups':
                    if(elgg_is_logged_in()){
                        $item->setHref('groups/all?filter=yours');
                    } else {
                        $item->setHref('groups/all?filter=popular');
                    }

                    break;
                
            }
        }
    
}

//arrange title menu on photo album
function my_title_menu_handler($hook, $type, $menu, $params){
    foreach ($menu as $key => $item){
        switch ($item->getName()) {

            case 'slideshow':
                $item->setText(elgg_echo('album:slideshow'));


                break;
            case 'addphotos':
                $item->setItemClass('mrgn-rght-sm');


                break;
        }
    }
}


//arrange owner block menu
function my_owner_block_handler($hook, $type, $menu, $params){
    
    /*
     *
     * If new tool has been added to group tools
     * Make sure the priority is less then 100
     *
     */
    
    
    //rearrange menu items
    if(elgg_get_context() == 'group_profile'){
        
        elgg_unregister_menu_item('owner_block', 'Activity');
        
        //turn owner_block  menu into tabs
        foreach ($menu as $key => $item){
             
            switch ($item->getName()) {
                case 'discussion':
                    $item->setText(elgg_echo('gprofile:discussion'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:discussion')));
                    $item->setPriority('1');
                    break;
                case 'gcforums':
                    $item->setPriority('1');
                    $item->setLinkClass('forums');
                    break;
                case 'related_groups':
                    $item->setHref('#related');

                    $item->setPriority('20');
                    break;
                case 'file':
                    $item->setText(elgg_echo('gprofile:files'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:files')));
                    $item->setPriority('2');
                    break;
                case 'blog':
                    $item->setText(elgg_echo('gprofile:blogs'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:blogs')));
                    $item->setPriority('3');
                    break;
                case 'event_calendar':
                    $item->setText(elgg_echo('gprofile:events'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:calendar')));
                    $item->setPriority('5');
                    break;
                case 'pages':
                    $item->setText(elgg_echo('gprofile:pages'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:pages')));
                    $item->setPriority('6');
                    break;
                case 'bookmarks':
                    $item->setText(elgg_echo('gprofile:bookmarks'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:bookmarks')));
                    $item->setPriority('7');
                    break;
                case 'polls':
                    $item->setText(elgg_echo('gprofile:polls'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:polls')));
                    $item->setPriority('8');
                    break;
                case 'tasks':
                    $item->setText(elgg_echo('gprofile:tasks'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:tasks')));
                    $item->setPriority('9');
                    break;
                case 'photos':
                    $item->setText(elgg_echo('gprofile:photos'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:photoCatch')));
                    $item->addItemClass('removeMe');
                    $item->setPriority('10');
                    break;
                case 'photo_albums':
                    $item->setText(elgg_echo('gprofile:albumsCatch'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:albums')));
                    $item->setPriority('11');
                    break;
                case 'ideas':
                    $item->setText(elgg_echo('gprofile:ideas'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:ideas')));
                    $item->setPriority('12');
                    break;
                case 'activity':
                    elgg_unregister_menu_item('owner_block', 'activity');
                    $item->setText('Activity');
                    $item->setHref('#activity');
                    $item->setPriority('13');
                    $item->addItemClass('removeMe');
                    break;
                
            }
            
        }
        
        
    }
    
    
    //rearrange menu items
    if(elgg_get_context() == 'groupSubPage'){
        
        elgg_unregister_menu_item('owner_block', 'activity');
        
        //turn owner_block  menu into tabs
        foreach ($menu as $key => $item){
             
            switch ($item->getName()) {
                case 'discussion':
                    $item->setText(elgg_echo('gprofile:discussion'));

                    $item->setPriority('1');
                    break;
                case 'gcforums':
                    $item->setPriority('1');
                    $item->setLinkClass('forums');
                    break;
                case 'related_groups':


                    $item->setPriority('20');
                    break;
                case 'file':
                    $item->setText(elgg_echo('gprofile:files'));

                    $item->setPriority('2');
                    break;
                case 'blog':
                    $item->setText(elgg_echo('gprofile:blogs'));

                    $item->setPriority('3');
                    break;
                case 'event_calendar':
                    $item->setText(elgg_echo('gprofile:events'));

                    $item->setPriority('5');
                    break;
                case 'pages':
                    $item->setText(elgg_echo('gprofile:pages'));

                    $item->setPriority('6');
                    break;
                case 'bookmarks':
                    $item->setText(elgg_echo('gprofile:bookmarks'));

                    $item->setPriority('7');
                    break;
                case 'polls':
                    $item->setText(elgg_echo('gprofile:polls'));

                    $item->setPriority('8');
                    break;
                case 'tasks':
                    $item->setText(elgg_echo('gprofile:tasks'));

                    $item->setPriority('9');
                    break;
                case 'photos':
                    $item->setText(elgg_echo('gprofile:photos'));
                    $item->addItemClass('removeMe');
                    $item->setPriority('10');
                    break;
                case 'photo_albums':
                    $item->setText(elgg_echo('gprofile:albumsCatch'));

                    $item->setPriority('11');
                    break;
                case 'ideas':
                    $item->setText(elgg_echo('gprofile:ideas'));

                    $item->setPriority('12');
                    break;
                case 'activity':
                    $item->setText('Activity');

                    $item->setPriority('13');
                    $item->addItemClass('removeMe');
                    break;
                
            }
            
        }
    }
        
        //rearrange menu items
    if(elgg_get_context() == 'profile'){
        
        elgg_unregister_menu_item('owner_block', 'activity');
        
        //turn owner_block  menu into tabs
        foreach ($menu as $key => $item){
             
            switch ($item->getName()) {
                case 'discussion':
                    $item->setText(elgg_echo('gprofile:discussion'));
                    
                    $item->setPriority('1');
                    break;
                case 'file':
                    $item->setText(elgg_echo('gprofile:files'));
                    $item->setHref('#file');
                    $item->setPriority('2');
                    break;
                case 'blog':
                    $item->setText(elgg_echo('gprofile:blogs'));
                    $item->setHref('#blog');
                    $item->setPriority('3');
                    break;
                case 'event_calendar':
                    $item->setText(elgg_echo('gprofile:events'));
                    $item->setHref('#events');
                    $item->setPriority('6');
                    break;
                case 'pages':
                    $item->setText(elgg_echo('gprofile:pages'));
                    $item->setHref('#page_top');
                    $item->setPriority('7');
                    break;
                case 'bookmarks':
                    $item->setText(elgg_echo('gprofile:bookmarks'));
                    $item->setHref('#bookmarks');
                    $item->setPriority('8');
                    break;
                case 'polls':
                    $item->setText(elgg_echo('gprofile:polls'));
                    $item->setHref('#poll');
                    $item->setPriority('9');
                    break;
                case 'tasks':
                    $item->setText(elgg_echo('gprofile:tasks'));
                    $item->setHref('#task_top');
                    $item->setPriority('10');
                    break;
                case 'photos':
                    $item->setText(elgg_echo('gprofile:photos'));
                    $item->addItemClass('removeMe');
                    $item->setPriority('11');
                    break;
                case 'photo_albums':
                    $item->setText(elgg_echo('gprofile:albumsCatch'));
                    $item->setHref('#album');
                    $item->setPriority('12');
                    break;
                case 'ideas':
                    $item->setText(elgg_echo('gprofile:ideas'));
                    $item->addItemClass('removeMe');
                    $item->setPriority('12');
                    break;

                case 'orgs':
                    $item->setPriority('13');
                    break;
                case 'thewire':
                    //$item->setText(elgg_echo('The Wire'));
                    $item->setHref('#thewire');
                    $item->setPriority('5');
                    break;
                case 'activity':
                    $item->setText('Activity');

                    $item->setPriority('13');
                    $item->addItemClass('removeMe');
                    break;
                case 'user_invite_from_profile':
                    $item->setPriority('13');
                    break;
            }
            
        }
    
        
        
    }
    
}

function river_handler($hook, $type, $menu, $params){
    foreach ($menu as $key => $item){
             
            switch ($item->getName()) {
                case 'comment':
                    $item->setItemClass('removeMe');
            }
        
    }
}

function wet4_dashboard_page_handler() {
	// Ensure that only logged-in users can see this page
	elgg_gatekeeper();

	// Set context and title
	elgg_set_context('dashboard');
	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	$title = elgg_echo('dashboard');

	// wrap intro message in a div
	$intro_message = elgg_view('dashboard/blurb');

	$params = array(
		'content' => $intro_message,
		'num_columns' => 2,
		'show_access' => false,
	);
    //use our own layouts for dashboard and stuff
	$widgets = elgg_view_layout('db_widgets', $params);

	$body = elgg_view_layout('dashboard', array(
		'title' => false,
		'content' => $widgets
	));

	echo elgg_view_page($title, $body);
	return true;
}


function wet4_widget_menu_setup($hook, $type, $return, $params) {

	$widget = $params['entity'];
	/* @var \ElggWidget $widget */
	$show_edit = elgg_extract('show_edit', $params, true);

    $options = array(
		'name' => 'collapse',
		'text' => '<i class="fa fa-lg icon-unsel"><span class="wb-inv">'. elgg_echo('wet:collapseWidget', array($widget->getTitle())).'</span></i> ',
        'title' => elgg_echo('wet:collapseWidget', array($widget->getTitle())),
		'href' => "#elgg-widget-content-$widget->guid",
		'link_class' => 'elgg-widget-collapse-button ',
		'rel' => 'toggle',
		'priority' => 1,
	);

    $return[] = \ElggMenuItem::factory($options);
	if ($widget->canEdit()) {
		$options = array(
			'name' => 'delete',
			'text' => '<i class="fa fa-trash-o fa-lg icon-unsel"><span class="wb-inv">'.elgg_echo('widget:delete', array($widget->getTitle())).'</span></i>',
			'title' => elgg_echo('widget:delete', array($widget->getTitle())),
			'href' => "action/widgets/delete?widget_guid=$widget->guid",
			'is_action' => true,
			'link_class' => 'elgg-widget-delete-button',
			'id' => "elgg-widget-delete-button-$widget->guid",
			'data-elgg-widget-type' => $widget->handler,
			'priority' => 900,
		);
		$return[] = \ElggMenuItem::factory($options);
        // This is to maybe have a move button on widgets to move them with the keyboard.

		if ($show_edit) {
			$options = array(
				'name' => 'settings',
				'text' => '<i class="fa fa-cog fa-lg icon-unsel"><span class="wb-inv">'.elgg_echo('widget:edit', array($widget->getTitle())).'</span></i>',
				'title' => elgg_echo('widget:edit', array($widget->getTitle())),
				'href' => "#widget-edit-$widget->guid",
				'link_class' => "elgg-widget-edit-button",
				'rel' => 'toggle',
				'priority' => 800,
			);
			$return[] = \ElggMenuItem::factory($options);
		}
	}

	return $return;
}


function wet4_messages_page_handler($page) {

	$current_user = elgg_get_logged_in_user_entity();
	if (!$current_user) {
		register_error(elgg_echo('noaccess'));
		elgg_get_session()->set('last_forward_from', current_page_url());
		forward('');
	}

	elgg_load_library('elgg:messages');

	elgg_push_breadcrumb(elgg_echo('messages'), 'messages/inbox/' . $current_user->username);

	if (!isset($page[0])) {
		$page[0] = 'inbox';
	}

	// Support the old inbox url /messages/<username>, but only if it matches the logged in user.
	// Otherwise having a username like "read" on the system could confuse this function.
	if ($current_user->username === $page[0]) {
		$page[1] = $page[0];
		$page[0] = 'inbox';
	}

	if (!isset($page[1])) {
		$page[1] = $current_user->username;
	}

	$base_dir = elgg_get_plugins_path() . 'wet4/pages/messages';

	switch ($page[0]) {
		case 'inbox':
			set_input('username', $page[1]);
			include("$base_dir/inbox.php");
			break;
		case 'sent':
			set_input('username', $page[1]);
			include("$base_dir/sent.php");
			break;
		case 'read':
			set_input('guid', $page[1]);
			include("$base_dir/read.php");
			break;
		case 'compose':
		case 'add':
			include("$base_dir/send.php");
			break;
		default:
			return false;
	}
	return true;
}
//Friendly Time from GCconnex Codefest 2015 - 2016 - Nick
function enhanced_friendly_time_hook($hook, $type, $return, $params) {

	$diff = time() - ((int) $params['time']);

	$minute = 60;
	$hour = $minute * 60;
	$day = $hour * 24;

	if ($diff < $minute) {
		$friendly_time = elgg_echo("friendlytime:justnow");
	} else if ($diff < $hour) {
		$diff = round($diff / $minute);
		if ($diff == 0) {
			$diff = 1;
		}

		if ($diff > 1) {
			$friendly_time = elgg_echo("friendlytime:minutes", array($diff));
		} else {
			$friendly_time = elgg_echo("friendlytime:minutes:singular", array($diff));
		}
	} else if ($diff < $day) {
		$diff = round($diff / $hour);
		if ($diff == 0) {
			$diff = 1;
		}

		if ($diff > 1) {
			$friendly_time = elgg_echo("friendlytime:hours", array($diff));
		} else {
			$friendly_time = elgg_echo("friendlytime:hours:singular", array($diff));
		}
	} else {
		$diff = round($diff / $day);
		if ($diff == 0) {
			$diff = 1;
		}
		//PHPlord let check for day, days, weeks and finally output date if too far away...
		if ($diff == 1) {
			$friendly_time = elgg_echo("friendlytime:days:singular", array($diff));
		} else if(6 >= $diff){
			$friendly_time = elgg_echo("friendlytime:days", array($diff));
		} else if(13 >= $diff){
			$friendly_time = elgg_echo("friendlytime:weeks:singular", array($diff));
		} else if($diff == 14){
			$friendly_time = elgg_echo("friendlytime:weeks", array($diff));
		} else{
			$date_day = date('d', $params['time']);
			$date_month = date('m', $params['time']);
			$date_year = date('Y', $params['time']);
			$date_hour = date('H', $params['time']);
			$date_minute = date('i', $params['time']);
			$friendly_time = $date_year . '-' . $date_month . '-' . $date_day . ' ' . $date_hour . ':' . $date_minute;
		}
	}

	$attributes = array();
	$attributes['title'] = date(elgg_echo('friendlytime:date_format'), $params['time']);
	$attributes['datetime'] = date('c', $params['time']);
	$attrs = elgg_format_attributes($attributes);

	return "<time $attrs>$friendly_time</time>";
}