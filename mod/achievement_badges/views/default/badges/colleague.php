<?php

/*

do all calculations here to send to layout.php to display

*/

//get owner
$user = elgg_get_page_owner_entity();

//if badge is not set, give them nothing
if(!isset($user->colleagueBadge)){
    $user->colleagueBadge = 0;
}

$name = 'colleague';

//get badge images
$badges[0] = 'mod/achievement_badges/graphics/colleagueBadgeLvl00.png';
$badges[1] = 'mod/achievement_badges/graphics/colleagueBadgeLvl01.png';
$badges[2] = 'mod/achievement_badges/graphics/colleagueBadgeLvl02.png';
$badges[3] = 'mod/achievement_badges/graphics/colleagueBadgeLvl03.png';
$badges[4] = 'mod/achievement_badges/graphics/colleagueBadgeLvl04.png';
$badges[5] = 'mod/achievement_badges/graphics/colleagueBadgeLvl05.png';

//set current badge
$currentBadge = $badges[0];

//set level to zero
$level = '1';

//set goals for badge
$goals[0] = 5;
$goals[1] = 15;
$goals[2] = 25;
$goals[3] = 50;
$goals[4] = 150;


$currentGoal = $goals[0];

//current count
$count = '0';




/////
$entities = $user->getFriends(array('limit' => 0));

if($entities){

    $count = count($entities);
}
///



//progress check
if($count < $goals[0]){ //no badge

    $user->colleagueBadge = 0;
    $currentBadge = $badges[0];
    $currentGoal = $goals[0];
    $level = '1';

} else if($count >= $goals[0] && $count < $goals[1]){ //lvl 1

    $user->colleagueBadge = 1;
    $currentBadge = $badges[1];
    $currentGoal = $goals[1];
    $level = '2';

} else if($count >= $goals[1]  && $count < $goals[2]){ //lvl 2

    //$count = $goals[2];
    $user->colleagueBadge = 2;
    $currentBadge = $badges[2];
    $currentGoal = $goals[2];
    $level = '3';

} else if($count >= $goals[2]  && $count < $goals[3]){ //lvl 3

    //$count = $goals[2];
    $user->colleagueBadge = 3;
    $currentBadge = $badges[3];
    $currentGoal = $goals[3];
    $level = '4';

} else if($count >= $goals[3]  && $count < $goals[4]){ //lvl 4

    //$count = $goals[2];
    $user->colleagueBadge = 4;
    $currentBadge = $badges[4];
    $currentGoal = $goals[4];
    $level = '5';

} else if($count >= $goals[4] ){ //lvl 5

    $user->colleagueBadge = 5;
    $count = $goals[4];
    $currentBadge = $badges[5];
    $currentGoal = $goals[4];
    $level = 'Completed';
}

if(!isset($user->colleagueCount)){
    $user->colleagueCount = $count;
}

if($user->colleagueCount > $count){
    //keep count the same to not lose progress
} else {
    $user->colleagueCount = $count;
}

$title = elgg_echo('badge:' . $name . ':name');
$description =  elgg_echo('badge:' . $name . ':objective:' . $user->colleagueBadge);

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

    echo elgg_view('badges/layout/layout', $options);
}
