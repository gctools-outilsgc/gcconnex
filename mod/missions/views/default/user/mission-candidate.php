<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * User display within the context of the micro missions plugin.
 */
$user = $vars['user'];
$feedback_string = $_SESSION['candidate_search_feedback'][$user->guid];

// Creates a gray background if the user is not opted in to micro missions.
if($user->opt_in_missions == 'gcconnex_profile:opt:yes') {
	echo '<div>';
}
else {
	echo '<div style="background-color:#D3D3D3">';
}

// Displays search feedback from simple search.
if($feedback_string != '') {
    $feedback_array = explode(',', $feedback_string);
    
    echo '<h4>' . elgg_echo('missions:user_matched_by') . ':</h4>';
    foreach($feedback_array as $feedback) {
        if($feedback) {
            echo '<span class="tab">' . $feedback . '</span></br>';
        }
    }
}

$mission_guid = $_SESSION['mission_that_invites'];
$mission = get_entity($mission_guid);

// Displays invitation button if the user is opted in to micro missions.
if($user->opt_in_missions == 'gcconnex_profile:opt:yes' && $user->guid != $mission->owner_guid) {
    echo elgg_view('output/url', array(
        'href' => elgg_get_site_url() . 'action/missions/invite-user?aid=' . $user->guid . '&mid=' . $mission_guid,
        'text' => elgg_echo('missions:invite'),
		'is_action' => true,
        'class' => 'elgg-button btn btn-default'
    ));
}
elseif($user->guid == $mission->owner_guid) {
	echo '';
}
else {
	echo '<h4>' . elgg_echo('missions:not_participating_in_missions') . '</h4>';
}
echo '</div>';