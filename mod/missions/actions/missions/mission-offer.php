<?php
/*
 * Author: National Research Council Canada
* Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
*
* License: Creative Commons Attribution 3.0 Unported License
* Copyright: Her Majesty the Queen in Right of Canada, 2015
*/

/*
 * Action which offers a place in the mission to user with the applied relationship.
 */
$applicant = get_user(get_input('aid'));
$mission = get_entity(get_input('mid'));

$err = '';

if($mission == '') {
	$err .= elgg_echo('missions:error:entity_does_not_exist');
}
else {
	if(!check_entity_relationship($mission->guid, 'mission_applied', $applicant->guid)) {
		$err .= elgg_echo('missions:error:applicant_not_applied_to_mission', array($applicant->name));
	}
	else {
		$relationship_count = elgg_get_entities_from_relationship(array(
				'relationship' => 'mission_accepted',
				'relationship_guid' => $mission->guid,
				'count' => true
		));
	    
		if($relationship_count >= $mission->number) {
			$err .= elgg_echo('missions:error:mission_full');
		}
		else {
			remove_entity_relationship($mission->guid, 'mission_applied', $applicant->guid);
			add_entity_relationship($mission->guid, 'mission_offered', $applicant->guid);

			// Create a record of when the mission is offered for Analytics
      $ia = elgg_set_ignore_access(true);
			$accept_record = new ElggObject();
			$accept_record->subtype = 'mission-wasoffered';
			$accept_record->title = 'Mission Offer Report';
			$accept_record->access_id = ACCESS_LOGGED_IN;
			$accept_record->owner_guid = $applicant->guid;
			$accept_record->mission_guid = $mission->guid;
			$accept_record->save();
      elgg_set_ignore_access($ia);

			$finalize_link = elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/view/' . $mission->guid,
					'text' => elgg_echo('missions:respond')
			));
			
			$email_notification_header = elgg_echo('cp_notification:email_header',array(),'en') . ' | ' . elgg_echo('cp_notification:email_header',array(),'fr');
			$french_follows = elgg_echo('cp_notify:french_follows',array());
			$email_notification_footer_en = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/notifications/{$username_link}".'?utm_source=notification&utm_medium=site'),'en');
			$email_notification_footer_fr = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/notifications/{$username_link}".'?utm_source=notification&utm_medium=site'),'fr');
			$subject = elgg_echo('missions:offers_you_a_spot', array(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))),'en', $applicant->language) .' | '.elgg_echo('missions:offers_you_a_spot', array(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))),'fr', $applicant->language);
			$offer_en = elgg_echo('missions:offers_you_a_spot_more', array(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))),'en', $applicant->language) . " {$finalize_link}" . '.';
			$offer_fr = elgg_echo('missions:offers_you_a_spot_more', array(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))),'fr', $applicant->language) . " {$finalize_link}" . '.';
			
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

		        	{$offer_en}

		        </div>
                <div style='margin-top:15px; padding: 5px; color: #6d6d6d; border-bottom: 1px solid #ddd;'>
                    <div>{$email_notification_footer_en}</div>
                </div>

		       	<div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px;'>

		       		{$offer_fr}

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

			mm_notify_user($applicant->guid, $mission->guid, $subject, $body);
		}
	}
}

if ($err != '') {
	register_error($err);
	forward(REFERER);
}
else {
	system_message(elgg_echo('missions:offered_user_position', array($applicant->name, $mission->job_title)));
	forward($mission->getURL());
}