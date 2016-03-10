<?php

/*

do all calculations here to send to layout.php to display

*/

//get owner
$user = elgg_get_page_owner_entity();

//if badge is not set, give them nothing
if(!isset($user->likesBadge)){
    $user->likesBadge = 0;
}

$name = 'likes';

//get badge images
$badges[0] = 'mod/achievement_badges/graphics/likesBadgeLvl00.png';
$badges[1] = 'mod/achievement_badges/graphics/likesBadgeLvl01.png';
$badges[2] = 'mod/achievement_badges/graphics/likesBadgeLvl02.png';
$badges[3] = 'mod/achievement_badges/graphics/likesBadgeLvl03.png';
$badges[4] = 'mod/achievement_badges/graphics/likesBadgeLvl04.png';
$badges[5] = 'mod/achievement_badges/graphics/likesBadgeLvl05.png';

//set current badge
$currentBadge = $badges[0];

//set level to zero
$level = '1';

//static
$title = 'Likes Badge';
$description = 'People liked your content';
$description = 'Receive likes on your content';

//set goals for badge
$goals[0] = 1;
$goals[1] = 20;
$goals[2] = 40;
$goals[3] = 80;
$goals[4] = 150;


$currentGoal = $goals[0];

//current count
$count = '0';

$entities = elgg_get_entities(array('owner_guids' => $user->getGUID(), 'limit' => 0));

if($entities){
    
    foreach($entities as $ent){
        $likeCount = $likeCount + $ent->countAnnotations(array('name' => 'likes', 'limit' => 0));
    }
    
    //echo $likeCount;
    
    $count = $likeCount;
}

if($count < $goals[0]){ //no badge
    
    $user->likesBadge = 0;
    $currentBadge = $badges[0];
    $currentGoal = $goals[0];
    $level = '1';
    
} else if($count >= $goals[0] && $count < $goals[1]){ //lvl1
    
    $user->likesBadge = 1;
    $currentBadge = $badges[1];
    $currentGoal = $goals[1];
    $level = '2';
    
} else if($count >= $goals[1]  && $count < $goals[2]){ //lvl2
    
    //$count = $goals[2];
    $user->likesBadge = 2;
    $currentBadge = $badges[2];
    $currentGoal = $goals[2];
    $level = '3';
    
} else if($count >= $goals[2] && $count < $goals[3] ){ //lvl3
    
    $user->likesBadge = 3;
    $count = $goals[2];
    $currentBadge = $badges[3];
    $currentGoal = $goals[3];
    $level = '3';

} else if($count >= $goals[3] && $count < $goals[4] ){ //lvl4

    $user->likesBadge = 3;
    $count = $goals[2];
    $currentBadge = $badges[3];
    $currentGoal = $goals[3];
    $level = '3';

} else if($count >= $goals[4]){ //lvl5
    
    $user->likesBadge = 5;
    $count = $goals[4];
    $currentBadge = $badges[5];
    $currentGoal = $goals[4];
    $level = 'Completed';
    
}

if(!isset($user->likeCount)){
    $user->likeCount = $count;
}

if($user->likeCount > $count){
    //keep count the same to not lose progress
} else {
    $user->likeCount = $count;
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