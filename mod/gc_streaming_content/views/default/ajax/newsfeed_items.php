<?php
$title = elgg_echo('river:all');
$user = elgg_get_logged_in_user_entity();
$db_prefix = elgg_get_config('dbprefix');
$page_filter = 'all';
$latestId = get_input('latest');

if ($user) {
    //check if user exists and has friends or groups
    $hasfriends = $user->getFriends();
    $hasgroups = $user->getGroups();
    if($hasgroups){
        //loop through group guids
        $groups = $user->getGroups(array('limit'=>0,)); //increased limit from 10 groups to all
        $group_guids = array();
        foreach ($groups as $group) {
            $group_guids[] = $group->getGUID();
        }
    }
}
if(!$hasgroups && !$hasfriends){
    //no friends and no groups :(
    $activity = '';
}else if(!$hasgroups && $hasfriends){
    //has friends but no groups
    $optionsf['relationship_guid'] = elgg_get_logged_in_user_guid();
    $optionsf['relationship'] = 'friend';
    $optionsf['pagination'] = true;

    //turn off friend connections
    //remove friend connections from action types
    $actionTypes = array('comment', 'create', 'join', 'update', 'friend', 'reply');
    //load user's preference
    $filteredItems = array($user->colleagueNotif);
    //filter out preference
    $optionsf['action_types'] = array_diff( $actionTypes, $filteredItems);
    $optionsf['wheres'] = array("rv.id > {$latestId}");

    $activity = newsfeed_list_river($optionsf);
}else if(!$hasfriends && $hasgroups){
    //if no friends but groups
    $guids_in = implode(',', array_unique(array_filter($group_guids)));
    
    //display created content and replies and comments
    $optionsg['wheres'] = array("( oe.container_guid IN({$guids_in})
     OR te.container_guid IN({$guids_in}) ) AND rv.id > {$latestId}");
    $optionsg['pagination'] = true;
    $activity = newsfeed_list_river($optionsg);
}else{
    //if friends and groups :3
    //turn off friend connections
    //remove friend connections from action types
    $actionTypes = array('comment', 'create', 'join', 'update', 'friend', 'reply');
    //load user's preference
    $filteredItems = array($user->colleagueNotif);
    //filter out preference
    $optionsfg['action_types'] = array_diff( $actionTypes, $filteredItems);

    $guids_in = implode(',', array_unique(array_filter($group_guids)));
    
    //Groups + Friends activity query
    //This query grabs new created content and comments and replies in the groups the user is a member of *** te.container_guid grabs comments and replies
    $optionsfg['wheres'] = array(
"( ( oe.container_guid IN({$guids_in})
     OR te.container_guid IN({$guids_in}) )
    OR rv.subject_guid IN (SELECT guid_two FROM {$db_prefix}entity_relationships WHERE guid_one=$user->guid AND relationship='friend') ) AND rv.id > {$latestId}
    ");
    $optionsfg['pagination'] = true;
    $activity = newsfeed_list_river($optionsfg);
}

//echo out the yolo code

echo $activity;