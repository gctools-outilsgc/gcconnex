<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Page which allows a user to annotate a mission with feedback.
 */
 gatekeeper();
 
 $current_uri = $_SERVER['REQUEST_URI'];
 $exploded_uri = explode('/', $current_uri);
 $mission = get_entity(array_pop($exploded_uri));
 
 $title = elgg_echo('missions:submit_feedback');
 
 elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
 elgg_push_breadcrumb($mission->job_title, $mission->getURL());
 elgg_push_breadcrumb($title);
 
 $title .= ' (' . $mission->job_title . ')';
 
 $content = elgg_view_title($title);
 
 $content .= elgg_echo('missions:feedback_explanation_one') . '</br>';
 $content .= elgg_echo('missions:feedback_explanation_two') . '</br></br>';
 
 // If the user is the mission manager then feedback forms will be generated for each participant.
 if(elgg_get_logged_in_user_guid() == $mission->owner_guid) {
 	$relationships = get_entity_relationships($mission->guid);
 	foreach($relationships as $relation) {
 		if($relation->relationship == 'mission_accepted') {
 			$feedback_search = elgg_get_entities_from_metadata(array(
 					'type' => 'object',
 					'subtype' => 'mission-feedback',
 					'owner_guid' => elgg_get_logged_in_user_guid(),
 					'metadata_name_value_pairs' => array(
 							array('name' => 'recipient', 'value' => $relation->guid_two),
 							array('name' => 'mission', 'value' => $mission->guid)
 					)
 			));
 			$feedback = $feedback_search[0];
 			
 			if(!$feedback) {
		 		$content .= elgg_view_form('missions/feedback-form', array(
		 				'class' => 'horizontal-form'
		 		), array(
				 		'entity' => $mission,
				 		'feedback_target' => get_user($relation->guid_two)
			 	));
 			}
 		}
 	}
 }
 // If the user is a participant then a singled feedback form for the manager will be generated.
 elseif(check_entity_relationship($mission->guid, 'mission_accepted', elgg_get_logged_in_user_guid())) {
 	$feedback_search = elgg_get_entities_from_metadata(array(
 			'type' => 'object',
 			'subtype' => 'mission-feedback',
 			'owner_guid' => elgg_get_logged_in_user_guid(),
 			'metadata_name_value_pairs' => array(
 					array('name' => 'recipient', 'value' => $mission->owner_guid),
 					array('name' => 'mission', 'value' => $mission->guid)
 			)
 	));
 	$feedback = $feedback_search[0];
 	
 	if(!$feedback) {
	 	$content .= elgg_view_form('missions/feedback-form', array(
		 		'class' => 'horizontal-form'
		 ), array(
		 		'entity' => $mission,
		 		'feedback_target' => get_user($mission->owner_guid)
		 ));
 	}
 }
 // If the user is unrelated to the mission then they will be sent away.
 else {
 	forward(REFERER);
 }
 
 echo elgg_view_page($title, $content);