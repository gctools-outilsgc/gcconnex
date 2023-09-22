<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

// This occurs when the plugin is loaded.
elgg_register_event_handler('init', 'system', 'missions_collab_init');

/*
 * This method runs whenever the plugin is initialized.
 * It mostly handles registration and any other functions that need to run immediately.
 */
function missions_collab_init()
{
    // Register a handler for page navigation.
    elgg_register_page_handler('missions', 'missions_collab_main_page_handler');

    // Extends the original ELGG CSS with our own
    elgg_extend_view('css/elgg', 'css/all-mission-css');

    // Register our action files found in missions/action/
    elgg_register_action("missions/post-mission-skill-match", elgg_get_plugins_path() . "missions_collab/actions/missions/post-mission-skill-match.php");
    elgg_register_action("missions/opt-in-splash", elgg_get_plugins_path() . "missions_collab/actions/missions/opt-in-splash.php");

    // Register an ajax view for adding a group input field.
    elgg_register_ajax_view('missions/add-group');
}

/*
 * Handles all defined url endings ($segments[0]) by loading the appropriate pages file.
 */
function missions_collab_main_page_handler($segments)
{
    switch ($segments[0]) {
        case 'main':
            include elgg_get_plugins_path() . 'missions_collab/pages/missions/main.php';
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
            include elgg_get_plugins_path() . 'missions_collab/pages/missions/mission-candidate-search.php';
            break;
        case 'mission-offer':
        	include elgg_get_plugins_path() . 'missions/pages/missions/mission-offer.php';
        	break;
        case 'reason-to-decline':
        	include elgg_get_plugins_path() . 'missions/pages/missions/reason-to-decline.php';
        	break;

        case 'api':
            if (count($segments) >= 3) {
                if ($segments[1] == 'v0') {
                    switch ($segments[2]) {
                        case 'users':
                            include elgg_get_plugins_path() . 'missions/api/v0/users.php';
                            break;
                        case 'opportunities':
                            include elgg_get_plugins_path() . 'missions/api/v0/opportunities.php';
                            break;
                    }

                }

            }
    }
}
