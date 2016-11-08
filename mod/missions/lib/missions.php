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
	
	if(!$full_view) {
		// Handles the case where a read more button is needed.
		$button_zero = '<div id="read-more-button-mission-' . $mission->guid . '" name="read-more-button" style="display:inline-block;">' . elgg_view('output/url', array(
				'href' => $mission->getURL(),
				'text' => elgg_echo('missions:view'),
				'class' => 'elgg-button btn btn-default',
 				'style' => 'margin:2px;'
		)) . '</div>';	
		
		// Handles the case where an edit button is needed.
		// This overwrites the read more button.
        //Nick - letting site admins have access to edit/ deactivate missions
		if(($mission->owner_guid == elgg_get_logged_in_user_guid() || $mission->account == elgg_get_logged_in_user_guid() || elgg_is_admin_logged_in()) 
				&& $mission->state != 'completed' && $mission->state != 'cancelled') {
			$button_one = '<div id="edit-button-mission-' . $mission->guid . '" name="edit-button" style="display:inline-block;">' . elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/mission-edit/' . $mission->guid,
					'text' => elgg_echo('missions:edit'),
					'class' => 'elgg-button btn btn-primary',
 					'style' => 'margin:2px;'
			)) . '</div>';
		}
	}
	
	//if($mission->state == 'completed' || $mission->state == 'cancelled' || $mission->owner_guid != elgg_get_logged_in_user_guid()) {
		// Creates the share button which is always present.
		$button_two = '<div id="share-button-mission-' . $mission->guid . '" name="share-button" style="display:inline-block;">' . elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'missions/message-share/' . $mission->guid,
				'text' => elgg_echo('missions:share'),
				'class' => 'elgg-button btn btn-default',
 				'style' => 'margin:2px;'
		)) . '</div>';
	//}
	
	// Logic to handle the third button.
	if($mission->state != 'completed' && $mission->state != 'cancelled') {
		if ($mission->owner_guid == elgg_get_logged_in_user_guid() || $mission->account == elgg_get_logged_in_user_guid()) {
			$candidate_total = count(elgg_get_entities_from_relationship(array(
					'relationship' => 'mission_accepted',
					'relationship_guid' => $mission->guid
			)));
			
			$button_three ='<div id="invite-button-mission-' . $mission->guid . '" name="invite-button" style="display:inline-block;">' .  elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/mission-candidate-search/' . $mission->guid,
					'text' => elgg_echo('missions:find'),
					'class' => 'elgg-button btn btn-success',
 					'style' => 'margin:2px;'
			)) . '</div>';
			
			// Handles the case where a complete button is needed.
			if(!$full_view && $candidate_total == $mission->number) {
				$button_three = '<div id="complete-button-mission-' . $mission->guid . '" name="complete-button" style="display:inline-block;">' . elgg_view('output/url', array(
						'href' => elgg_get_site_url() . 'action/missions/complete-mission?mission_guid=' . $mission->guid,
						'text' => elgg_echo('missions:complete'),
		            	'is_action' => true,
						'class' => 'elgg-button btn btn-success',
						'confirm' => elgg_echo('missions:confirm:complete_mission'),
 						'style' => 'margin:2px;'
				)) . '</div>';
			}
		}
		else {
			$relationship_count = elgg_get_entities_from_relationship(array(
					'relationship' => 'mission_accepted',
					'relationship_guid' => $mission->guid,
					'count' => true
			));
			
			if($relationship_count < $mission->number) {
				$user = elgg_get_logged_in_user_entity();
				$mmdep = trim( explode('/', $mission->department_path_english)[0] );
				if ( !$mission->openess || stripos( $user->department, $mmdep ) !== false )
					$button_three = '<div id="apply-button-mission-' . $mission->guid . '" name="apply-button" style="display:inline-block;">' . $apply_button = elgg_view('output/url', array(
			 				'href' => elgg_get_site_url() . 'missions/mission-application/' . $mission->guid,
			 				'text' => elgg_echo('missions:apply'),
			 				'class' => 'elgg-button btn btn-primary',
		 					'style' => 'margin:2px;'
			 		)) . '</div>';
			}
			
			if(check_entity_relationship($mission->guid, 'mission_tentative', elgg_get_logged_in_user_guid())) {
				$button_three = '<div id="accept-button-mission-' . $mission->guid . '" name="accept-button" style="display:inline-block;">' . elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'action/missions/accept-invite?applicant=' . elgg_get_logged_in_user_guid() . '&mission=' . $mission->guid,
					'text' => elgg_echo('missions:accept'),
					'is_action' => true,
					'class' => 'elgg-button btn btn-success',
 					'style' => 'margin:2px;'
				)) . '</div>';
				$button_four = '<div id="decline-button-mission-' . $mission->guid . '" name="decline-button" style="display:inline-block;">' . elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/reason-to-decline/' . $mission->guid,
					'text' => elgg_echo('missions:decline'),
					'class' => 'elgg-button btn btn-danger',
 					'style' => 'margin:2px;'
				)) . '</div>';
				$button_two = null;
			}
			
			if(check_entity_relationship($mission->guid, 'mission_offered', elgg_get_logged_in_user_guid())) {
				$button_three = '<div id="final-accept-button-mission-' . $mission->guid . '" name="final-accept-button" style="display:inline-block;">' . mm_finalize_button($mission, elgg_get_logged_in_user_entity()) . '</div>';
				$button_four = '<div id="decline-button-mission-' . $mission->guid . '" name="decline-button" style="display:inline-block;">' . elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/reason-to-decline/' . $mission->guid,
					'text' => elgg_echo('missions:decline'),
					'class' => 'elgg-button btn btn-danger',
 					'style' => 'margin:2px;'
				)) . '</div>';
				$button_two = null;
			}
			
			if(check_entity_relationship($mission->guid, 'mission_accepted', elgg_get_logged_in_user_guid()) ||
					check_entity_relationship($mission->guid, 'mission_applied', elgg_get_logged_in_user_guid())) {
				$button_three = '<div id="withdraw-button-mission-' . $mission->guid . '" name="withdraw-button" style="display:inline-block;">' . elgg_view('output/url', array(
						'href' => elgg_get_site_url() . 'missions/reason-to-decline/' . $mission->guid,
						'text' => elgg_echo('missions:withdraw'),
						'class' => 'elgg-button btn btn-danger',
 						'style' => 'margin:2px;'
				)) . '</div>';
			}
		}
	}
	else {
		if(check_if_opted_in(elgg_get_logged_in_user_entity())) {
			$button_three = '<div id="duplicate-button-mission-' . $mission->guid . '" name="duplicate-button" style="display:inline-block;">' . elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'action/missions/duplicate-mission?mid=' . $mission->guid,
					'text' => elgg_echo('missions:duplicate'),
					'is_action' => true,
					'class' => 'elgg-button btn btn-success',
	 				'style' => 'margin:2px;'
			)) . '</div>';
		}

        //Nick - Adding the option for admins to delete and edit archived missions
        if(elgg_is_admin_logged_in()){
            $returner['edit_button'] = '<div id="edit-button-mission-' . $mission->guid . '" name="edit-button" style="display:inline-block;">' . elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/mission-edit/' . $mission->guid,
					'text' => elgg_echo('missions:edit'),
					'class' => 'elgg-button btn btn-primary',
 					'style' => 'margin:2px;'
			)) . '</div>';

            $button_four = '<div id="delete-button-mission-' . $mission->guid . '" name="delete-button" style="display:inline-block;">' . elgg_view('output/url', array(
                        'href' => elgg_get_site_url() . 'action/missions/delete-mission?mission_guid=' . $mission->guid,
                        'text' => elgg_echo('missions:delete'),
                        'is_action' => true,
                        'class' => 'elgg-button btn btn-danger',
                        'style' => 'margin:2px;'
                )) . '</div>';
        }

	}
	
	$returner['button_zero'] = $button_zero;
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
 	if (($mission->owner_guid == elgg_get_logged_in_user_guid() || $mission->account == elgg_get_logged_in_user_guid()) 
 			&& ($mission->state == 'completed' || $mission->state == 'cancelled') 
 			&& elgg_get_plugin_setting('mission_developer_tools_on', 'missions') == 'YES') {
 		$returner['reopen_button'] = '<div id="reopen-button-mission-' . $mission->guid . '" name="reopen-button" style="display:inline-block;">' . elgg_view('output/url', array(
 				'href' => elgg_get_site_url() . 'action/missions/reopen-mission?mission_guid=' . $mission->guid,
 				'text' => elgg_echo('missions:reopen'),
 				'is_action' => true,
 				'class' => 'elgg-button btn btn-default',
 				'style' => 'margin:2px;'
 		)) . '</div>';
 	}
 	
 	// Button to advance the mission state to cancelled from posted.
 	if (($mission->owner_guid == elgg_get_logged_in_user_guid() || $mission->account == elgg_get_logged_in_user_guid() ||elgg_is_admin_logged_in()) 
 			&& $mission->state != 'cancelled' && $mission->state != 'completed') {
 		$candidate_total = count(elgg_get_entities_from_relationship(array(
 				'relationship' => 'mission_accepted',
 				'relationship_guid' => $mission->guid
 		)));
 		
 		$disabled = true;
 		if($candidate_total > 0) {
 			$disabled = false;
 		}
 		
 		$returner['complete_button'] = '<div id="complete-button-mission-' . $mission->guid . '" name="complete-button" style="display:inline-block;">' . elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'action/missions/complete-mission?mission_guid=' . $mission->guid,
				'text' => elgg_echo('missions:complete'),
		        'is_action' => true,
				'class' => 'elgg-button btn btn-success',
 				'disabled' => $disabled,
 				'confirm' => elgg_echo('missions:confirm:complete_mission'),
 				'style' => 'margin:2px;'
		)) . '</div>';
 		
 		$returner['cancel_button'] = '<div id="cancel-button-mission-' . $mission->guid . '" name="cancel-button" style="display:inline-block;">' . elgg_view('output/url', array(
 				'href' => elgg_get_site_url() . 'action/missions/cancel-mission?mission_guid=' . $mission->guid,
 				'text' => elgg_echo('missions:deactivate'),
 				'is_action' => true,
 				'class' => 'elgg-button btn btn-danger',
 				'confirm' => elgg_echo('missions:confirm:cancel_mission'),
 				'style' => 'margin:2px;'
 		)) . '</div>';
        
        
        $returner['edit_button'] = '<div id="edit-button-mission-' . $mission->guid . '" name="edit-button" style="display:inline-block;">' . elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/mission-edit/' . $mission->guid,
					'text' => elgg_echo('missions:edit'),
					'class' => 'elgg-button btn btn-primary',
 					'style' => 'margin:2px;'
			)) . '</div>';
 	}
 	
 	if(($mission->owner_guid == elgg_get_logged_in_user_guid() || $mission->account == elgg_get_logged_in_user_guid()) 
 			&& elgg_get_plugin_setting('mission_developer_tools_on', 'missions') == 'YES') {
 		$returner['delete_button'] = '<div id="delete-button-mission-' . $mission->guid . '" name="delete-button" style="display:inline-block;">' . elgg_view('output/url', array(
 				'href' => elgg_get_site_url() . 'action/missions/delete-mission?mission_guid=' . $mission->guid,
 				'text' => elgg_echo('missions:delete'),
 				'is_action' => true,
 				'class' => 'elgg-button btn btn-danger',
 				'style' => 'margin:2px;'
 		)) . '</div>';
 	}
     //Nick - adding the ability for site admins to delete missions from the edit page
     //They don't want deleting to be an option for users for the sake of analytics
     //Only admins can delete missions if need be (ex inapropriate content)
     if(elgg_is_admin_logged_in()){
         $returner['delete_button'] = '<div id="delete-button-mission-' . $mission->guid . '" name="delete-button" style="display:inline-block;">' . elgg_view('output/url', array(
                     'href' => elgg_get_site_url() . 'action/missions/delete-mission?mission_guid=' . $mission->guid,
                     'text' => elgg_echo('missions:delete'),
                     'is_action' => true,
                     'class' => 'elgg-button btn btn-danger',
                     'style' => 'margin:2px;'
             )) . '</div>';
     }
 	
 	return $returner;
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

/*
 * Returns an associative array of 'echo_key' => elgg_echo('echo_key').
 */
function mm_echo_explode_setting_string($string, $language_override = '') {
	$raw_array = explode(',', $string);
	
	$echoed_array = array();
	for($i=0;$i<count($raw_array);$i++) {
		$echoed_array[$raw_array[$i]] = elgg_echo($raw_array[$i], array(), $language_override);
	}
	
	return $echoed_array;
}

/*
 * Notify user function which uses messages_send() to send on site notifications and mail() to send e-mail.
 * This is here because notify_user() is currently not working.
 */
function mm_notify_user($recipient, $sender, $subject, $body) {
	//notify_user($recipient, $sender, $subject, $body, array(), 'email');
	
	$recipient_entity = get_entity($recipient);
	$sender_entity = get_entity($sender);

	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$headers .= 'From: ' . $sender_entity->email . "\r\n";
	mail($recipient_entity->email, $subject, $body, $headers);
	
	if(get_subtype_from_id($recipient_entity->subtype) == 'mission') {
		if($recipient_entity->account) {
			messages_send($subject, $body, $recipient_entity->account, $sender, 0, false);
		}
		else {
			$recipient_set = get_user_by_email($recipient_entity->email);
			foreach($recipient_set as $recipient_temp) {
	    		messages_send($subject, $body, $recipient_temp->guid, $sender, 0, false);
			}
		}
	}
	else if(get_subtype_from_id($sender_entity->subtype) == 'mission') {
		if($sender_entity->account) {
			messages_send($subject, $body, $recipient, $sender_entity->account, 0, false);
		}
		else {
			$sender_set = get_user_by_email($sender_entity->email);
			$sender_latest = array_pop($sender_set)->guid;
	    	messages_send($subject, $body, $recipient, $sender_latest, 0, false);
		}
	}
	else {
		messages_send($subject, $body, $recipient, $sender, 0, false);
	}
}

/*
 * Compare two entities by their time_updated values.
 */
function mm_cmp_by_updated($a, $b)  {
	if($a->time_updated == $b->time_updated) {
		return 0;
	}
	return ($a->time_updated > $b->time_updated) ? -1 : 1;
}

/*
 * Returns a list of the manager's missions which still have room to accept candidates.
 */
function mm_get_invitable_missions($user_guid) {
	$returner = array();
	
	$entity_list = elgg_get_entities_from_relationship(array(
			'relationship' => 'mission_posted',
			'relationship_guid' => elgg_get_logged_in_user_guid()
	));

	$count = 0;
	foreach($entity_list as $entity) {
		$invited_already = false;
		if(check_entity_relationship($entity->guid, 'mission_accepted', $user_guid) ||
				check_entity_relationship($entity->guid, 'mission_applied', $user_guid) ||
				check_entity_relationship($entity->guid, 'mission_tentative', $user_guid) ||
				check_entity_relationship($entity->guid, 'mission_offered', $user_guid)) {
			$invited_already = true;
		}
		
		// Does not display missions which have filled all the available spots.
		if($number_of_candidates < $entity->number && !$invited_already) {
			$returner[$entity->guid] = elgg_get_excerpt($entity->job_title, 30);
			$count++;
		}
	}
	
	return $returner;
}

/*
 * Returns an offer button or a disabled button if the mission is full.
 */
function mm_offer_button($mission, $applicant) {
	$relationship_count = elgg_get_entities_from_relationship(array(
			'relationship' => 'mission_accepted',
			'relationship_guid' => $mission->guid,
			'count' => true
	));
	$relationship_count += elgg_get_entities_from_relationship(array(
			'relationship' => 'mission_offered',
			'relationship_guid' => $mission->guid,
			'count' => true
	));
	
	if(check_entity_relationship($mission->guid, 'mission_offered', $applicant->guid)) {
		return elgg_view('output/url', array(
				'href' => '',
				'text' => elgg_echo('missions:offered'),
				'class' => 'elgg-button btn btn-default',
				'style' => 'margin:2px;width:120px;',
				'disabled' => true
		));
	}
	else {
		if($relationship_count >= $mission->number) {
			// Disabled button for when the mission is full.
			return elgg_view('output/url', array(
					'href' => '',
					'text' => elgg_echo('missions:mission_full'),
					'class' => 'elgg-button btn btn-default',
					'style' => 'margin:2px;width:120px;',
					'disabled' => true
			));
		}
		else {
			// Button which turns the applicant into a participant.
			return elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'action/missions/mission-offer?aid=' . $applicant->guid . '&mid=' . $mission->guid,
					'text' => elgg_echo('missions:offer'),
					'is_action' => true,
					'class' => 'elgg-button btn btn-success',
					'style' => 'margin:2px;width:120px;'
			));
		}
	}
}

/*
 * Returns an accept button to a user who has received an offer if the mission is not full.
 */
function mm_finalize_button($mission, $applicant) {
	$relationship_count = elgg_get_entities_from_relationship(array(
			'relationship' => 'mission_accepted',
			'relationship_guid' => $mission->guid,
			'count' => true
	));
	
	if($relationship_count >= $mission->number) {
		// Disabled button for when the mission is full.
		return elgg_view('output/url', array(
				'href' => '',
				'text' => elgg_echo('missions:mission_full'),
				'class' => 'elgg-button btn btn-default',
				'style' => 'margin:2px;',
				'disabled' => true
		));
	}
	else {
		// Button which turns the applicant into a participant.
		return elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'action/missions/finalize-offer?aid=' . $applicant->guid . '&mid=' . $mission->guid,
				'text' => elgg_echo('missions:accept'),
				'is_action' => true,
				'class' => 'elgg-button btn btn-success',
				'style' => 'margin:2px;'
		));
	}
}

/*
 * Function which gets a translation key given the translated value whether it's in english or french.
 */
function mm_get_translation_key_from_setting_string($input, $setting_string) {
	$english_array = mm_echo_explode_setting_string($setting_string, 'en');
	foreach($english_array as $key => $value) {
		$english_array[$key] = strtolower($value);
	}
	$english_key = array_search(strtolower($input), $english_array);
	
	$french_array = mm_echo_explode_setting_string($setting_string, 'fr');
	foreach($french_array as $key => $value) {
		$french_array[$key] = strtolower($value);
	}
	$french_key = array_search(strtolower($input), $french_array);
	
	if(strcmp($french_key, $english_key) === 0) {
		if($english_key == '') {
			return false;
		}
		else {
			return $english_key;
		}
	}
	
	if($english_key) {
		return $english_key;
	}
	
	if($french_key) {
		return $french_key;
	}
}

/*
 * Function which sorts a set of missions by a given value in ascending or descending order.
 */
function mm_sort_mission_decider($sort, $order, $entity_set, $opp_type = '') {
	$backup_array = $entity_set;
	
	if($sort == '' || $order == '' || $entity_set == '') {
		return $backup_array;
	}
    
   if ( $opp_type != '' )				// apply filtering if some types are passed for filtering
	    foreach($entity_set as $type){
	        //$type_array[] = $type->job_type;
	        if(in_array($type->job_type,$opp_type)){		
	            $entity_set2[] = $type;   
	        }
	    }
	else 								// if nothing is selected for filtering, do not filter
		$entity_set2 = $entity_set;
	
    //$entity_set = array_intersect($type);
	$comparison = '';
	switch($sort) {
		case 'missions:date_posted':
			$comparison = 'mm_cmp_mission_by_posted_date';
			break;
		case 'missions:date_closed':
			$comparison = 'mm_cmp_mission_by_closed_date';
			break;
		case 'missions:deadline':
			$comparison = 'mm_cmp_mission_by_deadline';
			break;
		case 'missions:opportunity_type':
			$comparison = 'mm_cmp_mission_by_type';
			break;
	}
	
	$result = usort($entity_set2, $comparison);
	if(!$result) {
		return $backup_array;
	}
	else {
		if($order == 'missions:ascending') {
			return array_reverse($entity_set2);
		}
		return $entity_set2;
	}
}

/*
 * Compares missions by job type.
 */
function mm_cmp_mission_by_type($a, $b) {
	if(elgg_echo($a->job_type) == elgg_echo($b->job_type)) {
		return 0;
	}
	return (elgg_echo($a->job_type) < elgg_echo($b->job_type)) ? 1 : -1;
}

/*
 * Compares missions by their creation timestamp.
 */
function mm_cmp_mission_by_posted_date($a, $b) {
	if($a->time_created == $b->time_created) {
		return 0;
	}
	return ($a->time_created < $b->time_created) ? 1 : -1;
}
/*
 * Compares missions by the closing timestamp.
 */
function mm_cmp_mission_by_closed_date($a, $b) {
	if($a->time_closed == $b->time_closed) {
		return 0;
	}
	return ($a->time_closed < $b->time_closed) ? 1 : -1;
}

/*
 * Compares missions by their deadline date.
 */
function mm_cmp_mission_by_deadline($a, $b) {
	if($a->deadline == $b->deadline) {
		return 0;
	}
	return ($a->deadline < $b->deadline) ? 1 : -1;
}

/*
 * Check if the user is opted in to any of the opt-in options.
 */
function check_if_opted_in($current_user) {
    //Nick - adding additional checks for other opportunity types
	if($current_user->opt_in_missions == 'gcconnex_profile:opt:yes') {
		return true;
	}
	if($current_user->opt_in_swap == 'gcconnex_profile:opt:yes') {
		return true;
	}
	if($current_user->opt_in_mentored == 'gcconnex_profile:opt:yes') {
		return true;
	}
	if($current_user->opt_in_mentoring == 'gcconnex_profile:opt:yes') {
		return true;
	}
	if($current_user->opt_in_shadowed == 'gcconnex_profile:opt:yes') {
		return true;
	}
	if($current_user->opt_in_shadowing == 'gcconnex_profile:opt:yes') {
		return true;
	}
    if($current_user->opt_in_jobshare == 'gcconnex_profile:opt:yes') {
		return true;
	}
    if($current_user->opt_in_pcSeek == 'gcconnex_profile:opt:yes') {
		return true;
	}
    if($current_user->opt_in_pcCreate == 'gcconnex_profile:opt:yes') {
		return true;
	}
    if($current_user->opt_in_rotation== 'gcconnex_profile:opt:yes') {
		return true;
	}
    
    if($current_user->opt_in_ssSeek == 'gcconnex_profile:opt:yes') {
		return true;
	}
    if($current_user->opt_in_ssCreate == 'gcconnex_profile:opt:yes') {
		return true;
	}
    if($current_user->opt_in_assignSeek == 'gcconnex_profile:opt:yes') {
		return true;
	}
    if($current_user->opt_in_assignCreate == 'gcconnex_profile:opt:yes') {
		return true;
	}
    if($current_user->opt_in_deploySeek == 'gcconnex_profile:opt:yes') {
		return true;
	}
    if($current_user->opt_in_deployCreate == 'gcconnex_profile:opt:yes') {
		return true;
	}
	
	return false;
}