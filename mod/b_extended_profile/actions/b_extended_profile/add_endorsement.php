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

    if ($skill->endorsements == NULL) {
        $skill->endorsements = $user_guid;
    }
    else {
        $stack = $skill->endorsements;
        if (!(is_array($stack))) { $stack = array($stack); }

        $stack[] = $user_guid;
        $skill->endorsements = $stack;
    }
    //$skill->endorsements = NULL;
    $skill->save();
}