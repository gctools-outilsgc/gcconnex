<?php
/*
 * Author: Bryden Arndt
 * Date: 01/09/2015
 * Purpose: Create the ajax view for editing the work experience entries.
 * Requires: gcconnex-profile.js in order to handle the add more and delete buttons which are triggered by js calls
 */

if (elgg_is_xhr()) {  //This is an Ajax call!
    //$user_guid = $_GET["user"];
    $user_guid = $_GET["guid"];
    $user = get_user($user_guid);

    // allow the user to edit the access settings for work experience entries
    echo '<label for="workAccess">' . elgg_echo('gcconnex_profile:experience:access') . '</label>';

    $access_id = $user->work_access;
    $params = array(
        'name' => "accesslevel['work']",
        'id' => "workAccess",
        'class' => "gcconnex-work-experience-access",
        'value' => $access_id
    );

    echo elgg_view('input/access', $params);

    //get the array of user work_experience entities
    $work_experience_guid = $user->work;

    echo '<div class="gcconnex-work-experience-all">';
    // handle $work_experience_guid differently depending on whether it's an array or not
    if (is_array($work_experience_guid)) {
        foreach ($work_experience_guid as $guid) { // display the input/work-experience view for each work experience entry
            if ( $guid != null ) {
                echo elgg_view('input/work-experience', array('guid' => $guid));
            }
        }
    }
    else {
        if ($work_experience_guid != null && !empty($work_experience_guid)) {
            echo elgg_view('input/work-experience', array('guid' => $work_experience_guid));
        }
    }


    echo '</div>';

    // create an "add more" button at the bottom of the work experience input fields so that the user can continue to add more work experience entries as needed
    echo '<br><button class="gcconnex-work-experience-add-another elgg-button elgg-button-action btn btn-primary" data-type="work-experience" onclick="addMore(this)">' . elgg_echo('gcconnex_profile:experience:add') . '</button>';
}

else {  // In case this view will be called via elgg_view()
    echo 'An error has occurred. Please ask the system administrator to grep: SDFLK3GLK43BB5557';
}

?>