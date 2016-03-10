<?php

/*

Name: Achievement_Badges
Author: Globo Gym Purple Cobras
Coded By: Ethan Wallace

Description: 
Expands user profile to add achievements/badges for the user to earn while using GCconnex.
Only the owner of the user profile can see the progress of the achievements.
Sidebar displays earned achievements/badges for everyone to see.

Additional Features to be added:
- notification of achievement level progression
- pass level goal to each badge in sidebar
- add more badges that will encourage user collaboration (eg: Idea Votes Badge, Complete Profile Badge)
- Seperate page to see all progression on achievements/badges

Current Badges:
- Likes Received
- Bookmarks Created
- Colleagues Added
- Comments Made
- Discussions Created
*/


elgg_register_event_handler('init', 'system', 'gcBadges_init');

function gcBadges_init() {

    elgg_extend_view('profile/sidebar', 'profile/sidebar_widget', 450);
    elgg_extend_view('profile/tab-content', 'profile/badge_progress');
    elgg_extend_view('groups/profile/tab_menu', 'profile/tab_menu', 451);
    
}

/*
 * 
 * Grab all badge names
 * When adding new badge make sure everything shares this spelling of badge (ex: discussion)
 * To add new badge add name to $badges array below
 * 
 */


function get_badges(){

    $badges = array('complete', 'bookmark', 'likes', 'discussion', 'colleague', 'comment');

    return $badges;
}


/*
 * Function to notify user
 * 
 *
 */

function notif_level_up($name, $level, $user){
    //_elgg_notify_user
}