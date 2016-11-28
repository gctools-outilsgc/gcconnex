<?php
/**
 * gcProfilePictureBadges Pledge Action
 *
 * @package gcProfilePictureBadges
 * @uses get_input('init'); - The badge the user is adding
 * @uses get_input('active'); - which badge to add
 */
$pledge = get_input('init');
$active = get_input('active');
$user = elgg_get_logged_in_user_entity();

//check to see if this is an actual badge
require_once( elgg_get_plugins_path() . "gcProfilePictureBadges/badge_map.php" );	// get array of groups with badges

//check if in the ambassador group
if(!$active){

    global $initbadges;

    //loop through the badges available to see if there is a match
    foreach($initbadges as $name => $badge){
        if($pledge == $badge){
            //add badge
            $user->init_badge = $pledge;
            //display success
            system_message(elgg_echo('gcProfilePictureBadges:added', array(elgg_echo('gcProfilePictureBadges:badge:'.$pledge))));
        }
    }
} else {
    global $badgemap;
            //add badge
            $user->active_badge = $pledge;
            //display success
            system_message(elgg_echo('gcProfilePictureBadges:ambassador:added'));

    }
    ?>
