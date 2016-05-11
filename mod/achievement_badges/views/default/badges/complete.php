<?php

/*

do all calculations here to send to layout.php to display

*/

//get owner
$user = elgg_get_page_owner_entity();

$name = 'complete';

//get badge images
$badges[0] = 'mod/achievement_badges/graphics/completeBadgeLvl00.png';
$badges[1] = 'mod/achievement_badges/graphics/completeBadgeLvl01.png';

//set current badge
$currentBadge = $badges[0];

//set level to zero
$level = '1';

//static
$title = 'Profile Complete Badge';
$description = '100%';

//set goals for badge
$goals[0] = 100;


$currentGoal = $goals[0];

//current count
$count = $user->profilestrength;

if($count < $goals[0]){ //no badge
    
    $user->completeBadge = 0;
    $currentBadge = $badges[0];
    $currentGoal = $goals[0];
    $level = '1';

} else if($count == $goals[0]){ //100% Complete
    
    $user->completeBadge = 1;
    $currentBadge = $badges[1];
    $currentGoal = $goals[0];
    $level = 'Completed';

} 

$title = elgg_echo('badge:' . $name . ':name');
$description =  elgg_echo('badge:' . $name . ':objective:' . $user->completeBadge);

if(elgg_is_logged_in() && elgg_get_logged_in_user_guid() == $user->getGUID()){

    //create progress
    $options = array(
        'title' => $title,
        'desc' => $description,
        'src' => $currentBadge,
        'goal' => $currentGoal,
        'count' => $count,
        'level' => $level,
        'name' => $name,
    );

    echo elgg_view('badges/layout/layout-ps', $options);
}