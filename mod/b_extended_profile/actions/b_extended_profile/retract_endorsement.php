<?php
/*
 * Author: Bryden Arndt
 * Date: 01/11/2015
 * Purpose: Process an endorsement of a skill from one user to another
 */

if (elgg_is_xhr()) {  //This is an Ajax call!
    $user_guid = get_input('guid');
    $skill_guid = get_input('skill');
    $skill = get_entity($skill_guid);

    error_log('Made it here!');
    $endorsements = $skill->endorsements;
    if(!(is_array($endorsements))) {
        $endorsements = array($endorsements);
    }

    if(($key = array_search($user_guid, $endorsements)) !== false) {
        unset($endorsements[$key]);
    }
    $skill->endorsements = $endorsements;
    //$skill->endorsements = NULL;
    $skill->save();
}