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


function checkProfileStrength(){
    $user_guid = elgg_get_page_owner_guid();
    $userEnt = get_user ( $user_guid );

    //avatar
    if($userEnt->getIconURL() !=  elgg_get_site_url() . '_graphics/icons/user/defaultmedium.gif'){

        $avTotal = 100;
    }else{

        $avTotal = 0;
    }

    //About me
    if($userEnt->description){

        $aboutTotal = 100;
    }else{

        $aboutTotal = 0;
    }

    //basic profile
    $basicCount = 0;

    if($userEnt->department){
        $basicCount += 20;
    }
    if($userEnt->job){
        $basicCount += 20;
    }
    if($userEnt->location || $userEnt->addressString || $userEnt->addressStringFr){
        $basicCount += 20;
    }
    if($userEnt->email){
        $basicCount += 20;
    }
    if($userEnt->phone || $userEnt->mobile){
        $basicCount += 20;
    }

    //education
    if(count($userEnt->education) >= 1){
        $eduCount = 100;
    } else {
        $eduCount = 0;
    }

    //work experience
    if(count($userEnt->work) >= 1){
        $workCount = 100;
    } else {
        $workCount = 0;
    }

    //skills
    if(count($userEnt->gc_skills) >= 3){
        $skillCount = 100;
    } else {
        $skillCount = round(count($userEnt->gc_skills)/3*100);
    }

    //overall total
    $complete = round(($skillCount + $workCount + $eduCount + $basicCount + $aboutTotal + $avTotal)/6);

    //set up profile strength metadata
    $userEnt->profilestrength = $complete;
}