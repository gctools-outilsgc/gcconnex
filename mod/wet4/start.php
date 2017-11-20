<?php
/**
 * WET 4 Theme plugin
 *
 * @package wet4Theme
 */

elgg_register_event_handler('init','system','wet4_theme_init');

function wet4_theme_init() {

	/* cyu - global change to sidebars, display when it is not the crawler
	 * the following batch of elgg_extend_view overwrites the elements in the page
	 */
	elgg_extend_view('page/elements/sidebar','page/elements/gsa_view_start',1);
	elgg_extend_view('page/elements/sidebar','page/elements/gsa_view_end',1000);

	elgg_extend_view('page/elements/footer','page/elements/gsa_view_start',1);
	elgg_extend_view('page/elements/footer','page/elements/gsa_view_end',1000);

	elgg_extend_view('navigation/breadcrumbs','page/elements/gsa_view_start',1);
	elgg_extend_view('navigation/breadcrumbs','page/elements/gsa_view_end',1000);

	elgg_extend_view('object/widget/elements/content','page/elements/gsa_view_start',1);
	elgg_extend_view('object/widget/elements/content','page/elements/gsa_view_end',1000);

    // cyu - are we overriding the settings page handler? (note: the one in this plugin does nothing)
    elgg_unregister_page_handler('settings');
    elgg_register_page_handler('settings', '_elgg_wet_user_settings_page_handler');


    //reload groups library to have our sidebar changes

    elgg_register_library('GCconnex_logging', elgg_get_plugins_path() . 'wet4/lib/logging.php');
    elgg_register_library('GCconnex_display_in_language', elgg_get_plugins_path() . 'wet4/lib/translate_display.php');
    //elgg_register_library('elgg:user_settings', elgg_get_plugins_path(). 'wet4/lib/user_settings.php');
    elgg_register_library('wet:custom_core', elgg_get_plugins_path() . 'wet4/lib/custom_core.php');

    //elgg_load_library('user_settings');
    elgg_load_library('GCconnex_logging');
    elgg_load_library('GCconnex_display_in_language');
    elgg_load_library('wet:custom_core');
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

    elgg_register_plugin_hook_handler('register', 'menu:entity', 'wet4_likes_entity_menu_setup', 400);
    //elgg_register_plugin_hook_handler('register', 'menu:entity', 'wet4_delete_entity_menu', 400);

    //questions modifications
    elgg_register_action('object/question/save', elgg_get_plugins_path()."wet4/actions/object/question/save.php"); //add english/french toggle
    elgg_register_page_handler('questions', 'wet_questions_page_handler');
    elgg_unregister_plugin_hook_handler('register', 'menu:filter', 'questions_filter_menu_handler');
    elgg_register_plugin_hook_handler('register', 'menu:filter', 'wet_questions_filter_menu_handler');

	// theme specific CSS
	elgg_extend_view('css/elgg', 'wet4_theme/css');
	elgg_extend_view('css/elgg', 'wet4_theme/custom_css');

    //remove_group_tool_option('activity');

    //extending views to pass metadata to head.php
    elgg_extend_view("object/elements/full", "wet4_theme/track_page_entity", 451);
    elgg_extend_view('profile/wrapper', 'wet4_theme/pass');

    elgg_extend_view('forms/notificationsettings/save', 'forms/notificationsettings/groupsave');

    //register a page handler for friends
    elgg_unregister_page_handler('friends'); //unregister core page handler
    elgg_unregister_page_handler('dashboard'); //unregister dashboard handler to make our own
    elgg_register_page_handler('dashboard', 'wet4_dashboard_page_handler');
    elgg_register_page_handler('friends', '_wet4_friends_page_handler'); //register new page handler for data tables
	elgg_register_page_handler('friendsof', '_wet4_friends_page_handler');
    elgg_register_page_handler('activity', 'activity_page_handler');
    elgg_unregister_page_handler('messages', 'messages_page_handler');
    elgg_register_page_handler('messages', 'wet4_messages_page_handler');

    elgg_register_page_handler('collections', 'wet4_collections_page_handler');

	//register login as menu item into user menu
	elgg_register_event_handler('pagesetup', 'system', 'login_as_add_user_menu_link');

    //datatables css file
	elgg_extend_view('css/elgg', '//cdn.datatables.net/1.10.10/css/jquery.dataTables.css');

	elgg_register_simplecache_view('wet4/validate.js');
    elgg_require_js('wet4/validate');

	//elgg_unextend_view('page/elements/header', 'search/header');
	//elgg_extend_view('page/elements/sidebar', 'search/header', 0);

    //load datatables
    elgg_require_js("wet4/test");

    //the wire reply and thread
    elgg_register_ajax_view("thewire_tools/reply");
	  elgg_register_ajax_view("thewire_tools/thread");
		//viewing phot on newsfeed
    elgg_register_ajax_view("ajax/photo");
		//edit colleague circle
    elgg_register_ajax_view("friend_circle/edit");
		//verfiy department pop up
    elgg_register_ajax_view("verify_department/verify_department");

    //file tools
    elgg_register_ajax_view("file_tools/move");
    //message preview
    elgg_register_ajax_view("messages/message_preview");

    //Group AJAX loading view
		/*REMOVE_GROUP
    elgg_register_ajax_view('ajax/grp_ajax_content');
	elgg_extend_view("js/elgg", "js/wet4/group_ajax");*/
    elgg_extend_view("js/elgg", "js/wet4/discussion_quick_start");



    elgg_extend_view("js/elgg","js/wet4/language_ajax");
    elgg_extend_view("js/elgg","js/wet4/rotate_ajax");

    //Notification / Messages dropdown view
    elgg_register_ajax_view('ajax/notif_dd');

	elgg_register_plugin_hook_handler('head', 'page', 'wet4_theme_setup_head');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'my_owner_block_handler');
    elgg_register_plugin_hook_handler('register', 'menu:title', 'my_title_menu_handler');
    elgg_register_plugin_hook_handler('register', 'menu:filter', 'my_filter_menu_handler');
    elgg_register_plugin_hook_handler('register', 'menu:site', 'my_site_menu_handler');
	elgg_register_plugin_hook_handler('register', 'menu:river', 'river_handler');

    elgg_register_simplecache_view('wet4/test.js');

    //added since goups didnt have this action but called it
    elgg_register_action("discussion_reply/delete", elgg_get_plugins_path() . "/wet4/actions/discussion/reply/delete.php");


    //if(elgg_is_active_plugin('au_subgroups')){
    //    elgg_register_action("groups/invite", elgg_get_plugins_path() . "/wet4/actions/groups/invite.php");
    //}
 elgg_register_action("comment/join", elgg_get_plugins_path() . "groups/actions/groups/membership/join.php");

    elgg_register_action("file/move_folder", elgg_get_plugins_path() . "/wet4/actions/file/move.php");
    elgg_register_action("friends/collections/edit", elgg_get_plugins_path() . "/wet4/actions/friends/collections/edit.php");
    elgg_register_action("login", elgg_get_plugins_path() . "/wet4/actions/login.php", "public");
    elgg_register_action("widgets/delete", elgg_get_plugins_path() . "/wet4/actions/widgets/delete.php");
    elgg_register_action("user/requestnewpassword", elgg_get_plugins_path() . "/wet4/actions/user/requestnewpassword.php", "public");
    elgg_register_action('logout_as', elgg_get_plugins_path() . '/wet4/actions/logout_as.php'); //login as out
    elgg_register_action("question/autocomplete", elgg_get_plugins_path() . "/wet4/actions/object/question/autocomplete.php");
    elgg_register_action("deptactivity/filter", elgg_get_plugins_path() . "/wet4/actions/deptactivity/filter.php");

    //Verify the department action
    elgg_register_action("department/verify_department", elgg_get_plugins_path() . "/wet4/actions/department/verify_department.php");

    // bilingual content upgrade script
    elgg_register_action("wet4/update_to_json", elgg_get_plugins_path() . "/wet4/actions/bilingual_content/update_to_json.php");

	// non-members do not get visible links to RSS feeds
	if (!elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('output:before', 'layout', 'elgg_views_add_rss_link');
	}

    // new widgets
    //registering wet 4 activity widget

    elgg_register_widget_type('suggested_friends', elgg_echo('sf:suggcolleagues'), elgg_echo('sf:suggcolleagues'), array('custom_index_widgets'),false);
    elgg_register_widget_type('feature_tour', 'feature_tour', 'feature_tour', array('custom_index_widgets'),false);

    //WET my groups widget
    elgg_register_widget_type('wet_mygroups_index', $mygroups_title, 'My Groups Index', array('custom_index_widgets'),true);
    elgg_register_widget_type('most_liked', elgg_echo('activity:module:weekly_likes'), elgg_echo('activity:module:weekly_likes'), array('dashboard','custom_index_widgets'),true);


    //Temp fix for river widget
    elgg_unregister_widget_type("group_river_widget");

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


    //set up metadata for user's landing page preference
    if(elgg_is_logged_in()){
        $user = elgg_get_logged_in_user_entity();
        if(!isset($user->landingpage)){
            $user->landingpage = 'news';
        }
    }

    //save new user settings on landing page
    elgg_register_plugin_hook_handler('usersettings:save', 'user', '_elgg_set_landing_page');


    elgg_register_page_handler('groups_autocomplete', 'groups_autocomplete');


    //jobs.gc.ca menu link
    elgg_register_menu_item('subSite', array(
        'name' => 'jobs',
        'text' => elgg_echo('wet:jobs:link'),
        'href' => elgg_echo('wet:jobs:href'),
        'target' => '_blank',
    ));

	//newsfeed-like department pages
	if (elgg_is_logged_in() && elgg_get_plugin_setting('deptActivity', 'wet4')) {

		elgg_register_ajax_view('ajax/deptactivity_check');
		elgg_register_ajax_view('ajax/deptactivity_items');
		elgg_register_page_handler('department', 'department_page_handler');

		if (elgg_is_active_plugin('gc_newsfeed')) {
            elgg_extend_view('widgets/stream_newsfeed_index/content', 'dept_activity/tabs', 451);
            elgg_extend_view('widgets/newsfeed/content', 'dept_activity/tabs', 451);
		}
	}

    /// replacing friend-picker in email to group members
    elgg_register_action('wet4/group_tools/retrieve_group_members', elgg_get_plugins_path().'/wet4/actions/group_tools/retrieve_group_members.php');
    elgg_register_js('cluster-js-min', 'mod/wet4/vendors/clusterize.js/clusterize.min.js');
    elgg_register_js('cluster-js', 'mod/wet4/vendors/clusterize.js/clusterize.js');

}

global $CONFIG;
$dbprefix = elgg_get_config('dbprefix');
    // user default access if enabled
    if ($CONFIG->remove_logged_in) {
    $query = "UPDATE {$dbprefix}entities SET access_id = 2 WHERE access_id = 1";//change access logged in to public
    update_data($query);
}

function department_page_handler() {
    require_once elgg_get_plugins_path() . 'wet4/pages/department/activity.php';
    return true;
}

 /*
  * groups_autocomplete
  * loads library for groups autocomplete in group creation form
  */
function groups_autocomplete() {
    require_once elgg_get_plugins_path() . 'wet4/lib/groups_autocomplete.php';
    return true;
}




function _elgg_wet_user_settings_page_handler($page) {
    global $CONFIG;

    if (!isset($page[0])) {
        $page[0] = 'user';
    }

    if (isset($page[1])) {
        $user = get_user_by_username($page[1]);
        elgg_set_page_owner_guid($user->guid);
    } else {
        $user = elgg_get_logged_in_user_entity();
        elgg_set_page_owner_guid($user->guid);
    }

    elgg_push_breadcrumb(elgg_echo('settings'), "settings/user/$user->username");

    switch ($page[0]) {
        case 'notifications':
            elgg_push_breadcrumb(elgg_echo('cp_notifications:name'));
            $path = elgg_get_plugins_path() . "/cp_notifications/" . "pages/cp_notifications/notification_setting.php";
            break;
        case 'statistics':
            elgg_push_breadcrumb(elgg_echo('usersettings:statistics:opt:linktext'));
            $path = $CONFIG->path . "pages/settings/statistics.php";
            break;
        case 'user':
            $path = $CONFIG->path . "pages/settings/account.php";
            break;
    }

    if (isset($path)) {
        require $path;
        return true;
    }
    return false;
}




/*
 * activity_page_handler
 * Override activity page handler
 */
function activity_page_handler($page){
    elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

    // make a URL segment available in page handler script
    $page_type = elgg_extract(0, $page, 'all');
    $page_type = preg_replace('[\W]', '', $page_type);
    if ($page_type == 'owner') {
        elgg_gatekeeper();
        $page_username = elgg_extract(1, $page, '');
        if ($page_username == elgg_get_logged_in_user_entity()->username) {
            $page_type = 'mine';
        } else {
            set_input('subject_username', $page_username);
        }
    }
    set_input('page_type', $page_type);
    @include (dirname ( __FILE__ ) . "/pages/river.php");
    return true;
}


 /*
  * _elgg_set_landing_page
  * Sets landing page from user settings
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



/*
 * wet4_theme_pagesetup
 * Overrides various menu items to add font awesome icons, reorder items and add accessabilty
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


        //style colleague requests tab
        $context = elgg_get_context();
        $page_owner = elgg_get_page_owner_entity();

        if(elgg_is_logged_in()){
            $user = elgg_get_logged_in_user_guid();
        }

        if ($page_owner instanceof ElggUser && $page_owner->guid == $user) {
            // Show menu link in the correct context
            if (in_array($context, array("friends", "friendsof", "collections"))) {
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
                        //$count = '9+';
                    }
                    $extra = '<span aria-hidden="true" class="notif-badge">' . $count . '</span>';
                }

                // add menu item
                $menu_item = array(
                    "name" => "friend_request",
                    "text" => elgg_echo("friend_request:menu") . $extra,
                    "href" => "friend_request/" . $page_owner->username,
                    "contexts" => array("friends", "friendsof", "collections")
                );

                elgg_register_menu_item("page", $menu_item);


            }
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
				"text" => '<i class="fa fa-users mrgn-rght-sm mrgn-tp-sm fa-lg"></i><span class="hidden-xs">' . elgg_echo("userMenu:colleagues") . '</span>',
				"title" => elgg_echo('userMenu:colleagues'),
        "class" => '',
        'item_class' => '',
				'priority' => '1'
			);

			elgg_register_menu_item("user_menu", $params);


    $context = elgg_get_context();
	$page_owner = elgg_get_page_owner_entity();

	// Remove link to friendsof
	elgg_unregister_menu_item("page", "friends:of");

    // Settings notifications tab in the User's setting page
    // cyu - allow site administrators to view user notification settings page
	elgg_unregister_menu_item('page', '2_a_user_notify');
    if ($page_owner instanceof ElggUser) {
        $params = array(
            "name" => "2_a_user_notify",
            "href" => "/settings/notifications/{$page_owner->username}",
            "text" =>  elgg_echo('notifications:subscriptions:changesettings'),
            'section' => 'configure',
            'priority' => '100',
            'context' => 'settings',
        );
    }


    elgg_register_menu_item("page", $params);

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

/*
 * wet4_likes_entity_menu_setup
 * Override likes entity menu to include font awesome icons and add accessability
 */
function wet4_likes_entity_menu_setup($hook, $type, $return, $params) {
	// make the widget view produce the same entity menu as the other objects
    if (elgg_in_context('widgets')) {
		//return $return;
	}

	$entity = $params['entity'];
	$lang = get_current_language();
	$entContext = $entity->getType();

	//check if entity is an object or group
	if($entContext == 'object'){

		//find subtype
		$contentType = $entity->getSubtype();
		//convert subtype into plain language
		$entContext =  proper_subtypes($contentType);//$entity->getSubtype();

		//check to see if entity is one f the entities with a title
		if(!in_array($entity->getSubtype(), array('comment', 'discussion_reply', 'thewire'))){


			if($entity->title3){
					$entName = gc_explode_translation($entity->title3, $lang);
			}else{
					$entName = $entity->title;
			}

		} else { //if not get owner instead of name

			$entName = $entity->getOwnerEntity()->name;
		}

	} else if($entContext == 'group'){
			$contentType = 'group';
			$entContext = elgg_echo('group');
			if($entity->title3){
					$entName = gc_explode_translation($entity->title3, $lang);
			}else{
					$entName = $entity->name;
			}

	}

	if ($entity->canAnnotate(0, 'likes')) {
		$hasLiked = \Elgg\Likes\DataService::instance()->currentUserLikesEntity($entity->guid);

		//pass type and entiey/owner name to function to return array of text
		$hiddenText = generate_hidden_text($contentType, $entName);

		// Always register both. That makes it super easy to toggle with javascript
		$return[] = ElggMenuItem::factory(array(
			'name' => 'likes',
			'href' => elgg_add_action_tokens_to_url("/action/likes/add?guid={$entity->guid}"),
			'text' => '<i class="fa fa-thumbs-up fa-lg icon-unsel"></i><span class="wb-inv">'.$hiddenText['like'].'</span>',
			'title' => elgg_echo('likes:likethis') . ' ' . $entContext,
			'item_class' => $hasLiked ? 'hidden' : '',
			'priority' => 998,
		));
		$return[] = ElggMenuItem::factory(array(
			'name' => 'unlike',
			'href' => elgg_add_action_tokens_to_url("/action/likes/delete?guid={$entity->guid}"),
			'text' => '<i class="fa fa-thumbs-up fa-lg icon-sel"></i><span class="wb-inv">'.$hiddenText['unlike'].'</span>',
			'title' => elgg_echo('likes:remove') . ' ' . $entContext,
			'item_class' => $hasLiked ? 'pad-rght-xs' : 'hidden',
			'priority' => 998,
		));
	}

	// likes count
	$count = elgg_view('likes/count', array('entity' => $entity));
	if ($count) {
		$options = array(
			'name' => 'likes_count',
			'text' => $count,
			'href' => false,
			'priority' => 999,
      'item_class' => 'entity-menu-bubble',
		);
		$return[] = ElggMenuItem::factory($options);
	}

	return $return;
}


/*
 * wet4_elgg_page_menu_setup
 * Override page menu on user settings page
 */
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

        return $return;
    }

}

/*
 * wet4_blog_entity_menu
 * Override blog entity menu to include font awesome icons and add accessability
 */
function wet4_blog_entity_menu($hook, $entity_type, $returnvalue, $params) {
    if (empty($params) || !is_array($params)) {
        return $returnvalue;
    }

    $entity = elgg_extract("entity", $params);
    if (empty($entity) || !elgg_instanceof($entity, "object", "blog")) {
        return $returnvalue;
    }

		if($entity->title3){
				$entName = gc_explode_translation($entity->title3, $lang);
		}else{
				$entName = $entity->title;
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
            "text" => '<i class="fa fa-lg fa-comment icon-unsel"><span class="wb-inv">' . elgg_echo("entity:comment:link:blog", array($entName)) . '</span></i>',
            "title" => elgg_echo("comment:this"),
            "href" => $entity->getURL() . "#comments"
        ));

    }

    return $returnvalue;
}

/*
 * my_owner_block_handler
 * Override owner_block menu to become tabs in profile
 */
function wet4_elgg_entity_menu_setup($hook, $type, $return, $params) {
	//Have widgets show the same entity menu
    if (elgg_in_context('widgets')) {
		//return $return;
	}

	$entity = $params['entity'];
	$lang = get_current_language();
	/* @var \ElggEntity $entity */
	$handler = elgg_extract('handler', $params, false);

    //Nick -Remove empty comment and reply links from river menu
        foreach ($return as $key => $item){

            switch ($item->getName()) {
                case 'access':
                    //$item->setItemClass('removeMe');
                    unset($return[$key]);
                    break;

            }

    }




    $entContext = $entity->getType();

		//check if entity is an object or group
		if($entContext == 'object'){

			//find subtype
			$contentType = $entity->getSubtype();
			//convert subtype into plain language
			$entContext =  proper_subtypes($contentType);//$entity->getSubtype();

			//check to see if entity is one f the entities with a title
			if(!in_array($entity->getSubtype(), array('comment', 'discussion_reply', 'thewire', 'answer'))){


				if($entity->title3){
						$entName = gc_explode_translation($entity->title3, $lang);
				}else{
						$entName = $entity->title;
				}

			} else { //if not get owner instead of name

				$entName = $entity->getOwnerEntity()->name;
			}

		} else if($entContext == 'group'){
				$contentType = 'group';
				$entContext = elgg_echo('group');
				if($entity->title3){
						$entName = gc_explode_translation($entity->title3, $lang);
				}else{
						$entName = $entity->name;
				}

		}

		//pass type and entiey/owner name to function to return array of text
		$hiddenText = generate_hidden_text($contentType, $entName);


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
                    'text' => '<i class="fa fa-share-alt fa-lg icon-unsel"><span class="wb-inv">'.$hiddenText['share'].'</span></i>',
                    'title' => elgg_echo('thewire_tools:reshare'),
                    'href' => 'ajax/view/thewire_tools/reshare?reshare_guid=' . $entity->getGUID(),
                    'link_class' => 'elgg-lightbox',
                    'item_class' => '',
                    'is_trusted' => true,
                    'priority' => 500
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
                'text' => '<i class="fa fa-reply fa-lg icon-unsel"><span class="wb-inv">'.$hiddenText['reply'].'</span></i>',
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
    $list = str_replace(array('(',')'), '',get_access_list());// clean result
    $list_access = explode(',', $list); // put it in an array
    $user = elgg_get_logged_in_user_entity();
	if ($entity->canEdit() && $handler) {
         if ($entity['owner_guid'] == $user['guid'] || elgg_is_admin_logged_in() || $entity->getSubtype() == 'page_top' && in_array($entity->write_access_id, $list_access)){

        //checks so the edit icon is not placed on incorrect entities
            if($entity->getSubtype() != 'thewire'){
                $options = array(
                    'name' => 'edit',
                    'text' => '<i class="fa fa-edit fa-lg icon-unsel"><span class="wb-inv">'.$hiddenText['edit'].'</span></i>',
                    'title' => elgg_echo('edit:this') . ' ' . $entContext,
                    'href' => "$handler/edit/{$entity->getGUID()}",
                    'priority' => 299,
                );
                $return[] = \ElggMenuItem::factory($options);
            }
		// delete link

            if (elgg_is_logged_in()){
        		$options = array(
        			'name' => 'delete',
        			'text' => '<i class="fa fa-trash-o fa-lg icon-unsel"><span class="wb-inv">'.$hiddenText['delete'].'</span></i>',
        			'title' => elgg_echo('delete:this') . ' ' . $entContext,
        			'href' => "action/$handler/delete?guid={$entity->getGUID()}",
        			'confirm' => elgg_echo('deleteconfirm'),
        			'priority' => 300,
        		);
        		$return[] = \ElggMenuItem::factory($options);
            }
	}
}

    if($entity->getSubType() == 'file'){
        // download link
		$options = array(
			'name' => 'download',
			'text' => '<i class="fa fa-download fa-lg icon-unsel"><span class="wb-inv">'.$hiddenText['download'].'</span></i>',
			'title' => 'Download File',
			'href' => "file/download/{$entity->getGUID()}",
			'priority' => 300,
            //'context' => array('file_tools_selector', 'file'),
		);
		$return[] = \ElggMenuItem::factory($options);
    }


    if($entity->getSubType() == 'page_top'){
                //history icon
            $options = array(
                'name' => 'history',
                'text' => '<i class="fa fa-history fa-lg icon-unsel"><span class="wb-inv">' . $hiddenText['history'] . '</span></i>',
                'title'=> elgg_echo('pages:history'),
                'href' => "pages/history/$entity->guid",
                'priority' => 150,
            );
            $return[] = \ElggMenuItem::factory($options);
        }

//opening and close dicussions
if (elgg_instanceof($entity, "object", "groupforumtopic") && $entity->canEdit() && elgg_is_active_plugin('group_tools')) {
				$return[] = ElggMenuItem::factory(array(
					"name" => "status_change_open",
					"text" => '<i class="fa fa-lock fa-lg icon-unsel"><span class="wb-inv">'.$hiddenText['unlock'].'</span></i>', //elgg_echo("open");,
					"confirm" => elgg_echo("group_tools:discussion:confirm:open"),
					"href" => "action/discussion/toggle_status?guid=" . $entity->getGUID(),
					"is_trusted" => true,
	                 "title" => "Open the topic",
					"priority" => 200,
					"item_class" => ($entity->status == "closed") ? "" : "hidden"
				));
				$return[] = ElggMenuItem::factory(array(
					"name" => "status_change_close",
					"text" => '<i class="fa fa-unlock fa-lg icon-unsel"><span class="wb-inv">'.$hiddenText['lock'].'</span></i>', //elgg_echo("close");,
					"confirm" => elgg_echo("group_tools:discussion:confirm:close"),
					"href" => "action/discussion/toggle_status?guid=" . $entity->getGUID(),
					"is_trusted" => true,
	                "title" => "Close the topic",
					"priority" => 201,
					"item_class" => ($entity->status == "closed") ? "hidden" : ""
				));

			}

			//style comment for Questions mod and switch to FA icon
			if ($entity->canComment()) {
				if (elgg_extract('full_view', $params, false) || ($entity instanceof ElggAnswer)) {
					$options = array(
						'name' => 'comments',
						"text" => '<span class="fa fa-lg fa-comment icon-unsel"><span class="wb-inv">' . elgg_echo("entity:comment:link:".$entity->getSubtype(), array($entName)) . '</span></span>',
						"title" => elgg_echo("comment:this") . ' ' . $entContext,
						'href' => "#comments-add-{$entity->getGUID()}",
						'priority' => 288,
						'rel' => 'toggle'
					);
					$return[] = \ElggMenuItem::factory($options);
				}
			}

	return $return;
}
/*
 * _wet4_friends_page_handler
 * Override friends page handler to use wet4 pages
 */
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

/*
 * wet4_riverItem_remove
 * Remove unwanted river items
 */
function wet4_riverItem_remove(){
    elgg_unregister_menu_item('river', 'comment');
    elgg_unregister_menu_item('river', 'reply');
}
/*
 * wet4_elgg_river_menu_setup
 * Override river menu to use font awesome icons + add accessability
 */
function wet4_elgg_river_menu_setup($hook, $type, $return, $params){
   // $entity = $params['entity'];

	if (elgg_is_logged_in()) {
		$item = $params['item'];
		/* @var \ElggRiverItem $item */
		$object = $item->getObjectEntity();
		$lang = get_current_language();
		// add comment link but annotations cannot be commented on

	if (!$object || !$object->canAnnotate(0, 'likes')) {
		return;
	}
        //Nick -Remove empty comment and reply links from river menu
        foreach ($return as $key => $item){

            switch ($item->getName()) {
                case 'comment':
                    //$item->setItemClass('removeMe');
                    unset($return[$key]);
                    break;
                case 'reply':
                    //$item->setItemClass('removeMe');
                    unset($return[$key]);
                    break;
            }

    }

		$entContext = $object->getType();
		//check if entity is an object or group
		if($entContext == 'object'){

			//find subtype
			$contentType = $object->getSubtype();
			//convert subtype into plain language
			$entContext =  proper_subtypes($contentType);

			//check to see if entity is one f the entities with a title
			if(!in_array($object->getSubtype(), array('comment', 'discussion_reply', 'thewire', 'answer'))){


				if($object->title3){
						$entName = gc_explode_translation($object->title3, $lang);
				}else{
						$entName = $object->title;
				}

			} else { //if not get owner instead of name

				$entName = $object->getOwnerEntity()->name;
			}

		} else if($entContext == 'group'){
				$contentType = 'group';
				$entContext = elgg_echo('group');
				if($object->title3){
						$entName = gc_explode_translation($object->title3, $lang);
				}else{
						$entName = $object->name;
				}

		}

		//pass type and entiey/owner name to function to return array of text
		$hiddenText = generate_hidden_text($contentType, $entName);

	if($entContext != 'user'){

		$hasLiked = \Elgg\Likes\DataService::instance()->currentUserLikesEntity($object->guid);

		// Always register both. That makes it super easy to toggle with javascript
		$return[] = ElggMenuItem::factory(array(
			'name' => 'likes',
			'href' => elgg_add_action_tokens_to_url("/action/likes/add?guid={$object->guid}"),
			'text' => '<i class="fa fa-thumbs-up fa-lg icon-unsel"></i><span class="wb-inv">'.$hiddenText['like'].'</span>',
			'title' => elgg_echo('likes:likethis') . ' ' . $entContext,
			'item_class' => $hasLiked ? 'hidden' : '',
			'priority' => 100,
		));
		$return[] = ElggMenuItem::factory(array(
			'name' => 'unlike',
			'href' => elgg_add_action_tokens_to_url("/action/likes/delete?guid={$object->guid}"),
			'text' => '<i class="fa fa-thumbs-up fa-lg icon-sel"></i><span class="wb-inv">'.$hiddenText['unlike'].'</span>',
			'title' => elgg_echo('likes:remove') . ' ' . $entContext,
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
	}

           $blocked_subtypes = array('comment', 'discussion_reply');
           if(in_array($object->getSubtype(), $blocked_subtypes) || elgg_instanceof($object, 'user')){

               //do not let comments or discussion replies to be reshared on the wire

           } else {
               $return[]= ElggMenuItem::factory(array(
                   'name' => 'thewire_tools_reshare',
                   'text' => '<i class="fa fa-share-alt fa-lg icon-unsel"><span class="wb-inv">'.$hiddenText['share'].'</span></i>',
                   'title' => elgg_echo('thewire_tools:reshare'),
                   'href' => 'ajax/view/thewire_tools/reshare?reshare_guid=' . $object->getGUID(),
                   'link_class' => 'elgg-lightbox',
                   'item_class' => '',
                   'is_trusted' => true,
                   'priority' => 500
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

/*
 * my_filter_menu_handler
 * Rearrange filter menu for The Wire
 */
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

/*
 * my_site_menu_handler
 * Set href of groups link depending if a logged in user is using site
 */
function my_site_menu_handler($hook, $type, $menu, $params){

    if (!is_array($menu))
        return;

    foreach ($menu as $key => $item) {
        if ($item->getName() === 'groups')
            (elgg_is_logged_in()) ? $item->setHref(elgg_get_site_url().'groups/all?filter=yours') : $item->setHref( elgg_get_site_url().'groups/all?filter=popular');
    }
}

/*
 * my_title_menu_handler
 * Add styles to phot album title menu
 */
function my_title_menu_handler($hook, $type, $menu, $params){

    if (!is_array($menu))
        return;

    foreach ($menu as $key => $item) {

        if ($item->getName() === 'slideshow')
            $item->setText(elgg_echo('album:slideshow'));
        elseif ($item->getName() === 'addphotos')
            $item->setItemClass('mrgn-rght-sm');

    }

}

/*
 * my_owner_block_handler
 * Override owner_block menu to become tabs in profile
 */
function my_owner_block_handler($hook, $type, $menu, $params){

    /*
     *
     * If new tool has been added to group tools
     * Make sure the priority is less then 100
     *
     */


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
								case 'questions':
			              $item->setText(elgg_echo('widget:questions:title'));
			              $item->setHref('#question');
			              $item->setPriority('8');
		                break;
            }

        }



    }

}

/*
 * river_handler
 * Remove comment menu item
 */
function river_handler($hook, $type, $menu, $params){

}

/*
 * wet4_dashboard_page_handler
 * Override page handler for wet4 theme - dashboard
 */
function wet4_dashboard_page_handler() {
	// Ensure that only logged-in users can see this page
	elgg_gatekeeper();

	// Set context and title
	elgg_set_context('dashboard');
	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	$title = elgg_echo('dashboard');

	// wrap intro message in a div
	$intro_message = elgg_view('dashboard/blurb', array());

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

/*
 * wet4_widget_menu_setup
 * Override widget menu to use font awesome icons + add accessability
 */
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
			'href' => "action/widgets/delete?widget_guid=$widget->guid&context=" . $widget->getContainerGUID(),
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

/*
 * wet4_collections_page_handler
 * Override page handler for wet4 theme - friend circles
 */
function wet4_collections_page_handler($page) {

	$current_user = elgg_get_logged_in_user_entity();
	if (!$current_user) {
		register_error(elgg_echo('noaccess'));
		elgg_get_session()->set('last_forward_from', current_page_url());
		forward('');
	}
    elgg_set_context('friends');
	//elgg_push_breadcrumb(elgg_echo('messages'), 'messages/inbox/' . $current_user->username);


	$base_dir = elgg_get_plugins_path() . 'wet4/pages/friends/collections';

	switch ($page[0]) {
		case 'owner':
			include("$base_dir/view.php");
			break;
		case 'add':

			include("$base_dir/add.php");
			break;
		case 'edit':

			include("$base_dir/edit.php");
			break;
		default:
			return false;
	}
	return true;
}

/*
 * wet4_messages_page_handler
 * Override page handler for wet4 theme - messages
 */
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
        case 'notifications':
            set_input('username', $page[1]);
            include("$base_dir/notifications.php");
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

/*
 * enhanced_friendly_time_hook
 *
 * Friendly Time from GCconnex Codefest 2015 - 2016
 *
 * @author Nick
 */
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

/*
 * proper_subtypes
 *
 * Takes the subtypes and turns them into the plain language version of the subtype for menu items.
 *
 * @author Ethan Wallace<your.name@example.com>
 * @param [string] [type] [<Entity subtype.>]
 * @return [string] [<Subtype>]
 */
function proper_subtypes($type){

    switch ($type) {
        case 'page_top':
            $subtype = elgg_echo('page');
            break;

				case 'page':
		        $subtype = elgg_echo('page');
		        break;

        case 'thewire':
            $subtype = elgg_echo('wire:post');
            break;

        case 'blog':
            $subtype = elgg_echo('blog:blog');
            break;

        case 'comment':
            $subtype = elgg_echo('comment');
            break;

        case 'groupforumtopic':
            $subtype = elgg_echo('discussion');
            break;

        case 'discussion_reply':
            $subtype = elgg_echo('group:replyitem');
            break;

        case 'file':
            $subtype = elgg_echo('file:file');
            break;

        case 'folder':
            $subtype = elgg_echo('item:object:folder');
            break;

        case 'event_calendar':
            $subtype = elgg_echo('event_calendar:agenda:column:session');
            break;

        case 'bookmarks':
            $subtype = elgg_echo('bookmark');
            break;

        case 'poll':
            $subtype = elgg_echo('poll');
            break;

        case 'album':
            $subtype = elgg_echo('album');
            break;

        case 'image':
            $subtype = elgg_echo('image');
            break;

        case 'idea':
            $subtype = elgg_echo('item:object:idea');
            break;

        case 'groups':
            $subtype = elgg_echo('group:group');
            break;

				case 'question':
						$subtype = elgg_echo('questions:edit:question:title');
						break;

				case 'answer':
				    $subtype = elgg_echo('questions:search:answer:title');
				    break;
    }

    return $subtype;
}

/*
 * generate_hidden_text
 *
 * Takes the type and entity name to generate hidden text for entity/river menus
 *
 * @author Ethan Wallace<your.name@example.com>
 * @param [string] [type] [<Entity subtype.>]
 * @return [array] [<Contains different text for each menu item>]
 */
function generate_hidden_text($type, $name){

	//create all unique menu items
	switch ($type) {
			case 'page_top':
						$hiddenText['history'] = elgg_echo('entity:history:link:'.$type, array($name));
					break;

			case 'page':
						$hiddenText['history'] = elgg_echo('entity:history:link:'.$type, array($name));
					break;

			case 'thewire':
						$hiddenText['reply'] = elgg_echo('entity:reply:link:'.$type, array($name));
					break;

			case 'blog':

					break;

			case 'comment':
						$hiddenText['comment'] = elgg_echo('entity:comment:link:'.$type, array($name));
					break;

			case 'groupforumtopic':
						$hiddenText['lock'] = elgg_echo('entity:lock:link:'.$type, array($name));
						$hiddenText['unlock'] = elgg_echo('entity:unlock:link:'.$type, array($name));
					break;

			case 'discussion_reply':

					break;

			case 'file':
						$hiddenText['download'] = elgg_echo('entity:download:link:'.$type, array($name));
					break;

			case 'folder':

					break;

			case 'event_calendar':

					break;

			case 'bookmarks':

					break;

			case 'poll':

					break;

			case 'album':

					break;

			case 'image':

					break;

			case 'idea':
						$hiddenText['upvote'] = elgg_echo('entity:upvote:link:'.$type, array($name));
						$hiddenText['downvote'] = elgg_echo('entity:downvote:link:'.$type, array($name));
					break;

			case 'groups':

					break;
	}

	//default menus that ever item has
	$hiddenText['like'] = elgg_echo('entity:like:link:'.$type, array($name));
	$hiddenText['unlike'] = elgg_echo('entity:unlike:link:'.$type, array($name));
	$hiddenText['edit'] = elgg_echo('entity:edit:link:'.$type, array($name));
	$hiddenText['delete'] = elgg_echo('entity:delete:link:'.$type, array($name));
	$hiddenText['share'] = elgg_echo('entity:share:link:'.$type, array($name));
  $hiddenText['subscribe'] = elgg_echo('entity:subscribe:link:'.$type, array($name));

	return $hiddenText;
}

/*
 * embed_discussion_river
 *
 * Searches preview text of discussions to find video url to embed that video.
 *
 * @author Ethan Wallace<your.name@example.com>
 * @param [string] [desc] [<Preview text from the discussion.>]
 * @return [string] [<HTML to create embeded video>]
 */
function embed_discussion_river($desc){

    $patterns = array('#(((https://)?)|(^./))(((www.)?)|(^./))youtube\.com/watch[?]v=([^\[\]()<.,\s\n\t\r]+)#i'
						,'#(((https://)?)|(^./))(((www.)?)|(^./))youtu\.be/([^\[\]()<.,\s\n\t\r]+)#i'
						,'/(https:\/\/)?(www\.)?(vimeo\.com\/groups)(.*)(\/videos\/)([0-9]*)(\/)?/'
						,'/(https:\/\/)(www\.)?(metacafe\.com\/watch\/)([0-9a-zA-Z_-]*)(\/[0-9a-zA-Z_-]*)(\/)/'
						 ,'/(https:\/\/)?(www\.)?(vimeo.com\/)([^a-zA-Z][0-9]*)(\/)?/','/(https:\/\/)?(www\.)?(dailymotion.com\/video)([^a-zA-Z][0-9]*)(\/)?/');

    //Replace video providers with embebed content
    foreach($patterns as $pattern){
	    if(preg_match_all($pattern, $desc, $matches)){

            $strAndPara = $matches[0];

	    }
    }
    return $strAndPara;

}


/**
 * Add a menu item to the topbar menu for logging out of an account
 */
function login_as_add_user_menu_link() {
	$item = elgg_get_menu_item('topbar', 'login_as_return');

	if(isset($item)){
			$item->addLinkClass('no-style-link');
			$item->addItemClass('login-as-out');
		elgg_register_menu_item('user_menu', $item);
	}
}

/**
 * Handles all question pages. Modified to add friends page
 *
 * @param array $segments
 *
 * @return bool
 */
function wet_questions_page_handler($segments) {
	elgg_push_breadcrumb(elgg_echo('questions'), 'questions/all');

	$pages = 'mod/questions/pages/questions';
	$new_page = 'mod/wet4/pages/questions';
	switch ($segments[0]) {
		case 'all':
			include "$pages/all.php";
			break;
		case 'todo':
			if (isset($segments[1]) && is_numeric($segments[1])) {
				set_input('group_guid', $segments[1]);
			}
			include "$pages/todo.php";
			break;
		case 'owner':
			if (isset($segments[1]) && is_numeric($segments[1])) {
				elgg_set_page_owner_guid($segments[1]);
			}
			include "$pages/owner.php";
			break;
		case 'view':
			set_input('guid', $segments[1]);
			include "$new_page/view.php";
			break;
		case 'add':
			elgg_gatekeeper();
			include "$pages/add.php";
			break;
		case 'edit':
			elgg_gatekeeper();
			set_input('guid', $segments[1]);
			include "$new_page/edit.php";
			break;
		case 'group':
			elgg_group_gatekeeper();
			include "$new_page/owner.php";
			break;
		case 'friends':
				include "$new_page/friends.php";
				break;
		case 'experts':
			if (isset($segments[1]) && is_numeric($segments[1])) {
				elgg_set_page_owner_guid($segments[1]);
			}
			include "$pages/experts.php";
			break;
		default:
			forward('questions/all');
			return false;
	}

	return true;
}

/**
 * Add menu items to the filter menu. Modified to remove filter menu from group context and add friends filter
 *
 * @param string         $hook   the name of the hook
 * @param string         $type   the type of the hook
 * @param ElggMenuItem[] $items  current return value
 * @param array          $params supplied params
 *
 * @return void|ElggMenuItem[]
 */
function wet_questions_filter_menu_handler($hook, $type, $items, $params) {

	if (empty($items) || !is_array($items) || !elgg_in_context('questions')) {
		return;
	}

	$page_owner = elgg_get_page_owner_entity();

	// change some menu items
	foreach ($items as $key => $item) {
		// add friends back into filter menu
		if ($item->getName() == 'friend') {
			$item->setHref("questions/friends");
		}

		// in group context
		if ($page_owner instanceof ElggGroup) {
			// remove mine
			if ($item->getName() == 'mine') {
				unset($items[$key]);
			}

			if ($item->getName() == 'friend') {
				unset($items[$key]);
			}

			// check if all is correct
			if ($item->getName() === 'all') {
				// remove filter menu in group context
				unset($items[$key]);
			}
		}
	}

	if (questions_is_expert()) {
		$items[] = ElggMenuItem::factory([
			'name' => 'todo',
			'text' => elgg_echo('questions:menu:filter:todo'),
			'href' => 'questions/todo',
			'priority' => 700,
		]);

		if ($page_owner instanceof ElggGroup) {
			$items[] = ElggMenuItem::factory([
				'name' => 'todo_group',
				'text' => elgg_echo('questions:menu:filter:todo_group'),
				'href' => "questions/todo/{$page_owner->getGUID()}",
				'priority' => 710,
			]);
		}
	}

	if (questions_experts_enabled()) {
		$experts_href = 'questions/experts';
		if ($page_owner instanceof ElggGroup) {
			$experts_href .= "/{$page_owner->getGUID()}";
		}

		$items[] = ElggMenuItem::factory([
			'name' => 'experts',
			'text' => elgg_echo('questions:menu:filter:experts'),
			'href' => $experts_href,
			'priority' => 800,
		]);
	}

	return $items;
}
