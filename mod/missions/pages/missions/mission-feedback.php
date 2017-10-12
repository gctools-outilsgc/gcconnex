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

if (!check_if_opted_in(elgg_get_logged_in_user_entity())) {
	forward(elgg_get_site_url() . 'missions/main');
}

$current_uri = $_SERVER['REQUEST_URI'];
$exploded_uri = explode('/', $current_uri);
$mission = get_entity(array_pop($exploded_uri));

$title = elgg_echo('missions:submit_feedback');

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions')), $mission->getURL());
elgg_push_breadcrumb($title);

$title .= ' (' . elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions')) . ')';

$content = elgg_view_title($title);

$content .= elgg_view('page/elements/mission-tabs');

$content .= elgg_echo('missions:feedback_explanation_one') . '<br>';
$content .= elgg_echo('missions:feedback_explanation_two') . '<br>';
$content .= elgg_echo('missions:feedback_explanation_three') . '<br><br>';

 // If the user is the mission manager then feedback forms will be generated for each participant.
if (elgg_get_logged_in_user_guid() == $mission->owner_guid || elgg_get_logged_in_user_guid() == $mission->account) {
	$no_feedback_necessary = true;
	$relationships = get_entity_relationships($mission->guid);
	foreach ($relationships as $relation) {
		if ($relation->relationship == 'mission_accepted') {
			$feedback_search = elgg_get_entities_from_metadata(array(
					'type' => 'object',
					'subtype' => 'mission-feedback',
					'owner_guid' => elgg_get_logged_in_user_guid(),
					'metadata_name_value_pairs' => array(
							array('name' => 'recipient', 'value' => $relation->guid_two),
							array('name' => 'mission', 'value' => $mission->guid),
							array('name' => 'message', 'value' => 'sent')
					)
			));
			$feedback = $feedback_search[0];

			if (!$feedback) {
				$content .= elgg_view_form('missions/feedback-form', array(
						'class' => 'horizontal-form'
				), array(
						'entity' => $mission,
						'feedback_target' => get_user($relation->guid_two),
						'feedback_count' => $count
				));
				$no_feedback_necessary = false;
			}
		}
	}
	if ($no_feedback_necessary) {
		system_message(elgg_echo('missions:all_feedback_finished', array($mission->job_title)));
		forward(elgg_get_site_url() . 'missions/main');
	}
}
// If the user is a participant then a singled feedback form for the manager will be generated.
elseif (check_entity_relationship($mission->guid, 'mission_accepted', elgg_get_logged_in_user_guid())) {
	$feedback_search = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => 'mission-feedback',
			'owner_guid' => elgg_get_logged_in_user_guid(),
			'metadata_name_value_pairs' => array(
				array('name' => 'recipient', 'value' => $mission->account),
				array('name' => 'mission', 'value' => $mission->guid),
				array('name' => 'message', 'value' => 'sent')
			)
	));
	$feedback = $feedback_search[0];

	if (!$feedback) {
		$content .= elgg_view_form('missions/feedback-form', array(
				'class' => 'horizontal-form'
		 ), array(
				'entity' => $mission,
				'feedback_target' => get_user($mission->account)
		 ));
	} else {
		system_message(elgg_echo('missions:all_feedback_finished', array($mission->job_title)));
		forward(elgg_get_site_url() . 'missions/main');
	}
 }
 // If the user is unrelated to the mission then they will be sent away.
 else {
	forward(REFERER);
 }

 echo elgg_view_page($title, $content);
