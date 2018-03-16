<?php
/**
 * GCcollab onboarding
 *
 * Welcome Module
 * Profile Module
 * Groups Module
 *
 * Provides more info on the wire via popup
 *
 * @version 1.0
 */


elgg_register_event_handler('init', 'system', 'onboard_ME_collab');

function onboard_ME_collab() {
    elgg_register_library('elgg:onboarding', elgg_get_plugins_path() . 'gc_onboard_collab/lib/functions.php');

    elgg_register_action("onboard/update-profile", elgg_get_plugins_path() . "/gc_onboard_collab/actions/update-profile.php");

    elgg_register_page_handler('profileonboard', 'profileonboard_collab_page_handler');
    elgg_register_page_handler('groupsonboard', 'groupsonboard_collab_page_handler');
    elgg_register_page_handler('tutorials', 'tutorials_page_handler');

    //views for intro profile onboarding
    elgg_register_ajax_view('welcome-steps/stepOne');
    elgg_register_ajax_view('welcome-steps/stepTwo');
    elgg_register_ajax_view('welcome-steps/stepThree');
    elgg_register_ajax_view('welcome-steps/stepFour');
    elgg_register_ajax_view('welcome-steps/stepFive');
    elgg_register_ajax_view('welcome-steps/stepSix');

    elgg_extend_view('contactform/form', 'onboard/module_links');

}

function profileonboard_collab_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/onboard-profile.php");
    return true;
}

function groupsonboard_collab_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/onboard-groups.php");
    return true;
}

function tutorials_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/tutorials.php");
    return true;
}

/*
 * get_my_profile_strength_collab
 *
 * Gets the profile strength of the logged in user as an INT value.
 *
 * @author Ethan Wallace
 * @return [INT] [<Profile strength percent>]
 */
function get_my_profile_strength_collab(){

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

    if($userEnt->university || $userEnt->college || $userEnt->highschool || $userEnt->federal || $userEnt->ministry || $userEnt->municipal || $userEnt->international || $userEnt->ngo || $userEnt->community || $userEnt->business || $userEnt->media || $userEnt->retired || $userEnt->other){
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
