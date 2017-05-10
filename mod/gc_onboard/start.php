<?php
/**
 * GCconnex onboarding
 *
 * Welcome Module
 * Profile Module
 * Groups Module
 *
 * Provides more info on the wire via popup
 *
 * @version 1.0
 */


elgg_register_event_handler('init', 'system', 'onboard_ME');

function onboard_ME() {

    elgg_register_page_handler('profileonboard', 'profileonboard_page_handler');
    elgg_register_page_handler('groupsonboard', 'groupsonboard_page_handler');

    //actions
    elgg_register_action("onboard/join", elgg_get_plugins_path() . "gc_onboard/actions/groups/membership/join.php");
    elgg_register_action("onboard/search", elgg_get_plugins_path() . "gc_onboard/actions/groups/onboard-search.php");
    elgg_register_action("onboard/upload", elgg_get_plugins_path() . "/gc_onboard/actions/onboard/upload.php");
    elgg_register_action("onboard/update-profile", elgg_get_plugins_path() . "/gc_onboard/actions/update-profile.php");
    elgg_register_action("onboard/set_cta", elgg_get_plugins_path() . "/gc_onboard/actions/set_cta.php");
    elgg_register_action("onboard/set_wire_metadata", elgg_get_plugins_path() . "/gc_onboard/actions/set_wire_metadata.php");

    //profile strength views
    elgg_register_ajax_view('profileStrength/info');
    elgg_register_ajax_view('profileStrength/infoCard');

    //views for complete profile onboarding
    elgg_register_ajax_view('profile-steps/stepOne');
    elgg_register_ajax_view('profile-steps/stepTwo');
    elgg_register_ajax_view('profile-steps/stepThree');
    elgg_register_ajax_view('profile-steps/stepFour');
    elgg_register_ajax_view('profile-steps/stepFive');

    //views for groups onboarding
    elgg_register_ajax_view('groups-steps/group-tracker');

    //views for intro profile onboarding
    elgg_register_ajax_view('welcome-steps/stepOne');
    elgg_register_ajax_view('welcome-steps/stepTwo');
    elgg_register_ajax_view('welcome-steps/stepThree');
    elgg_register_ajax_view('welcome-steps/stepFour');
    elgg_register_ajax_view('welcome-steps/stepFive');

    //geds view
    elgg_register_ajax_view('welcome-steps/geds/org-people');

    //step counter
    elgg_register_ajax_view('page/elements/step_counter');

    elgg_extend_view('css/elgg', 'onboard/css');
    elgg_extend_view('css/elgg', 'onboard/bootstrap-tour.min');

    //Extend layout for call to action (cta)
    elgg_extend_view('page/layouts/one_sidebar', 'page/elements/onboard_start', 450);
    elgg_extend_view('thewire/sidebar', 'welcome-steps/wire_modal', 449);
    elgg_extend_view('contactform/contactform', 'onboard/module_links');

    //extend newsfeed to launch onboarding
    elgg_extend_view('widgets/stream_newsfeed_index/content', 'onboard/launch', 491);
    elgg_extend_view('widgets/wet_activity/content', 'onboard/launch', 491);

    elgg_require_js("onboard_require");

    elgg_register_js('bootstrap_tour',"mod/gc_onboard/views/default/js/bootstrap-tour.min.js");
    elgg_register_js('group_tour', 'mod/gc_onboard/views/default/js/group_tour.js');

}

function profileonboard_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/onboard-profile.php");
    return true;
}

function groupsonboard_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/onboard-groups.php");
    return true;
}


/*
 * get_my_profile_strength
 *
 * Gets the profile strength of the logged in user as an INT value.
 *
 * @author Ethan Wallace
 * @return [INT] [<Profile strength percent>]
 */
function get_my_profile_strength(){

    $userEnt = elgg_get_logged_in_user_entity();

    //avatar
    if($userEnt->getIconURL() !=  elgg_get_site_url() . '_graphics/icons/user/defaultmedium.gif'){
        $avIcon = '<i class="fa fa-check text-primary"></i>';
        $avTotal = 100;
    }else{
        $avIcon = '<i class="fa fa-exclamation-triangle text-danger"></i>';
        $avTotal = 0;
    }

    //About me
    if($userEnt->description){
        $aboutIcon = '<i class="fa fa-check text-primary"></i>';
        $aboutTotal = 100;
    }else{
        $aboutIcon = '<i class="fa fa-exclamation-triangle text-danger"></i>';
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

    return $userEnt->profilestrength;
}
