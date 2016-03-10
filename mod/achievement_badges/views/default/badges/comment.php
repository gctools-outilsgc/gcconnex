<?php

/*

do all calculations here to send to layout.php to display

*/

//get owner
$user = elgg_get_page_owner_entity();

//if badge is not set, give them nothing
if(!isset($user->commentBadge)){
    $user->commentBadge = 0;
}

$name = 'comment';

//get badge images
$badges[0] = 'mod/achievement_badges/graphics/commentBadgeLvl00.png';
$badges[1] = 'mod/achievement_badges/graphics/commentBadgeLvl01.png';
$badges[2] = 'mod/achievement_badges/graphics/commentBadgeLvl02.png';
$badges[3] = 'mod/achievement_badges/graphics/commentBadgeLvl03.png';
$badges[4] = 'mod/achievement_badges/graphics/commentBadgeLvl04.png';
$badges[5] = 'mod/achievement_badges/graphics/commentBadgeLvl05.png';

//set current badge
$currentBadge = $badges[0];

//set level to zero
$level = '1';

//static
$title = 'Comments Badge';
$description = 'Providing your comments to the community';

//set goals for badge
$goals[0] = 1;
$goals[1] = 25;
$goals[2] = 75;
$goals[3] = 200;
$goals[3] = 500;


$currentGoal = $goals[0];

//current count
$count = '0';

/////
$entities =  elgg_get_entities(array('type' => 'object', 'subtype' => 'comment', 'owner_guid' => $user->getGUID(), 'limit' => 0));

if($entities){

    $count = count($entities);
    
} else {
   
}
///

//progress check
if($count < $goals[0]){ //no badge
    
    $user->commentBadge = 0;
    $currentBadge = $badges[0];
    $currentGoal = $goals[0];
    $level = '1';
    
} else if($count >= $goals[0] && $count < $goals[1]){ //lvl 1
    
    $user->commentBadge = 1;
    $currentBadge = $badges[1];
    $currentGoal = $goals[1];
    $level = '2';
    
} else if($count >= $goals[1]  && $count < $goals[2]){ //lvl 2
    
    //$count = $goals[2];
    $user->commentBadge = 2;
    $currentBadge = $badges[2];
    $currentGoal = $goals[2];
    $level = '3';
    
} else if($count >= $goals[2]  && $count < $goals[3]){ //lvl 3
    
    //$count = $goals[2];
    $user->commentBadge = 3;
    $currentBadge = $badges[3];
    $currentGoal = $goals[3];
    $level = '4';

} else if($count >= $goals[3]  && $count < $goals[4]){ //lvl 4

    //$count = $goals[2];
    $user->commentBadge = 4;
    $currentBadge = $badges[4];
    $currentGoal = $goals[4];
    $level = '4';

} else if($count >= $goals[4]){ //lvl 5
    
    //$count = $goals[2];
    $user->commentBadge = 5;
    $count = $goals[4];
    $currentBadge = $badges[5];
    $currentGoal = $goals[4];
    $level = 'Completed';
    
}

if(!isset($user->commentCount)){
    $user->commentCount = $count;
}

if($user->commentCount > $count){
    //keep count the same to not lose progress
} else {
    $user->commentCount = $count;
}

$title = elgg_echo('badge:' . $name . ':name');
$description =  elgg_echo('badge:' . $name . ':objective', array($currentGoal));

if(elgg_is_logged_in() && elgg_get_logged_in_user_guid() == $user->getGUID()){

    //create progress
    $options = array(
        'title' => $title,
        'desc' => $description,
        'src' => $currentBadge,
        'goal' => $currentGoal,
        'count' => $count,
        'level' => $level,
    );

    echo elgg_view('badges/layout/layout', $options);
}