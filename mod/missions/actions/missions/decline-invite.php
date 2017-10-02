<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Declines the invitation sent to a candidate and creates and mission-declination object.
 */
$applicant = get_user(get_input('hidden_applicant_guid'));
$mission = get_entity(get_input('hidden_mission_guid'));

// Processes the reason given by the declining user whether it's from the dropdown menu or the free text entry.
$reason = get_input('reason');

if($reason == 'missions:other') {
	$raw_reason = $reason;
	$reasonEn = get_input('other_text');
	$reasonFr = get_input('other_text');
}
else {
	$raw_reason = $reason;
	$reasonEn = elgg_echo($reason,'en');
	$reasonFr = elgg_echo($reason,'fr');

}

if(trim($reason) == '') {
	register_error(elgg_echo('missions:please_give_reason_for_declination'));
	forward(REFERER);
}

// Deletes the tentative relationship between mission and applicant.
if(check_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid)) {
	$message_return = 'missions:declination_has_been_sent';
	remove_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid);
}
if(check_entity_relationship($mission->guid, 'mission_applied', $applicant->guid)) {
	$message_return = 'missions:withdrawal_has_been_sent';
	remove_entity_relationship($mission->guid, 'mission_applied', $applicant->guid);
}
if(check_entity_relationship($mission->guid, 'mission_offered', $applicant->guid)) {
	$message_return = 'missions:declination_has_been_sent';
	remove_entity_relationship($mission->guid, 'mission_offered', $applicant->guid);
}
if(check_entity_relationship($mission->guid, 'mission_accepted', $applicant->guid)) {
	$message_return = 'missions:withdrawal_has_been_sent';
	remove_entity_relationship($mission->guid, 'mission_accepted', $applicant->guid);
  mm_complete_mission_inprogress_reports($mission, true);
}

// Object which stores the reason for declining a mission.
$ia = elgg_set_ignore_access(true);
$declination = new ElggObject();
$declination->subtype = 'mission-declination';
$declination->title = 'Micro-Mission Declination Report';
$declination->access_id = ACCESS_LOGGED_IN;
$declination->owner_guid = $applicant->guid;
$declination->mission_guid = $mission->guid;
$declination->applicant_reason = $raw_reason;
$declination->reason_text = $reason;
$declination->save();
elgg_set_ignore_access($ia);

// Notifies the mission manager of the candidates refusal.
$mission_link = elgg_view('output/url', array(
    'href' => $mission->getURL(),
    'text' => elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))
));

$subject = elgg_echo('missions:applicant_leaves', array($applicant->name),'en')." | ". elgg_echo('missions:applicant_leaves', array($applicant->name),'fr');
$email_notification_header = elgg_echo('cp_notification:email_header',array(),'en') . ' | ' . elgg_echo('cp_notification:email_header',array(),'fr');
$french_follows = elgg_echo('cp_notify:french_follows',array());
$email_notification_footer_en = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/notifications/{$username_link}".'?utm_source=notification&utm_medium=site'),'en');
$email_notification_footer_fr = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/notifications/{$username_link}".'?utm_source=notification&utm_medium=site'),'fr');


$withdrawnEn .= elgg_echo('missions:applicant_leaves_more', array($applicant->name),'en') . $mission_link . '.' . "\n";
($reasonFr ? $withdrawnReasonEn .= elgg_echo('missions:reason_given', array($reasonEn),'en') : elgg_echo('missions:reason_given', array($reason),'en'));

$withdrawnFr .= elgg_echo('missions:applicant_leaves_more', array($applicant->name),'fr') . $mission_link . '.' . "\n";
($reasonFr ? $withdrawnReasonFr .= elgg_echo('missions:reason_given', array($reasonFr),'fr') : elgg_echo('missions:reason_given', array($reason),'fr'));


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

		        	<h4 style='padding: 0px 0px 5px 0px; font-family:sans-serif';>
		        		<strong> {$withdrawnEn} </strong>
		        	</h4>

		        	{$withdrawnReasonEn}

		        </div>
                <div style='margin-top:15px; padding: 5px; color: #6d6d6d; border-bottom: 1px solid #ddd;'>
                    <div>{$email_notification_footer_en}</div>
                </div>

		       	<div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px;'>

		       		<h4 style='padding: 0px 0px 5px 0px; font-family:sans-serif;'>
		       			<strong> {$withdrawnFr} </strong>
		       		</h4>


		       		{$withdrawnReasonFr}

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

system_message(elgg_echo($message_return, array($mission->job_title)));
forward(elgg_get_site_url() . 'missions/main');