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
	//elgg_register_js('googlecharts', 'mod/missions/vendors/googlecharts/googlecharts.js');
	elgg_register_js('missions_flot', 'mod/wet4/js/deps/jquery.flot.js');
	elgg_register_js('missions_flot_stack_patched', 'mod/missions/vendors/flot_extra/jquery.flot.stack.patched.js');
	
    // Register the custom library of methods for use in the plugin
    elgg_register_library('elgg:missions', elgg_get_plugins_path() . 'missions/lib/missions.php');
    elgg_register_library('elgg:missions-searching', elgg_get_plugins_path() . 'missions/lib/missions-searching.php');
    elgg_register_library('elgg:missions-errors', elgg_get_plugins_path() . 'missions/lib/missions-errors.php');
    elgg_register_library('elgg:missions-analytics', elgg_get_plugins_path() . 'missions/lib/missions-analytics.php');
    elgg_load_library('elgg:missions');
    elgg_load_library('elgg:missions-searching');
    elgg_load_library('elgg:missions-errors');
    elgg_load_library('elgg:missions-analytics');

   	elgg_load_library('elgg:missions-organization');

    //Register to run unit tests
	register_plugin_hook('unit_test', 'system', 'missions_unit_tests');

    // Register a handler for page navigation.
    elgg_register_page_handler('missions', 'missions_main_page_handler');

    // Extends the original ELGG CSS with our own
    elgg_extend_view('css/elgg', 'css/all-mission-css');

    // Register our action files found in missions/action/
    elgg_register_action("missions/post-mission-first-form", elgg_get_plugins_path() . "missions/actions/missions/post-mission-first-form.php");
    elgg_register_action("missions/post-mission-second-form", elgg_get_plugins_path() . "missions/actions/missions/post-mission-second-form.php");
    elgg_register_action("missions/post-mission-third-form", elgg_get_plugins_path() . "missions/actions/missions/post-mission-third-form.php");
    elgg_register_action("missions/delete-mission", elgg_get_plugins_path() . "missions/actions/missions/delete-mission.php");
    elgg_register_action("missions/search-simple", elgg_get_plugins_path() . "missions/actions/missions/search-simple.php");
    elgg_register_action("missions/advanced-search-form", elgg_get_plugins_path() . "missions/actions/missions/advanced-search-form.php");
    elgg_register_action("missions/application-form", elgg_get_plugins_path() . "missions/actions/missions/application-form.php");
    elgg_register_action("missions/remove-applicant", elgg_get_plugins_path() . "missions/actions/missions/remove-applicant.php");
    elgg_register_action("missions/accept-invite", elgg_get_plugins_path() . "missions/actions/missions/accept-invite.php");
    elgg_register_action("missions/decline-invite", elgg_get_plugins_path() . "missions/actions/missions/decline-invite.php");
    elgg_register_action("missions/invite-user", elgg_get_plugins_path() . "missions/actions/missions/invite-user.php");
    elgg_register_action("missions/change-mission-form", elgg_get_plugins_path() . "missions/actions/missions/change-mission-form.php");
    elgg_register_action("missions/feedback-form", elgg_get_plugins_path() . "missions/actions/missions/feedback-form.php");
    elgg_register_action("missions/complete-mission", elgg_get_plugins_path() . "missions/actions/missions/complete-mission.php");
    elgg_register_action("missions/cancel-mission", elgg_get_plugins_path() . "missions/actions/missions/cancel-mission.php");
    elgg_register_action("missions/reopen-mission", elgg_get_plugins_path() . "missions/actions/missions/reopen-mission.php");
    elgg_register_action("missions/refine-my-missions-form", elgg_get_plugins_path() . "missions/actions/missions/refine-my-missions-form.php");
    elgg_register_action("missions/wire-post", elgg_get_plugins_path() . "missions/actions/missions/wire-post.php");
    elgg_register_action("missions/mission-offer", elgg_get_plugins_path() . "missions/actions/missions/mission-offer.php");
    elgg_register_action("missions/duplicate-mission", elgg_get_plugins_path() . "missions/actions/missions/duplicate-mission.php");
    elgg_register_action("missions/mission-invite-selector", elgg_get_plugins_path() . "missions/actions/missions/mission-invite-selector.php");
    elgg_register_action("missions/change-entities-per-page", elgg_get_plugins_path() . "missions/actions/missions/change-entities-per-page.php");
    elgg_register_action("missions/admin-form", elgg_get_plugins_path() . "missions/actions/missions/admin-form.php");
    elgg_register_action("missions/endorse-user", elgg_get_plugins_path() . "missions/actions/missions/endorse-user.php");
    elgg_register_action("missions/post-mission-skill-match", elgg_get_plugins_path() . "missions/actions/missions/post-mission-skill-match.php");
    elgg_register_action("missions/pre-create-opportunity", elgg_get_plugins_path() . "missions/actions/missions/pre-create-opportunity.php");
    elgg_register_action("missions/finalize-offer", elgg_get_plugins_path() . "missions/actions/missions/finalize-offer.php");
    elgg_register_action("missions/message-user-form", elgg_get_plugins_path() . "missions/actions/missions/message-user-form.php");
    elgg_register_action("missions/sort-missions-form", elgg_get_plugins_path() . "missions/actions/missions/sort-missions-form.php");
    elgg_register_action("missions/opt-in-splash", elgg_get_plugins_path() . "missions/actions/missions/opt-in-splash.php");

    // Register a new subtype of object for categorizing our mission object.
    elgg_register_entity_type('object', 'mission');
    elgg_register_entity_type('object', 'mission-feedback');
    elgg_register_entity_type('object', 'mission-declination');

    // Register an ajax view for the advanced search page.
    elgg_register_ajax_view('missions/element-select');
    
    // Register an ajax view for adding a skill input field.
    elgg_register_ajax_view('missions/add-skill');

    // 
    elgg_register_ajax_view('missions/analytics-inputs');
    
    // Register an ajax view for generating an analytics graph.
    elgg_register_ajax_view('missions/analytics-generator');
    
    // Register an ajax view for the opt in on splash
    elgg_register_ajax_view('missions/opt_in_splash');
    
    //Hook which sets the url for object entities upon creation.
    elgg_register_plugin_hook_handler('entity:url', 'object', 'mission_set_url');
    
    // Hook which changes how user entities are displayed.
    elgg_register_plugin_hook_handler('view', 'user/default', 'alter_mission_user_view');
    
    // Changes the manager's owner block in the mission view.
    elgg_register_plugin_hook_handler('view', 'page/elements/owner_block', 'alter_mission_owner_block');

    // Adds a menu item to the site menu (top bar).
    elgg_register_menu_item('site', array(
    		'name' => 'mission_main',
    		'href' => elgg_get_site_url() . 'missions/main',
    		'text' => elgg_echo('missions:micromissions_menu')
    ));
    
    // Adds a menu item to the admin page under the administer section in the right hand bar.
    elgg_register_menu_item('page', array(
    		'name' => 'mission_admin_tool',
    		'href' => elgg_get_site_url() . 'admin/missions/main',
    		'text' => elgg_echo('missions:admin_tool'),
    		'section' => 'administer',
    		'contexts' => array('admin')
    ));
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
        case 'display-search-set':
            include elgg_get_plugins_path() . 'missions/pages/missions/display-search-set.php';
            break;
        case 'mission-application':
            include elgg_get_plugins_path() . 'missions/pages/missions/mission-application.php';
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
        case 'mission-offer':
        	include elgg_get_plugins_path() . 'missions/pages/missions/mission-offer.php';
        	break;
        case 'reason-to-decline':
        	include elgg_get_plugins_path() . 'missions/pages/missions/reason-to-decline.php';
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
    
    if(strpos($current_uri, 'missions') === false) {
        return $returnvalue;
    }
    else {
    	if(strpos($current_uri, 'missions/view') === false && 
    			strpos($current_uri, 'missions/mission-invitation') === false && 
    			strpos($current_uri, 'missions/mission-edit') === false && 
    			strpos($current_uri, 'missions/mission-offer') === false) {
        	return elgg_view('user/mission-candidate', array('user' => $params['vars']['entity']));
    	}
    	else {
    		return $returnvalue;
    	}
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