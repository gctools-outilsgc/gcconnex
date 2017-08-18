<?php

    $dir_name = dirname(__FILE__);

    $focus_dd = '<a href="#" class="focus_dd_link" style="display:none;"><i class="fa fa-caret-down" aria-hidden="true"></i><span class="wb-inv">'.elgg_echo('wet:dd:expand').'</span></a>';
    //$ajax_dd_readinglist  = '<div aria-hidden="true" id="rl_dd"     class="dropdown-menu user-menu-message-dd rl-dd-position subMenu">'. elgg_view('views/reading_list_dd') . '</div>';
//    $ajax_dd_messages     = '<div aria-hidden="true" id="msg_dd"    class="dropdown-menu user-menu-message-dd message-dd-position subMenu">'. elgg_view('page/elements/messages_dd') . '</div>';
//    $ajax_dd_notification = '<div aria-hidden="true" id="notif_dd"  class="dropdown-menu user-menu-message-dd notif-dd-position subMenu">'. elgg_view('page/elements/notifications_dd') . '</div>';
    
    elgg_register_event_handler('init', 'system', 'reading_list_init');

    function reading_list_init() {
        // register the save action
        elgg_register_action("reading_list/add", __DIR__ . "/actions/reading_list/add.php");
	    elgg_register_action("reading_list/delete", __DIR__ . "/actions/reading_list/delete.php");

        elgg_register_ajax_view('ajax/rl_dd');

        //register a route handler to intercept the bookmarks page
        elgg_register_plugin_hook_handler('route', 'bookmarks', 'reading_list_route_handler');

        elgg_register_plugin_hook_handler("register", "menu:entity",'reading_list_menu_handler' );
        register_menu_items();
    }

    //registers the read list to the bookmarks menu
    function register_menu_items()
    {
        $username = elgg_get_logged_in_user_entity()->username;

        elgg_register_menu_item('filter', array(
            'name' => 'bookmarks',
            'text' => elgg_echo('Reading List'),
            'context' => 'bookmarks',
            'href' => 'bookmarks/reading_list/'. $username,
            "priority" => 600
        ));

        // elgg_register_menu_item('user_menu', array(
        //     'name' => 'bookmarks',
        //     'text' => elgg_echo('Reading List'),
        //     'href' => 'bookmarks/reading_list/'. $username,
        //     "priority" => 3
        // ));

        $ajax_dd_readinglist = '<div aria-hidden="true" id="rl_dd"     class="dropdown-menu user-menu-message-dd rl-dd-position subMenu">'. elgg_view('reading_list/reading_list_dd') . '</div>';

        elgg_register_menu_item('user_menu', array(
            'name' => 'bookmarks',
            // 'text' => '<a href="'.elgg_get_site_url().'bookmarks/reading_list/' . $username.'">
            // <i class="fa fa-newspaper-o mrgn-rght-sm mrgn-tp-sm fa-lg"></i> daf</a>'.$focus_dd.'<div>'.$ajax_dd_notification.'</div>',
            
            'text' => '<a href="'.elgg_get_site_url().'bookmarks/reading_list/' . $username.'"><i class="fa fa-newspaper-o mrgn-rght-sm mrgn-tp-sm fa-lg"></i><span class="hidden-xs">' . elgg_echo('reading_list') . '</span> </a><div>' . $ajax_dd_readinglist . '</div>',
            'title' => elgg_echo('Reading List'),
            'item_class' => 'brdr-lft messagesLabel close-notif-dd',
            'class' => '',
            'priority' => '3',
            'data-dd-type'=>'rl_dd',

    ));

    }

    //intercepts the bookmark page. If the segment is reading_list, stop the routing,
    //otherwise let it proceed.
    function reading_list_route_handler($hook, $type, $returnvalue, $params) {
        $segments = elgg_extract('segments', $returnvalue, array());


        if (isset($segments[0]) && $segments[0] === 'reading_list') {
            
            $pages = dirname(__FILE__). '/pages/reading_list/owner.php';
            include $pages;
            //stop rendering
            return false;
        }
    }

    //adds a read later menu item to the entity menu
    function reading_list_menu_handler($hook, $entity_type, $returnvalue, $params) {
        //return if the params are empty
        if (empty($params) || !is_array($params)) {
	 		return $returnvalue;
	 	}
		
		$entity = elgg_extract("entity", $params);
		
        //return if it's not a blog... maybe support more later
        // if (empty($entity) || !elgg_instanceof($entity, "object", "blog")) {
		//     return $returnvalue;
        // }

        if (empty($entity)){
		    return $returnvalue;
        } elseif(elgg_instanceof($entity, "object", "blog"))
        {
            if ($entity->status == "draft") {
                return $returnvalue;
            }
            
            if (!elgg_in_context("widgets") && !in_readingList() ) {
                $returnvalue[] = \ElggMenuItem::factory(array(
                    "name" => "read_later",
                    "text" => elgg_echo("read later"),
                    "href" => "action/reading_list/add?guid=" . $entity->getGUID(),
                    "is_action" => true,
                    "priority" => 600
                ));
            }
        } elseif (elgg_instanceof($entity, "object", "readinglistitem")){
            
            foreach ($returnvalue as $key => $item) {

                // Remove the "likes" menu item
                unset($returnvalue[$key]);
                
            }


            $returnvalue[] = \ElggMenuItem::factory(array(
				"name" => "delete",
				"text" => elgg_echo("delete"),
				"href" => "action/reading_list/delete?guid=" . $entity->getGUID(),
				"is_action" => true,
				"priority" => 600
			)); 
        }
		
		
        return $returnvalue;
    }

    //determines if the entity is already in the reading list
    function in_readingList()
    {
        return false;
    }
?>