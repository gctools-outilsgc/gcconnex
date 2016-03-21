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

foreach($entity_list as $entity) {
	$count = count(elgg_get_entities_from_relationship(array(
			'relationship' => 'mission_accepted',
			'relationship_guid' => $entity->guid
	)));


	// Does not display missions which have filled all the available spots.
	if($count < $entity->number) {
		echo '<div>';
		echo '<div style="display:inline-block;">' . elgg_view('output/url', array(
				'href' => $entity->getURL(),
				'text' => $entity->job_title,
				'class' => 'mission-emphasis mission-link-color'
		)) . '</br>';
		echo $count . '/' . $entity->number . elgg_echo('missions:spots_filled') . '</div>';

		echo '<div style="display:inline-block;vertical-align:top;margin-top:4px;margin-left:16px;">' . elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'action/missions/invite-user?aid=' . $user_guid . '&mid=' . $entity->guid,
				'text' => elgg_echo('missions:select'),
				'is_action' => true,
				'class' => 'elgg-button btn btn-default'
		)) . '</div></br>';
		echo '</div>';
	}
}