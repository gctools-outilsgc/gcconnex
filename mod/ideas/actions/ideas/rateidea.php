<?php
/**
* Idea rate action
*
* @package ideas
*/

gatekeeper();

// coming from the ajax data structure sent in js.php
$idea_guid = (int)get_input('idea');
$value = (int)get_input('value');

$user_guid = elgg_get_logged_in_user_guid();
$page_owner = (int)get_input('page_owner', elgg_get_page_owner_guid());

// user has already voted
if(elgg_annotation_exists($idea_guid, 'point', $user_guid)) {
    $vote = elgg_get_annotations(array(
        'guids' => $idea_guid,
        'annotation_names' => 'point',
        'annotation_owner_guids' => $user_guid,
        'limit' => 0
    ));

    // user is attempting to vote again -- should we delete the annotation to "unvote"?
    if($vote[0]->value == $value) {
        register_error(elgg_echo('ideas:idea:rate:error:voteagain'));
        $error = true;    
    } else {
        // user is changing her vote
        if(update_annotation($vote[0]->id,'point',$value,'integer',$user_guid,$vote[0]->access_id)) {
            // all good
            system_message(elgg_echo('ideas:idea:rate:changevote'));
        } else {
            // a problem with update
            register_error(elgg_echo('ideas:idea:rate:error:updateerror'));
            $error = true; 
        }
    }
    
} else {
    // new vote
    $annotation = new ElggObject($idea_guid);
    if(create_annotation($annotation->getGUID(), 'point', $value, 'integer', $user_guid, $annotation->getAccessID())) {
        system_message(elgg_echo('ideas:idea:rate:submitted'));
    } else {
        register_error(elgg_echo('ideas:idea:rate:error:value'));
        $error = true; 
    }
}

// for test purposes only
/*
elgg_delete_annotations(array(
    'annotation_names' => 'point'
));
*/

$sum = elgg_get_annotations(array(
    'guids' => $idea_guid,
    'annotation_names' => 'point',
    'annotation_calculation' => 'sum',
    'limit' => 0
));

$likes = elgg_get_annotations(array(
    'guids' => $idea_guid,
    'annotation_names' => array('point'),
    'annotation_values' => 1
));

$dislikes = elgg_get_annotations(array(
    'guids' => $idea_guid,
    'annotation_names' => array('point'),
    'annotation_values' => -1
));

echo json_encode(array('sum' => $sum, 'likes' => count($likes), 'dislikes' => count($dislikes), 'errorRate' => $error));

// echo json_encode(array('sum' => $sum, 'userVoteLeft' => $userVoteLeft, 'errorRate' => $error));