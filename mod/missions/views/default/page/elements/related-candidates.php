<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Displays all the candidates which have relationships to the mission.
 */

$mission = $vars['entity'];

$applicant_relationships = get_entity_relationships($mission->guid);

// Sidebar content which displays the candidates who are going to work on this mission.
$applicants_none_accepted = true;
$applicants_none_tentative = true;

$accepted = '<h3>' . elgg_echo('missions:participants') . ':</h3>';
$tentative = '<h3>' . elgg_echo('missions:applicants') . ':</h3>';
$width_class_first = 'col-sm-12';
$width_class_second = $width_class_first;

$participant_count = 0;
$applicant_count = 0;

foreach ($applicant_relationships as $applicant_relation) {
	// Candidates which have been accepted into the mission.
	if ($applicant_relation->relationship == 'mission_accepted') {
		$accepted .= '<div class="col-sm-12" style="display:inline-block;" name="mission-participant" id="mission-participant-' . $applicant_relation->guid_two . '">' . elgg_view_entity(get_user($applicant_relation->guid_two)) . '</div>';

		if($mission->state == 'posted') {
			if(elgg_get_logged_in_user_guid() == $mission->owner_guid || elgg_get_logged_in_user_guid() == $mission->account) {
				// Removal button for the candidate.
				$accepted .= '<div class="col-sm-12">' . elgg_view('output/url', array(
						'href' => elgg_get_site_url() . 'action/missions/remove-applicant?aid=' . $applicant_relation->guid_two . '&mid=' . $mission->guid,
						'text' => elgg_echo('missions:remove'),
						'is_action' => true,
						'class' => 'elgg-button btn btn-danger',
						'style' => 'margin:4px;',
						'id' => 'fill-mission-applicant-' . $applicant_relation->guid_two . '-remove-button',
						'confirm' => elgg_echo('missions:placeholder_i')
				)) . '</div>';
			}
		}
		else {
			$accepted .= '<div class="col-sm-4">';
			
			if(elgg_get_logged_in_user_guid() == $mission->owner_guid || elgg_get_logged_in_user_guid() == $mission->account) {
				$owner = $mission->owner_guid;
				$target = $applicant_relation->guid_two;
			}
			else if(elgg_get_logged_in_user_guid() == $applicant_relation->guid_two) {
				$owner = $applicant_relation->guid_two;
				$target = $mission->owner_guid;
			}
			
			$feedback_search = elgg_get_entities_from_metadata(array(
					'type' => 'object',
					'subtype' => 'mission-feedback',
					'owner_guid' => $owner,
					'metadata_name_value_pairs' => array(
							array('name' => 'recipient', 'value' => $target),
							array('name' => 'mission', 'value' => $mission->guid),
 							array('name' => 'message', 'value' => 'sent')
					)
			));
			
			if(elgg_get_logged_in_user_guid() == $mission->owner_guid || elgg_get_logged_in_user_guid() == $mission->account 
					|| elgg_get_logged_in_user_guid() == $applicant_relation->guid_two) {
				if(count($feedback_search)) {
					if($feedback_search[0]->endorsement != 'on') {
						$accepted .= elgg_view('output/url', array(
								'href' => elgg_get_site_url() . 'action/missions/endorse-user?fid=' . $feedback_search[0]->guid,
								'text' => elgg_echo('missions:endorse'),
								'is_action' => true,
								'class' => 'elgg-button btn btn-success',
								'style' => 'margin:4px;',
								'id' => 'fill-mission-applicant-' . $applicant_relation->guid_two . '-endorse-button'
						));
					}
				}
				else {
					$accepted .= elgg_view('output/url', array(
							'href' => elgg_get_site_url() . 'missions/mission-feedback/' . $mission->guid,
							'text' => elgg_echo('missions:feedback'),
							'class' => 'elgg-button btn btn-success',
							'style' => 'margin:4px;',
							'id' => 'fill-mission-applicant-' . $applicant_relation->guid_two . '-submit-feedback-button'
					));
				}
			}
			
			$accepted .= '</div>';
		}
		
		$applicants_none_accepted = false;
		$participant_count++;
	}

	// Candidates which have been sent an invitation to the mission.
	if ($applicant_relation->relationship == 'mission_applied' || $applicant_relation->relationship == 'mission_offered') {
		if($mission->state == 'posted') {
			if(elgg_get_logged_in_user_guid() == $mission->owner_guid || elgg_get_logged_in_user_guid() == $mission->account 
					|| elgg_get_logged_in_user_guid() == $applicant_relation->guid_two) {
				$tentative .= '<div class="col-sm-12" style="display:inline-block;" name="mission-applicant" id="mission-applicant-' . $applicant_relation->guid_two . '">' . elgg_view_entity(get_user($applicant_relation->guid_two)) . '</div>';
			
				if(elgg_get_logged_in_user_guid() == $mission->owner_guid || elgg_get_logged_in_user_guid() == $mission->account) {
					$tentative .= '<div class="col-sm-12">';
					$tentative .= mm_offer_button($mission, get_user($applicant_relation->guid_two));
					
					// Removal button for the candidate.
					$tentative .= elgg_view('output/url', array(
							'href' => elgg_get_site_url() . 'action/missions/remove-applicant?aid=' . $applicant_relation->guid_two . '&mid=' . $mission->guid,
							'text' => elgg_echo('missions:remove'),
							'is_action' => true,
							'class' => 'elgg-button btn btn-danger',
							'style' => 'margin:4px;',
							'id' => 'fill-mission-applicant-' . $applicant_relation->guid_two . '-remove-button',
							'confirm' => elgg_echo('missions:placeholder_i2')
					));
					
					$tentative .= '</div>';
				}
				
				$applicants_none_tentative = false;
			}
			$applicant_count++;
		}
	}
}
// Display something if there are no applicants.
if($applicants_none_accepted) {
	$accepted .= '<div name="no-accepted-candidate" class="col-sm-12">' . elgg_echo('missions:nobody') . '</div>';
}
if($applicants_none_tentative && $applicant_count == 0) {
	$tentative .= '<div name="no-tentative-candidate" class="col-sm-12">' . elgg_echo('missions:nobody') . '</div>';
}
else {
	$s_or_not = '';
	if($applicant_count > 1) {
		$s_or_not = 's';
	}
	
	$tentative .= '<div name="applicant_count" class="col-sm-12">' . elgg_echo('missions:applicant_count', array($applicant_count, $s_or_not)) . '</div>';
}

$accepted .= $hidden_participant_count = elgg_view('input/hidden', array(
		'name' => 'hidden_participant_count',
		'value' => $participant_count
));
$tentative .= $hidden_applicant_count = elgg_view('input/hidden', array(
		'name' => 'hidden_applicant_count',
		'value' => $applicant_count
));

echo '<div>';
echo '<div class="' . $width_class_first . '" >' . $accepted . '</div>';
echo '<div class="' . $width_class_second . '" >' . $tentative . '</div>';
echo '</div>';