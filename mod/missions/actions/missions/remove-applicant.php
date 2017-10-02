<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * This action removes the relationship between the mission and one of its applicants.
 */
$mid = get_input('mid');;
$mission = get_entity($mid);
$aid = get_input('aid');
$user = get_user($aid);

if($aid == '') {
    register_error(elgg_echo('missions:error:no_applicant_to_remove'));
}
else {
	// Works on tentative, accepted, or applied relationships.
	if(check_entity_relationship($mid, 'mission_applied', $aid)) {
		remove_entity_relationship($mid, 'mission_applied', $aid);
	}
	if(check_entity_relationship($mid, 'mission_tentative', $aid)) {
		remove_entity_relationship($mid, 'mission_tentative', $aid);
	}
	if(check_entity_relationship($mid, 'mission_offered', $aid)) {
    	remove_entity_relationship($mid, 'mission_offered', $aid);
	}
	if(check_entity_relationship($mid, 'mission_accepted', $aid)) {
    	remove_entity_relationship($mid, 'mission_accepted', $aid);
			mm_complete_mission_inprogress_reports($mission, true);
	}
	
	$mission->time_to_fill = '';
	$mission->save();
	
    $body = '';
    // Notifies the manager that the candidate withdrew from the mission.
    if(elgg_get_logged_in_user_guid() == $aid) {
    	$target = $mission->guid;
    	$sender = $aid;
    	$subject = elgg_echo('missions:withdrew_from_mission', array($user->name, $mission->title), $user->language,'en').' | '.elgg_echo('missions:withdrew_from_mission', array($user->name, $mission->title), $user->language,'fr');
        $remove_en = elgg_echo('missions:withdrew_from_mission_body', array($user->name), $user->language,'en');
        $remove_fr = elgg_echo('missions:withdrew_from_mission_body', array($user->name), $user->language,'fr');

    }
    // Notifies the candidate that they were removed from the mission.
    else {
    	$target = $aid;
    	$sender = $mission->guid;
    	$subject = elgg_echo('missions:removed_from_mission', array($mission->title), $user->language,'en').' | 'elgg_echo('missions:removed_from_mission', array($mission->title), $user->language,'fr');
        $remove_en = elgg_echo('missions:removed_from_mission_body', array(), $user->language,'en');
        $remove_fr = elgg_echo('missions:removed_from_mission_body', array(), $user->language,'fr');

    }
        $email_notification_header = elgg_echo('cp_notification:email_header',array(),'en') . ' | ' . elgg_echo('cp_notification:email_header',array(),'fr');
        $french_follows = elgg_echo('cp_notify:french_follows',array());
        $email_notification_footer_en = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/notifications/{$username_link}".'?utm_source=notification&utm_medium=site'),'en');
        $email_notification_footer_fr = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/notifications/{$username_link}".'?utm_source=notification&utm_medium=site'),'fr');
        
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




    mm_notify_user($target, $sender, $subject, $body);
}

system_message(elgg_echo('missions:user_removed', array($user->name, $mission->job_title)));

forward(REFERER);