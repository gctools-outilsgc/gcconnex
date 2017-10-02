<?php
/*
 * Author: National Research Council Canada
* Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
*
* License: Creative Commons Attribution 3.0 Unported License
* Copyright: Her Majesty the Queen in Right of Canada, 2015
*/

/*
 * Accepts the offer sent to a candidate.
 */
$applicant = get_user(get_input('aid'));
$mission = get_entity(get_input('mid'));

if($mission == '') {
	$err .= elgg_echo('missions:error:entity_does_not_exist');
}
else {
	// An offer needs to have been sent to the user.
	if(!check_entity_relationship($mission->guid, 'mission_offered', $applicant->guid)) {
		$err .= elgg_echo('missions:error:applicant_not_offered_this_mission', array($mission->job_title));
	}
	else {
		$relationship_count = elgg_get_entities_from_relationship(array(
				'relationship' => 'mission_accepted',
				'relationship_guid' => $mission->guid,
				'count' => true
		));

		// Does not allow more accepted candidates then the number defined in the mission metadata.
		if($relationship_count >= $mission->number) {
			$err .= elgg_echo('missions:error:mission_full');
		}
		else {
			// Changes the applicant into a participant.
			remove_entity_relationship($mission->guid, 'mission_offered', $applicant->guid);
			add_entity_relationship($mission->guid, 'mission_accepted', $applicant->guid);

			// Check to see if this mission is already marked in progress.
			$in_progress = (elgg_get_entities_from_metadata(array(
				  'count' => true,
					'type' => 'object',
					'subtype' => 'mission_inprogress',
					'metadata_name_value_pairs' => array(
						  array(
								  'name' => 'mission_guid',
									'value' => $mission->guid,
									'operand' => '='
							),
							array(
								  'name' => 'completed',
									'value' => 0,
									'operand' => '='
							)
					)
			)) > 0);
			if (!$in_progress) {
					// Create a new in progress record for Analytics
          $ia = elgg_set_ignore_access(true);
					$progress_record = new ElggObject();
					$progress_record->subtype = 'mission-inprogress';
					$progress_record->title = 'Mission Progress Report';
					$progress_record->mission_guid = $mission->guid;
					$progress_record->completed = 0;
					$progress_record->save();
          elgg_set_ignore_access($ia);
			}

			$mission_link = elgg_view('output/url', array(
					'href' => $mission->getURL(),
					'text' => $mission->title
			));

			// Saves time to fill data if this user fills the last spot.
			if(($relationship_count + 1) == $mission->number) {
				$mission->time_to_fill = time() - $mission->time_created;
				$mission->save;

				// Notify unsuccessfull participants.
				// WHY: Last available spot for this opportunity has been filled and we don't want to keep remaining participants hanging.
				$applicant_relationships = get_entity_relationships($mission->guid);
				$subject = elgg_echo('missions:participating_out', array(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))));
				$body = elgg_echo('missions:participating_out_more', array($applicant->name)) . $mission_link . '.';

				mm_notify_unsuccessfull_participants($mission, $applicant_relationships, $subject, $body);
			}

			// notify participant
			$subject = elgg_echo('missions:participating_in', array(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))),'en').' | '.elgg_echo('missions:participating_in', array(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))),'fr');
			$message_en = elgg_echo('missions:participating_in_more', array($applicant->name),'en') . $mission_link . '.';
			$message_fr = elgg_echo('missions:participating_in_more', array($applicant->name),'fr') . $mission_link . '.';

			send_email_opt($applicant->guid, $mission->guid, $subject, $message_en,$message_fr,'user');

			// notify owner
			$subject = elgg_echo( 'missions:participating_in2', array($applicant->name),'en').' | '.elgg_echo( 'missions:participating_in2', array($applicant->name),'fr');
			$message_en = elgg_echo('missions:participating_in2_more', array($applicant->name),'en') . $mission_link . '.';
			$message_fr = elgg_echo('missions:participating_in2_more', array($applicant->name),'fr') . $mission_link . '.';
			
			send_email_opt($applicant->guid, $mission->guid, $subject, $message_en,$message_fr,'user');
			
		}
	}
}

function send_email_opt($mission, $applicant_relationships, $subject, $message_en,$message_fr, $user){

$body = "<html>
<body>
    <!-- beginning of email template -->
    <div width='100%' bgcolor='#fcfcfc'>
        <div>
            <div>

                <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #055959'>
                    {$email_notification_header}
                </div>

                <div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#047177;'>
                    <span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'>GCconnex</span>
                </div>

                <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>

                <div width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>

                    <span style='font-size:12px; font-weight: normal;'>{$french_follows}</span><br/>

                </div>

                <div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px; '>

                    {$remove_en}

                </div>
                <div style='margin-top:15px; padding: 5px; color: #6d6d6d; border-bottom: 1px solid #ddd;'>
                    <div>{$email_notification_footer_en}</div>
                </div>

                <div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px;'>

                    {$remove_fr}

                </div>
                    <div style='margin-top:15px; padding: 5px; color: #6d6d6d;'>
                   <div>{$email_notification_footer_fr}</div>
                </div>

                <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>

                <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 16px; color: #055959'> </div>

            </div>
        </div>
    </div>
</body>
</html>";


	mm_notify_user($mission->guid, $applicant->guid, $subject, $body);




}

if ($err != '') {
	register_error($err);
	forward(REFERER);
}
else {
	system_message(elgg_echo('missions:now_participating_in_mission', array($mission->job_title)));
	forward($mission->getURL());
}

function mm_notify_unsuccessfull_participants($mission, $applicants, $subject, $body) {
	foreach ($applicants as $applicant) {
		if ($applicant->relationship == 'mission_applied' || $applicant->relationship == 'mission_offered') {
			mm_notify_user($applicant->guid_two, $mission->guid, $subject, $body);
		}
	}
}
