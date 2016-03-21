<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

// This occurs when the plugin is loaded.
elgg_register_event_handler('init', 'system', missions_init);

/*
 * This method runs whenever the plugin is initialized.
 * It mostly handles registration and any other functions that need to run immediately.
 */
function missions_init()
{
	elgg_register_js('typeahead', 'mod/missions/vendors/typeahead/dist/typeahead.bundle.min.js');
	
    // Register the custom library of methods for use in the plugin
    elgg_register_library('elgg:missions', elgg_get_plugins_path() . 'missions/lib/missions.php');
    elgg_register_library('elgg:missions-searching', elgg_get_plugins_path() . 'missions/lib/missions-searching.php');
    elgg_register_library('elgg:missions-errors', elgg_get_plugins_path() . 'missions/lib/missions-errors.php');
    elgg_load_library('elgg:missions');
    elgg_load_library('elgg:missions-searching');
    elgg_load_library('elgg:missions-errors');

    if(elgg_is_active_plugin('missions_organization')) {
   		elgg_load_library('elgg:missions-organization');
    }

    //Register to run unit tests
	register_plugin_hook('unit_test', 'system', 'missions_unit_tests');

    // Register a method to react to the plugin page setup event for the right side menu.
    elgg_register_event_handler('pagesetup', 'system', 'missions_setup_sidebar_menus');

    // Register a handler for page navigation.
    elgg_register_page_handler('missions', 'missions_main_page_handler');

    // Extends the original ELGG CSS with our own
    /*
     * elgg_extend_view('css/elgg', 'css/elements/tabbar');
     * elgg_extend_view('css/elgg', 'css/forms/tabform');
     * elgg_extend_view('css/elgg', 'css/elements/print');
     * elgg_extend_view('css/elgg', 'css/elements/menu');
     * elgg_extend_view('css/elgg', 'css/forms/advancedform');
     */
    elgg_extend_view('css/elgg', 'css/all-mission-css');

    // Register our action files found in missions/action/
    elgg_register_action("missions/post-mission-first-form", elgg_get_plugins_path() . "missions/actions/missions/post-mission-first-form.php");
    elgg_register_action("missions/post-mission-second-form", elgg_get_plugins_path() . "missions/actions/missions/post-mission-second-form.php");
    elgg_register_action("missions/post-mission-third-form", elgg_get_plugins_path() . "missions/actions/missions/post-mission-third-form.php");
    //elgg_register_action("missions/search-form", elgg_get_plugins_path() . "missions/actions/missions/search-form.php");
    //elgg_register_action("missions/display-more", elgg_get_plugins_path() . "missions/actions/missions/display-more.php");
    elgg_register_action("missions/close-from-display", elgg_get_plugins_path() . "missions/actions/missions/close-from-display.php");
    elgg_register_action("missions/search-simple", elgg_get_plugins_path() . "missions/actions/missions/search-simple.php");
    //elgg_register_action("missions/search-prereq", elgg_get_plugins_path() . "missions/actions/missions/search-prereq.php");
    //elgg_register_action("missions/search-language", elgg_get_plugins_path() . "missions/actions/missions/search-language.php");
    //elgg_register_action("missions/search-time", elgg_get_plugins_path() . "missions/actions/missions/search-time.php");
    //elgg_register_action("missions/browse-display", elgg_get_plugins_path() . "missions/actions/missions/browse-display.php");
    elgg_register_action("missions/advanced-search-form", elgg_get_plugins_path() . "missions/actions/missions/advanced-search-form.php");
    elgg_register_action("missions/application-form", elgg_get_plugins_path() . "missions/actions/missions/application-form.php");
    //elgg_register_action("missions/fill-form", elgg_get_plugins_path() . "missions/actions/missions/fill-form.php");
    //elgg_register_action("missions/search-switch", elgg_get_plugins_path() . "missions/actions/missions/search-switch.php");
    elgg_register_action("missions/remove-applicant", elgg_get_plugins_path() . "missions/actions/missions/remove-applicant.php");
    elgg_register_action("missions/accept-invite", elgg_get_plugins_path() . "missions/actions/missions/accept-invite.php");
    elgg_register_action("missions/decline-invite", elgg_get_plugins_path() . "missions/actions/missions/decline-invite.php");
    elgg_register_action("missions/invite-user", elgg_get_plugins_path() . "missions/actions/missions/invite-user.php");
    elgg_register_action("missions/remove-pending-invites", elgg_get_plugins_path() . "missions/actions/missions/remove-pending-invites.php");
    elgg_register_action("missions/change-mission-form", elgg_get_plugins_path() . "missions/actions/missions/change-mission-form.php");
    elgg_register_action("missions/opt-from-main", elgg_get_plugins_path() . "missions/actions/missions/opt-from-main.php");
    elgg_register_action("missions/feedback-form", elgg_get_plugins_path() . "missions/actions/missions/feedback-form.php");
    elgg_register_action("missions/delete-feedback", elgg_get_plugins_path() . "missions/actions/missions/delete-feedback.php");
    elgg_register_action("missions/complete-mission", elgg_get_plugins_path() . "missions/actions/missions/complete-mission.php");
    elgg_register_action("missions/cancel-mission", elgg_get_plugins_path() . "missions/actions/missions/cancel-mission.php");
    elgg_register_action("missions/reopen-mission", elgg_get_plugins_path() . "missions/actions/missions/reopen-mission.php");
    elgg_register_action("missions/refine-my-missions-form", elgg_get_plugins_path() . "missions/actions/missions/refine-my-missions-form.php");

    // Register a new subtype of object for categorizing our mission object.
    elgg_register_entity_type('object', 'mission');
    elgg_register_entity_type('object', 'mission-feedback');

    // Register an ajax view for the advanced search page.
    elgg_register_ajax_view('missions/element-select');
    
   	// Register an ajax view for the weekend dropdown elements.
    //elgg_register_ajax_view('missions/weekend');
    
    // Register an ajax view for adding a skill input field.
    elgg_register_ajax_view('missions/add-skill');

    //Hook which sets the url for object entities upon creation.
    elgg_register_plugin_hook_handler('entity:url', 'object', 'mission_set_url');
    
    // Hook which changes how user entities are displayed.
    elgg_register_plugin_hook_handler('view', 'user/default', 'alter_mission_user_view');
    
    // Changes the manager's owner block in the mission view.
    elgg_register_plugin_hook_handler('view', 'page/elements/owner_block', 'alter_mission_owner_block');
    
    // Hook which changes how user entities are displayed.
    elgg_register_plugin_hook_handler('view', 'annotation/default', 'alter_mission_annotation_view');
    
    // Change the profile owner block for visiting users.
    elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'append_profile_owner_block');

    // Adds a menu item to the original GCConnex sidebar that links to our plugin main page left side menu.
    //$item = new ElggMenuItem('mission_main', elgg_echo('missions:micromissions'), 'missions/main');
    //elgg_register_menu_item('user_menu', $item);
    elgg_register_menu_item('site', array(
    		'name' => 'mission_main',
    		'href' => elgg_get_site_url() . 'missions/main',
    		'text' => elgg_echo('missions:micromissions')
    ));
    
    // Testing purposes only (so far).
    //elgg_register_plugin_hook_handler('send', 'notification:site', 'missions_site_notifications_send');
}

/*
 * Creates a right side sidebar menu when our main page is being setup.
 * Menu items have priority as an alternate method to determine the order of items.
 * Lower priority means they are higher on the list.
 */
function missions_setup_sidebar_menus()
{
    if (elgg_get_context() == 'missions') {
        elgg_register_menu_item('mission_main', array(
            'name' => 'post_opportunity',
            'href' => elgg_get_site_url() . 'missions/mission-post/step-one',
            'text' => elgg_echo('missions:post_opportunity'),
            'priority' => 5
        ));
        /*
         * elgg_register_menu_item('mission_main', array(
         * 'name' => 'find_opportunity',
         * 'href' => elgg_get_site_url() . 'missions/search-mission',
         * 'text' => elgg_echo('missions:find_opportunity'),
         * 'priority' => 10
         * ));
         * elgg_register_menu_item('mission_main', array(
         * 'name' => 'close_opportunity',
         * 'href' => elgg_get_site_url() . 'missions/close-mission',
         * 'text' => elgg_echo('missions:close_opportunity'),
         * 'priority' => 10
         * ));
         */
        elgg_register_menu_item('mission_main', array(
            'name' => 'search',
            'href' => elgg_get_site_url() . 'missions/search',
            'text' => elgg_echo('missions:search'),
            'priority' => 10
        ));
        /*
         * elgg_register_menu_item('mission_search', array(
         * 'name' => 'simple',
         * 'href' => elgg_get_site_url() . 'missions/search/simple',
         * 'text' => elgg_echo('missions:simple_search'),
         * 'priority' => 5
         * ));
         * elgg_register_menu_item('mission_search', array(
         * 'name' => 'prereq',
         * 'href' => elgg_get_site_url() . 'missions/search/prereq',
         * 'text' => elgg_echo('missions:prereq_search'),
         * 'priority' => 10
         * ));
         * elgg_register_menu_item('mission_search', array(
         * 'name' => 'language',
         * 'href' => elgg_get_site_url() . 'missions/search/language',
         * 'text' => elgg_echo('missions:language_search'),
         * 'priority' => 10
         * ));
         * elgg_register_menu_item('mission_search', array(
         * 'name' => 'time',
         * 'href' => elgg_get_site_url() . 'missions/search/time',
         * 'text' => elgg_echo('missions:time_search'),
         * 'priority' => 10
         * ));
         * elgg_register_menu_item('mission_refine', array(
         * 'name' => 'prereq',
         * 'href' => elgg_get_site_url() . 'missions/search/prereq?ref=true',
         * 'text' => elgg_echo('missions:prereq_refine'),
         * 'priority' => 20
         * ));
         * elgg_register_menu_item('mission_refine', array(
         * 'name' => 'language',
         * 'href' => elgg_get_site_url() . 'missions/search/language?ref=true',
         * 'text' => elgg_echo('missions:language_refine'),
         * 'priority' => 20
         * ));
         * elgg_register_menu_item('mission_refine', array(
         * 'name' => 'time',
         * 'href' => elgg_get_site_url() . 'missions/search/time?ref=true',
         * 'text' => elgg_echo('missions:time_refine'),
         * 'priority' => 20
         * ));
         */
        elgg_register_menu_item('mission_main', array(
            'name' => 'browse',
            'href' => elgg_get_site_url() . 'action/missions/browse-display',
            'text' => elgg_echo('missions:browse_missions'),
            'priority' => 20,
            'is_action' => true
        ));
        elgg_register_menu_item('mission_main', array(
            'name' => 'advanced',
            'href' => elgg_get_site_url() . 'missions/advanced-search',
            'text' => elgg_echo('missions:advanced_search'),
            'priority' => 15
        ));
        elgg_register_menu_item('mission_main', array(
            'name' => 'user_missions',
            'href' => elgg_get_site_url() . 'missions/mission-mine/all',
            'text' => elgg_echo('missions:my_missions'),
            'priority' => 25
        ));
    }
}

/*
 * Handles all defined url endings ($segments[0]) by loading the appropriate pages file.
 */
function missions_main_page_handler($segments)
{
    switch ($segments[0]) {
        case 'main':
            include elgg_get_plugins_path() . 'missions/pages/missions/main.php';
            break;
        case 'post-mission-first-tab':
            include elgg_get_plugins_path() . 'missions/pages/missions/post-mission-first-tab.php';
            break;
        case 'post-mission-second-tab':
            include elgg_get_plugins_path() . 'missions/pages/missions/post-mission-second-tab.php';
            break;
        case 'post-mission-third-tab':
            include elgg_get_plugins_path() . 'missions/pages/missions/post-mission-third-tab.php';
            break;
        case 'search-mission':
            include elgg_get_plugins_path() . 'missions/pages/missions/search-mission.php';
            break;
        case 'display-search-set':
            include elgg_get_plugins_path() . 'missions/pages/missions/display-search-set.php';
            break;
        /*
         * The search case is a bit different since it is a single page with different possible forms.
         * The 'search_page_helper' SESSION variable determines which form will be used.
         */
        case 'search':
            switch ($segments[1]) {
                case 'simple':
                    $_SESSION['search_page_type'] = 'simple';
                    break;
                /*case 'prereq':
                    $_SESSION['search_page_type'] = 'prereq';
                    break;
                case 'time':
                    $_SESSION['search_page_type'] = 'time';
                    break;
                case 'language':
                    $_SESSION['search_page_type'] = 'language';
                    break;*/
                default:
                    $_SESSION['search_page_type'] = 'simple';
            }
            include elgg_get_plugins_path() . 'missions/pages/missions/search.php';
            break;
        case 'advanced-search':
            include elgg_get_plugins_path() . 'missions/pages/missions/advanced-search.php';
            break;
        case 'mission-application':
            include elgg_get_plugins_path() . 'missions/pages/missions/mission-application.php';
            break;
        case 'mission-fill':
            include elgg_get_plugins_path() . 'missions/pages/missions/mission-fill.php';
            break;
        case 'mission-mine':
            include elgg_get_plugins_path() . 'missions/pages/missions/mission-mine.php';
            break;
        case 'mission-invitation':
            include elgg_get_plugins_path() . 'missions/pages/missions/mission-invitation.php';
            break;
        case 'mission-select-invite':
            include elgg_get_plugins_path() . 'missions/pages/missions/mission-select-invite.php';
            break;
        case 'mission-edit':
            include elgg_get_plugins_path() . 'missions/pages/missions/mission-edit.php';
            break;
        case 'view':
        	include elgg_get_plugins_path() . 'missions/pages/missions/mission-view.php';
            break;
        case 'mission-feedback':
            include elgg_get_plugins_path() . 'missions/pages/missions/mission-feedback.php';
            break;
        case 'message-share':
            include elgg_get_plugins_path() . 'missions/pages/missions/message-share.php';
            break;
        case 'mission-post':
          	include elgg_get_plugins_path() . 'missions/pages/missions/mission-post.php';
            break;
        case 'mission-candidate-search':
            include elgg_get_plugins_path() . 'missions/pages/missions/mission-candidate-search.php';
            break;
    }
}



/**
 * Adds this plugin's unit tests when unit test hook is triggered
 *
 * @param $hook
 * @param $type
 * @param $value
 * @param $params
 * @return array
 *
 * to run the tests: http://127.0.0.1/gcconnex/engine/tests/suite.php
 *
 */
function missions_unit_tests($hook, $type, $value, $params) {
	//global $CONFIG;
	$value[] = /*$CONFIG->path*/ elgg_get_config('path') . 'mod/missions/testable/simpletest/missionPluginTest.php';
	return $value;
}

function mission_set_url($hook, $type, $returnvalue, $params) {
	$entity = $params['entity'];
	if(elgg_instanceof($entity, 'object', 'mission')) {
		return 'missions/view/' . $entity->guid;
	}
}

// Changes the view of the user entity if the context is 'mission'.
function alter_mission_user_view($hook, $type, $returnvalue, $params) {
    $current_uri = $_SERVER['REQUEST_URI'];
    
    if(strpos($current_uri, 'display-search-set') === false) {
        return $returnvalue;
    }
    else {
        return $returnvalue . elgg_view('user/mission-candidate', array('user' => $params['vars']['entity']));
    }
}

// Changes the owner block for the mission entity view.
function alter_mission_owner_block($hook, $type, $returnvalue, $params) {
    $is_mission = $params['vars']['is_mission'];
    if(!$is_mission) {
        return $returnvalue;
    }
    else {
        $owner = elgg_get_page_owner_entity();
        
        if ($owner instanceof ElggGroup || ($owner instanceof ElggUser && $owner->getGUID() != elgg_get_logged_in_user_guid())) {
            $header = '<h3>' . elgg_echo('missions:managed_by') . ':</h3>';
            $header .= elgg_view_entity($owner, array('full_view' => false));
            
            return elgg_view('page/components/module', array(
                'header' => $header,
                'body' => '',
                'class' => 'elgg-owner-block'
            ));
        }
    }
}

// Changes the profile owner block to allow the profile owner to be invited by another user reading their profile.
function append_profile_owner_block($hook, $type, $returnvalue, $params) {
    $user = get_user(elgg_get_page_owner_guid());
    if(elgg_get_logged_in_user_guid() != elgg_get_page_owner_guid() && $user->opt_in_missions == 'gcconnex_profile:opt:yes') {
        $returnvalue[] = new ElggMenuItem('user_invite_from_profile', elgg_echo('missions:invite_to_a_mission'), 'missions/mission-select-invite/' . elgg_get_page_owner_guid());
        return $returnvalue;
    }
    else {
        return $returnvalue;
    }
}

/*function alter_mission_annotation_view($hook, $type, $returnvalue, $params) {
	$current_uri = $_SERVER['REQUEST_URI'];
	$annotation = $params['vars']['annotation'];
	
	if(strpos($current_uri, 'view') === false && elgg_get_context() != 'missions') {
		return $returnvalue;
	}
	else {
		if(elgg_get_logged_in_user_guid() == $annotation->owner_guid) {
			return $returnvalue . elgg_view('output/url', array(
            	'href' => elgg_get_site_url() . 'action/missions/delete-feedback?aid=' . $annotation->id,
            	'text' => elgg_echo('missions:delete'),
            	'is_action' => true,
            	'class' => 'elgg-button btn btn-default',
				'style' => 'display:inline-block;'
        	));
		}
	}
	
	return $returnvalue;
}*/

// Testing functionality to try and debug site notifications.
/*function missions_site_notifications_send($hook, $type, $returnvalue, $params) {
	//system_message('MESSAGE HOOK!');
	//system_message($params['notification']->getSenderGUID() . '@' . $params['notification']->getRecipientGUID());
	//system_message($params['notification']->guid . '#');
	
	return $params['notification'];
}*/