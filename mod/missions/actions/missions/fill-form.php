<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This action creates and saves a series of relationships which connect an applicant to the mission.
 * It sends a notification to each user being connected to the mission which allows them to accept or decline.
 */
elgg_make_sticky_form('fillfill');
$fill_form = elgg_get_sticky_values('fillfill');

$mid = $_SESSION['mid_act'];
unset($_SESSION['mid_act']);
$mission = get_entity($mid);

$number_of = $mission->number;

if ($err != '') {
    register_error($err);
    forward(REFERER);
} 
else {
    $applicant_array = array();
    
    // Retrieves a user for each input field. If the field is empty or invalid then the corresponding array entry will be null.
    for ($i = 0; $i < $number_of; $i ++) {
        if($fill_form['applicant_' . $i] != '') {
            $applicant = get_user_by_username($fill_form['applicant_' . $i]);
            if ($applicant->guid != '') {
            	// Candidate must be opted in to micro missions to receive an invitation.
                if($applicant->opt_in_missions == 'gcconnex_profile:opt:yes') {
                    mm_send_notification_invite($applicant, $mission);
                    // This works!
                    //elgg_send_email($applicant->email, $mission->email, "Email Test", "Test");
                }
                else {
                    $err .= $applicant->name . elgg_echo('missions:error:not_participating_in_missions');
                }
            }
            else {
                $err .= $fill_form['applicant_' . $i] . elgg_echo('missions:error:does_not exist') . "\n";
            }
        }
    }
    
    if ($err != '') {
        register_error($err);
    }
    forward($mission->getURL());
}