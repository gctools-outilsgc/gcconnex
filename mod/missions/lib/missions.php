<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Packs the language variables for a single language into a single string.
 */
function mm_pack_language($lwc, $lwe, $lop, $lang)
{
    $returner = '';
    
    $value = strtolower($lang);
    $returner .= $value;
    
    if (! empty($lwc) || $lwc == '-') {
        $returner .= $lwc;
    } else {
        $returner .= '-';
    }
    
    if (! empty($lwe) || $lwe == '-') {
        $returner .= $lwe;
    } else {
        $returner .= '-';
    }
    
    if (! empty($lop) || $lop == '-') {
        $returner .= $lop;
    } else {
        $returner .= '-';
    }
    
    return $returner;
}

/*
 * Unpacks a language string into an array of its component variable.
 */
function mm_unpack_language($data_string, $lang)
{
    $returner = array();
    
    $value = strtolower($lang);
    $index = stripos($data_string, $value) + strlen($value);
    
    $returner['lwc_' . $value] = substr($data_string, $index, 1);
    if ($returner['lwc_' . $value] == '-') {
        $returner['lwc_' . $value] = '';
    }
    $index ++;
    
    $returner['lwe_' . $value] = substr($data_string, $index, 1);
    if ($returner['lwe_' . $value] == '-') {
        $returner['lwe_' . $value] = '';
    }
    $index ++;
    
    $returner['lop_' . $value] = substr($data_string, $index, 1);
    if ($returner['lop_' . $value] == '-') {
        $returner['lop_' . $value] = '';
    }
    
    return $returner;
}

/*
 * Packs the time (hour and minute) into a single string.
 */
function mm_pack_time($hour, $min, $day)
{
    $returner = '';
    
    $value = strtolower($day);
    $returner .= $day;
    
    if (! empty($hour)) {
        if($min == '') {
            $min = '00';
        }
        $returner .= $hour . $min;
    }
    
    if (empty($hour) && (strpos($day, 'duration') !== false)) {
        $returner .= '0' . $min;
    }
    
    return $returner;
}

/*
 * Unpacks the time into an array of hour and minute.
 */
function mm_unpack_time($data_string, $day)
{
    $returner = array();
    
    $value = strtolower($day);
    $index = stripos($data_string, $value) + strlen($value);
    
    $dividing_time = 2;
    if (strpos($data_string, 'duration') !== false) {
        $dividing_time = 1;
    }
    
    if (! empty($data_string)) {
        $returner[$day . '_hour'] = substr($data_string, $index, $dividing_time);
        $returner[$day . '_min'] = substr($data_string, $index + $dividing_time, 2);
    }
    
    return $returner;
}

/*
 * Unpacks every unpackable item within a given entity.
 */
function mm_unpack_mission($entity)
{
    $returner = array();
    
    $returner = array_merge($returner, mm_unpack_language($entity->english, 'english'));
    $returner = array_merge($returner, mm_unpack_language($entity->french, 'french'));
    $returner = array_merge($returner, mm_unpack_time($entity->mon_start, 'mon_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->mon_duration, 'mon_duration'));
    $returner = array_merge($returner, mm_unpack_time($entity->tue_start, 'tue_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->tue_duration, 'tue_duration'));
    $returner = array_merge($returner, mm_unpack_time($entity->wed_start, 'wed_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->wed_duration, 'wed_duration'));
    $returner = array_merge($returner, mm_unpack_time($entity->thu_start, 'thu_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->thu_duration, 'thu_duration'));
    $returner = array_merge($returner, mm_unpack_time($entity->fri_start, 'fri_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->fri_duration, 'fri_duration'));
    $returner = array_merge($returner, mm_unpack_time($entity->sat_start, 'sat_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->sat_duration, 'sat_duration'));
    $returner = array_merge($returner, mm_unpack_time($entity->sun_start, 'sun_start'));
    $returner = array_merge($returner, mm_unpack_time($entity->sun_duration, 'sun_duration'));
    
    return $returner;
}

/*
 * Creates the base button set found in both greater and lesser views of the mission.
 */
function mm_create_button_set_base($mission, $full_view=false) {
	$returner = array();
	$button_one = null;
	$button_two = null;
	$button_three = null;
	$button_four = null;
	
	// Handles the case where a read more button is needed.
	if(!$full_view) {
		$button_one = elgg_view('output/url', array(
				'href' => $mission->getURL(),
				'text' => elgg_echo('missions:read_more'),
				'class' => 'elgg-button btn btn-default'
		));
		
		// Handles the case where an edit button is needed.
		// This overwrites the read more button.
		if($mission->owner_guid == elgg_get_logged_in_user_guid() && $mission->state != 'completed' && $mission->state != 'cancelled') {
			$button_one = elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/mission-edit/' . $mission->guid,
					'text' => elgg_echo('missions:edit'),
					'class' => 'elgg-button btn btn-primary'
			));
		}
	}
	
	// Creates the share button which is always present.
	$button_two = elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'missions/message-share/' . $mission->guid,
			'text' => elgg_echo('missions:share'),
			'class' => 'elgg-button btn btn-default'
	));
	
	// Logic to handle the third button.
	if($mission->state != 'completed' && $mission->state != 'cancelled') {
		if ($mission->owner_guid == elgg_get_logged_in_user_guid()) {
			$candidate_total = count(elgg_get_entities_from_relationship(array(
					'relationship' => 'mission_accepted',
					'relationship_guid' => $mission->guid
			)));
			
			$button_three = elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/mission-candidate-search/' . $mission->guid,
					'text' => elgg_echo('missions:invite'),
					'class' => 'elgg-button btn btn-default'
			));
			
			// Handles the case where a complete button is needed.
			if(!$full_view && $candidate_total == $mission->number) {
				$button_three = elgg_view('output/url', array(
						'href' => elgg_get_site_url() . 'action/missions/complete-mission?mission_guid=' . $mission->guid,
						'text' => elgg_echo('missions:complete'),
		            	'is_action' => true,
						'class' => 'elgg-button btn btn-success',
						'confirm' => true
				));
			}
		}
		else {
			$button_three = $apply_button = elgg_view('output/url', array(
	 				'href' => elgg_get_site_url() . 'missions/mission-application/' . $mission->guid,
	 				'text' => elgg_echo('missions:apply'),
	 				'class' => 'elgg-button btn btn-primary'
	 		));
			
			if(check_entity_relationship($mission->guid, 'mission_tentative', elgg_get_logged_in_user_guid())) {
				$button_three = elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'action/missions/accept-invite?applicant=' . elgg_get_logged_in_user_guid() . '&mission=' . $mission->guid,
					'text' => elgg_echo('missions:accept'),
					'is_action' => true,
					'class' => 'elgg-button btn btn-success'
				));
				$button_four = elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'action/missions/decline-invite?applicant=' . elgg_get_logged_in_user_guid() . '&mission=' . $mission->guid,
					'text' => elgg_echo('missions:decline'),
					'is_action' => true,
					'class' => 'elgg-button btn btn-danger'
				));
				$button_two = null;
			}
			
			if(check_entity_relationship($mission->guid, 'mission_accepted', elgg_get_logged_in_user_guid())) {
				$button_three = elgg_view('output/url', array(
						'href' => elgg_get_site_url() . 'action/missions/remove-applicant?aid=' . elgg_get_logged_in_user_guid() . '&mid=' . $mission->guid,
						'text' => elgg_echo('missions:withdraw'),
						'is_action' => true,
						'class' => 'elgg-button btn btn-danger'
				));
			}
		}
	}
	
	$returner['button_one'] = $button_one;
	$returner['button_two'] = $button_two;
	$returner['button_three'] = $button_three;
	$returner['button_four'] = $button_four;
	return $returner;
}

/*
 * Creates the full set of buttons found in the greater view of the mission.
 */
 function mm_create_button_set_full($mission) {
 	$returner = mm_create_button_set_base($mission, true);
 	
 	// Button to revert the state of a mission to posted.
 	if ($mission->owner_guid == elgg_get_logged_in_user_guid() && ($mission->state == 'completed' || $mission->state == 'cancelled') && elgg_get_plugin_setting('mission_developer_tools_on', 'missions') == 'YES') {
 		$returner['reopen_button'] = elgg_view('output/url', array(
 				'href' => elgg_get_site_url() . 'action/missions/reopen-mission?mission_guid=' . $mission->guid,
 				'text' => elgg_echo('missions:reopen'),
 				'is_action' => true,
 				'class' => 'elgg-button btn btn-default'
 		));
 	}
 	
 	// Button to advance the mission state to cancelled from posted.
 	if ($mission->owner_guid == elgg_get_logged_in_user_guid() && $mission->state != 'cancelled' && $mission->state != 'completed') {
 		$candidate_total = count(elgg_get_entities_from_relationship(array(
 				'relationship' => 'mission_accepted',
 				'relationship_guid' => $mission->guid
 		)));
 		
 		$disabled = true;
 		if($candidate_total > 0) {
 			$disabled = false;
 		}
 		
 		$returner['complete_button'] = elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'action/missions/complete-mission?mission_guid=' . $mission->guid,
				'text' => elgg_echo('missions:complete'),
		        'is_action' => true,
				'class' => 'elgg-button btn btn-success',
 				'disabled' => $disabled,
 				'confirm' => true
		));
 		
 		$returner['cancel_button'] = elgg_view('output/url', array(
 				'href' => elgg_get_site_url() . 'action/missions/cancel-mission?mission_guid=' . $mission->guid,
 				'text' => elgg_echo('missions:cancel'),
 				'is_action' => true,
 				'class' => 'elgg-button btn btn-danger',
 				'confirm' => true
 		));
 	}
 	
 	if($mission->owner_guid == elgg_get_logged_in_user_guid() && elgg_get_plugin_setting('mission_developer_tools_on', 'missions') == 'YES') {
 		$returner['delete_button'] = elgg_view('output/url', array(
 				'href' => elgg_get_site_url() . 'action/missions/close-from-display?mission_guid=' . $mission->guid,
 				'text' => elgg_echo('missions:delete'),
 				'is_action' => true,
 				'class' => 'elgg-button btn btn-danger'
 		));
 	}
 	
 	return $returner;
 }

/*
 * Returns two buttons which switch between mission and candidate searching.
 */
/*function mm_create_switch_buttons() {
    $returner = array();
    
    $active_mission_button = 'not_active';
    $active_candidate_button = 'not_active';
    if($_SESSION['mission_search_switch'] == 'mission' || $_SESSION['mission_search_switch'] == '') {
        $active_mission_button = 'active';
    }
    if($_SESSION['mission_search_switch'] == 'candidate') {
        $active_candidate_button = 'active';
    }
    
    $returner['mission_button'] = elgg_view('output/url', array(
        'href' => elgg_get_site_url() . 'action/missions/search-switch?switch=mission',
        'text' => elgg_echo('missions:mission'),
        'is_action' => true,
        'class' => 'elgg-button btn btn-default' . ' ' . $active_mission_button
    ));
    $returner['candidate_button'] = elgg_view('output/url', array(
        'href' => elgg_get_site_url() . 'action/missions/search-switch?switch=candidate',
        'text' => elgg_echo('missions:candidate'),
        'is_action' => true,
        'class' => 'elgg-button btn btn-default' . ' ' . $active_candidate_button
    ));
    
    return $returner;
}*/

/*
 * Sends a notification to a user containing an invitation to a mission.
 */
function mm_send_notification_invite($target, $mission) {
    // Link to a page which contains the invitation.
    $invitation_link = elgg_view('output/url', array(
        'href' => elgg_get_site_url() . 'missions/mission-invitation/' . $mission->guid,
        'text' => elgg_echo('missions:mission_invitation')
    ));
    //system_message(elgg_get_site_url() . 'missions/mission-invitation/' . $mission->guid . '!');
    
    $subject = get_user($mission->owner_guid)->name . elgg_echo('missions:invited_you', array(), $target->language) . $mission->title;
    $body = $invitation_link;
    $params = array(
    		'object' => $mission,
    		'action' => 'invite-user',
    		'summary' => $subject
    );
    $methods = array('email', 'site');
    $test_returned = notify_user($target->guid, $mission->owner_guid, $subject, $body, $params, $methods);
    //$test_returned_again = messages_send($subject, $body, $target_guid);
    //system_message($target->guid . ':' . $mission->owner_guid . ';' . $subject);
    //if($test_returned[$target->guid]['site']) {
    //	system_message('It worked!');
    //}
    
    // Create a tentative relationship between mission and user for identification purposes.
    if(!check_entity_relationship($mission->guid, 'mission_accepted', $target->guid)) {
        add_entity_relationship($mission->guid, 'mission_tentative', $target->guid);
    }
    
    return true;
}

/*
 * Removes potential url variables from a guid string.
 */
function mm_clean_url_segment($segment) {
	$clean_segment = $segment;
	if(strpos($segment, '?') === false) {
		
	}
	else {
		$cutoff = strpos($segment, '?');
		$clean_segment = substr($segment, 0, $cutoff);
	}
	
	return $clean_segment;
}