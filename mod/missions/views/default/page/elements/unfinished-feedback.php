<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Displays mission names with unfinished feedback.
 */

$mission_list = $vars['entity_list'];
foreach($mission_list as $key => $mission) {
	if($mission->state != 'completed') {
		unset($mission_list[$key]);
	}
}

$feedback_required = '';
$count = 0;
foreach($mission_list as $mission) {
	$feedback_search = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => 'mission-feedback',
			'owner_guid' => elgg_get_logged_in_user_guid(),
			'metadata_name_value_pairs' => array(
					array('name' => 'mission', 'value' => $mission->guid),
					array('name' => 'message', 'value' => 'sent')
			)
	));
	
	$participants = get_entity_relationships($mission->guid);
	
	if(elgg_get_logged_in_user_guid() == $mission->owner_guid && count($feedback_search) != count($participants)) {
		$feedback_required .= elgg_view('output/url', array(
 				'href' => elgg_get_site_url() . 'missions/mission-feedback/' . $mission->guid,
 				'text' => $mission->job_title
 		)) . '</br>';
		$count++;
	}
	elseif(check_entity_relationship($mission->guid, 'mission_accepted', elgg_get_logged_in_user_guid()) && !count($feedback_search) && elgg_get_logged_in_user_guid() != $mission->owner_guid) {
		$feedback_required .= elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'missions/mission-feedback/' . $mission->guid,
				'text' => $mission->job_title
		)) . '</br>';
		$count++;
	}
}

if($count > 0) {
	echo '<h4>' . elgg_echo('missions:require_feedback') . ':</h4>';
	echo '<div>' . $feedback_required . '</div>';
}
?>