<?php

/**
 * Newsfeed Header
 *
 * 
 *
 * @version 1.0
 * @author GCTools Team
 */


elgg_register_event_handler('init','system', 'newsfeed_init');


function newsfeed_init(){
    //set up metadata for user's landing page preference
    if(elgg_is_logged_in()){
        $user = elgg_get_logged_in_user_entity();
        if(!isset($user->landingpage)){
            $user->landingpage = 'news';
        }
    }

    //Register newsfeed page handler
    elgg_register_page_handler('newsfeed', 'newsfeed_page_handler');

    if(elgg_is_logged_in()){//for my the my groups widget on the home page
        $mygroups_title = elgg_echo('wet_mygroups:my_groups');
        $wet_activity_title = elgg_echo('wet4:colandgroupactivity');
    }else{
        $mygroups_title = elgg_echo('wet_mygroups:my_groups_nolog');
        $wet_activity_title = elgg_echo('wet4:colandgroupactivitynolog');
    }

    //Register the custom index widget for the newsfeed page
    elgg_register_widget_type('newsfeed', $wet_activity_title, 'Group and Friend Activity', array('custom_index_widgets'),false);
}

//Custom Newsfeed Page
function newsfeed_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/newsfeed.php");
    return true;
}