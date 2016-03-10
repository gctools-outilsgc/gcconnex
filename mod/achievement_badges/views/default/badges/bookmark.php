<?php

/*

do all calculations here to send to layout.php to display

*/

//get owner
$user = elgg_get_page_owner_entity();

//if badge is not set, give them nothing
if(!isset($user->bookmarkBadge)){
    $user->bookmarkBadge = 0;
}

$name = 'bookmark';

//get badge images
$badges[0] = 'mod/achievement_badges/graphics/bookmarkBadgeLvl00.png';
$badges[1] = 'mod/achievement_badges/graphics/bookmarkBadgeLvl01.png';
$badges[2] = 'mod/achievement_badges/graphics/bookmarkBadgeLvl02.png';
$badges[3] = 'mod/achievement_badges/graphics/bookmarkBadgeLvl03.png';
$badges[4] = 'mod/achievement_badges/graphics/bookmarkBadgeLvl04.png';
$badges[5] = 'mod/achievement_badges/graphics/bookmarkBadgeLvl05.png';

//set current badge
$currentBadge = $badges[0];

//set level to zero
$level = '1';

//static
$title = 'Bookmarks Badge';
$description = 'Created bookmarks';

//set goals for badge
$goals[0] = 5;
$goals[1] = 10;
$goals[2] = 30;
$goals[3] = 45;
$goals[4] = 75;


$currentGoal = $goals[0];

//current count
$count = '0';




/////
$entities = elgg_get_entities(array(
    'type' => 'object',
    'subtype' => 'bookmarks',
    'owner_guid' => $user->getGUID(),
));

if($entities){
    
    /*
    foreach($entities as $ent){
        $likeCount = $likeCount + $ent->countAnnotations('likes');
    }
    */
    //echo $likeCount;
    
    $count = count($entities);
}
///



//progress check
if($count < $goals[0]){ //no badge
    
    $user->bookmarkBadge = 0;
    $currentBadge = $badges[0];
    $currentGoal = $goals[0];
    $level = '1';
    
} else if($count >= $goals[0] && $count < $goals[1]){ //lvl 1
    
    $user->bookmarkBadge = 1;
    $currentBadge = $badges[1];
    $currentGoal = $goals[1];
    $level = '2';
    
} else if($count >= $goals[1]  && $count < $goals[2]){ //lvl 2
    
    //$count = $goals[2];
    $user->bookmarkBadge = 2;
    $currentBadge = $badges[2];
    $currentGoal = $goals[2];
    $level = '3';
    
} else if($count >= $goals[2]  && $count < $goals[3]){ //lvl 3
    
    //$count = $goals[2];
    $user->bookmarkBadge = 3;
    $currentBadge = $badges[3];
    $currentGoal = $goals[3];
    $level = '4';
    
} else if($count >= $goals[3]  && $count < $goals[4]){ //lvl 4
    
    //$count = $goals[2];
    $user->bookmarkBadge = 4;
    $currentBadge = $badges[4];
    $currentGoal = $goals[4];
    $level = '5';
    
} else if($count >= $goals[4] ){ //lvl 5
    
    $user->bookmarkBadge = 5;
    $count = $goals[4];
    $currentBadge = $badges[5];
    $currentGoal = $goals[4];
    $level = 'Completed';
}

if(!isset($user->bookmarkCount)){
    $user->bookmarkCount = $count;
}

if($user->bookmarkCount > $count){
    //keep count the same to not lose progress
} else {
    $user->bookmarkCount = $count;
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