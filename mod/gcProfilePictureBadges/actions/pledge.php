<?php
$pledge = get_input('init');
$active = get_input('active');
$user = elgg_get_logged_in_user_entity();

//check to see if this is an actual badge 
require_once( elgg_get_plugins_path() . "gcProfilePictureBadges/badge_map.php" );	// get array of groups with badges

if(!$active){

    global $initbadges;

    //loop through the badges available to see if there is a match
    foreach($initbadges as $name => $badge){
        if($pledge == $badge){
            //add badge
            $user->init_badge = $pledge;

            //display success
            system_message(elgg_echo('gcProfilePictureBadges:added', array($user->init_badge)));

        }
    }
} else {
    global $initbadges;

            $user->active_badge = $pledge;

            //display success
            system_message(elgg_echo('gcProfilePictureBadges:ambassador:added'));

        
    }



    
    ?>