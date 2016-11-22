<?php
/*
* group-tracker.php
*
* Header on groups page that keeps track of number of joined groups
*/
    //check joined groups
$groupsJoined = elgg_get_entities_from_relationship(array(
'relationship'=> 'member',
'relationship_guid'=> elgg_get_logged_in_user_entity()->guid,
'inverse_relationship'=> FALSE,
'type'=> 'group',
'limit'=> false,
'count'=>true,
));

//check requests sent
$groupsRequest = elgg_get_entities_from_relationship(array(
'relationship'=> 'membership_request',
'relationship_guid'=> elgg_get_logged_in_user_entity()->guid,
'inverse_relationship'=> FALSE,
'type'=> 'group',
'limit'=> false,
'count'=>true,
));

//joined + requests
$groups = $groupsJoined + $groupsRequest;

$count = 3 - $groups;

if($count > 0){ //display count
    echo '<h1>'.elgg_echo('onboard:groups:header').'</h1>';

    if($count == 1){
        $title = elgg_echo('onboard:groups:tracker1', array($count));
    } else {
        $title = elgg_echo('onboard:groups:tracker', array($count));
    }


    echo elgg_view('page/elements/onboard_grouptracker', array('title'=>$title,'desc'=>$desc, 'group_page' => true));
} else { //bring back to news feed
    echo '<h1>'.elgg_echo('onboard:groups:header').'</h1>';
    $title = elgg_echo('onboard:groups:trackerHead');
    $desc = elgg_echo('onboard:groups:trackerDesc');
    $btntxt = elgg_echo('onboard:groups:trackerButton');
    $href = 'newsfeed';
    echo elgg_view('page/elements/onboard_grouptracker', array('title'=>$title,'desc'=>$desc,'btntxt'=>$btntxt,'href'=>$href,));
}

    ?>
