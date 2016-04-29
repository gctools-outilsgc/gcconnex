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

$applicants = get_entity_relationships($mission->guid);

// Sidebar content which displays the candidates who are going to work on this mission.
$applicants_none_accepted = true;
$applicants_none_tentative = true;

$accepted = '<h3>' . elgg_echo('missions:participants') . ':</h3>';
$tentative = '<h3>' . elgg_echo('missions:applicants') . ':</h3>';
$width_class_first = 'col-sm-5';
$width_class_second = $width_class_first;

foreach ($applicants as $applicant) {
	// Candidates which have been accepted into the mission.
	if ($applicant->relationship == 'mission_accepted') {
		$accepted .= '<div class="col-sm-9" style="display:inline-block;" name="mission-accepted-applicant-' . $applicant->guid_two . '">' . elgg_view_entity(get_user($applicant->guid_two)) . '</div>';

		// Removal button for the candidate.
		$remove_button = elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'action/missions/remove-applicant?aid=' . $applicant->guid_two . '&mid=' . $mission->guid,
				'text' => elgg_echo('missions:remove'),
				'is_action' => true,
				'class' => 'elgg-button btn btn-danger',
				'style' => 'vertical-align:top;',
				'id' => 'fill-mission-applicant-' . $applicant->guid . '-remove-button'
		));
		if($mission->state == 'posted' && elgg_get_logged_in_user_guid() == $mission->owner_guid) {
			$accepted .= '<div class="col-sm-3">' . $remove_button . '</div>';
		}
		$applicants_none_accepted = false;
	}

	// Candidates which have been sent an invitation to the mission.
	if ($applicant->relationship == 'mission_applied'/* || $applicant->relationship == 'mission_tentative'*/) {
		$tentative .= '<div class="col-sm-9" style="display:inline-block;" name="mission-tentative-applicant-' . $applicant->guid_two . '">' . elgg_view_entity(get_user($applicant->guid_two)) . '</div>';

		if(elgg_get_logged_in_user_guid() == $mission->owner_guid) {
			$offer_button = elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'action/missions/mission-offer?aid=' . $applicant->guid_two . '&mid=' . $mission->guid,
					'text' => elgg_echo('missions:offer'),
					'is_action' => true,
					'class' => 'elgg-button btn btn-success',
					'style' => 'min-width:60px;display:block;',
					'id' => 'fill-mission-applicant-' . $applicant->guid . '-offer-button'
			));
			
			// Removal button for the candidate.
			$remove_button = elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'action/missions/remove-applicant?aid=' . $applicant->guid_two . '&mid=' . $mission->guid,
					'text' => elgg_echo('missions:remove'),
					'is_action' => true,
					'class' => 'elgg-button btn btn-danger',
					'style' => 'min-width:60px;display:block;',
					'id' => 'fill-mission-applicant-' . $applicant->guid . '-remove-button'
			));
			if($mission->state == 'posted') {
				$tentative .= '<div class="col-sm-3">' . $offer_button . $remove_button . '</div>';
			}
		}
		
		$applicants_none_tentative = false;
	}
}
// Display something if there are no applicants.
if ($applicants_none_accepted) {
	$accepted .= '<span name="no-accepted-candidate">' . elgg_echo('missions:nobody') . '</span>';
}
if ($applicants_none_tentative) {
	$tentative .= '<span name="no-tentative-candidate">' . elgg_echo('missions:nobody') . '</span>';
}

echo '<div>';
echo '<div class="' . $width_class_first . '" style="display:inline-block;margin:8px;">' . $accepted . '</div>';
echo '<div class="' . $width_class_second . '" style="display:inline-block;margin:8px;">' . $tentative . '</div>';
echo '</div>';