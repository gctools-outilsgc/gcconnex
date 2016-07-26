<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This element creates a formatted list of missions that the user posted that they can invite the candidate to.
 */
 
 // Target candidates guid.
$user_guid = $vars['candidate_guid']; 

$entity_list = elgg_get_entities_from_relationship(array(
		'relationship' => 'mission_posted',
		'relationship_guid' => elgg_get_logged_in_user_guid()
));

$count = 0;
foreach($entity_list as $entity) {
	$candidates = elgg_get_entities_from_relationship(array(
			'relationship' => 'mission_accepted',
			'relationship_guid' => $entity->guid
	));
	$number_of_candidates = count($candidates);
	
	$not_invited_already = true;
	foreach($candidates as $candidate) {
		if($candidate->guid == $user_guid) {
			$not_invited_already = false;
		}
	}

	// Does not display missions which have filled all the available spots.
	if($number_of_candidates < $entity->number && $not_invited_already) {
		echo '<div class="col-sm-12">';
		echo '<div class="col-sm-5">' . elgg_view('output/url', array(
				'href' => $entity->getURL(),
				'text' => elgg_get_excerpt($entity->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions')),
				'class' => 'mission-emphasis mission-link-color',
				'id' => 'missions-view-link-' . $entity->guid
		)) . '<br>';
		echo $number_of_candidates . '/' . $entity->number . elgg_echo('missions:spots_filled') . '</div>';

		echo '<div class="col-sm-3">' . elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'action/missions/invite-user?aid=' . $user_guid . '&mid=' . $entity->guid,
				'text' => elgg_echo('missions:select'),
				'is_action' => true,
				'class' => 'elgg-button btn btn-default',
				'id' => 'mission-invitation-link-' . $entity->guid
		)) . '</div>';
		echo '</div>';
		
		$count++;
	}
}