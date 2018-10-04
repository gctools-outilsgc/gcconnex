<?php

if ( elgg_is_active_plugin('web_services') && elgg_is_active_plugin('gcRegistration_invitation') && elgg_get_config('allow_registration') ) {
	
	elgg_ws_expose_function(
		"gc.invite",
		"talent_cloud_invite",
		array(
			"email" => array('type' => 'string', 'required' => true)
		),
		'Invites Talent Cloud user to register for GCcollab Account',
		'POST',
		true,
		false
	);

	function talent_cloud_invite($email) {
		
		// validation on email address

		if(!is_email_address($email)){
			return json_encode(array('success'=>false,'error'=>'The email submitted is not a valid email'));
		};

		$email = trim($email);

	    // Create TalentCloud user if they don't exist

		$api_user = get_user_by_username('TalentCloud');

		if (!$api_user){;
			$api_user = register_user('TalentCloud',substr(str_shuffle(md5(time())),0,10), 'TalentCloud', 'noreply-talentcloud@gccollab.ca', false);
		};

		// Check to see if invitaiton exists, if yes then we only need to send email and not register address again

		if (!invitationExists($email)){			
			$data = array('inviter' => $api_user->guid, 'emails' => [$email]);
			elgg_trigger_plugin_hook('gcRegistration_email_invitation', 'all', $data);
		};
		
		// Get site variables to construct email message

		$site = elgg_get_site_entity();

		// Set custom personalized message

		$emailmessage_en = 'Personalized message from GC Talent Cloud';
		$emailmessage_fr = 'Message personalisé de Nuage de talents du GC';

		$link_en = "<a href='https://account.gccollab.ca/register/'>GCcollab Account Registration</a>";
		$link_fr = "<a href='https://account.gccollab.ca/register/'>Compte GCcollab pour créer un compte</a>";

		$subject = elgg_echo('cp_notify:subject:invite_new_user',array(),'en') . ' | ' . elgg_echo('cp_notify:subject:invite_new_user',array(),'fr');

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_invite_new_user:title', array('GC Talent Cloud'),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_invite_new_user:title', array('Nuage de talents du GC'),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_invite_new_user:description',array('GC Talent Cloud', $emailmessage_en, $link_en),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_invite_new_user:description',array('Nuage de talents du GC', $emailmessage_fr, $link_fr),'fr');

		$email_notification_header = elgg_echo('cp_notification:email_header',array(),'en') . ' | ' . elgg_echo('cp_notification:email_header',array(),'fr');

		$french_follows = elgg_echo('cp_notify:french_follows',array());

		$current_year = date('Y');
		$current_site = elgg_get_site_entity()->name;

		$template = elgg_echo("
			<html>
			<body>
				<!-- beginning of email template -->
				<div width='100%' bgcolor='#fcfcfc'>
					<div>
						<div>
			
							<div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #79579D'>
								{$email_notification_header}
							</div>
			
							<div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#46246A;'>
								<span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'>GCcollab</span>
							</div>
			
							<div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>
			
							<div width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>
			
								<span style='font-size:12px; font-weight: normal;'>{$french_follows}</span><br/>
			
							</div>
			
			
			
							<div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px; '>
			
								<h4 style='padding: 0px 0px 5px 0px; font-family:sans-serif';>
									<strong> {$cp_notify_msg_title_en} </strong>
								</h4>
			
								{$cp_notify_msg_description_en}
			
							</div>
							<div style='margin-top:15px; padding: 5px; color: #6d6d6d; border-bottom: 1px solid #ddd;'>
							</div>
			
							<div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px;'>
			
								<h4 style='padding: 0px 0px 5px 0px; font-family:sans-serif;'>
									<strong> {$cp_notify_msg_title_fr} </strong>
								</h4>
			
			
								{$cp_notify_msg_description_fr}
			
							</div>
								<div style='margin-top:15px; padding: 5px; color: #6d6d6d;'>
							</div>
			
							<div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>
			
							<div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 16px; color: #79579D'>
								{$current_site} © {$current_year}
							</div>
						</div>
					</div>
				</div>
			</body>
			</html>");

		$result = phpmailer_send($email, $email, $subject, $template, NULL, true);

		if ($result){
			return json_encode(array('success'=>'true'));
		} else {
			return json_encode(array('success'=>'false', 'error'=>'Error trying to send email'));
		}

	};

	function invitationExists($emailaddress){
		$query = "SELECT * FROM email_invitations WHERE `email` = '" . $emailaddress . "'";
		$result = get_data($query);
		if (count($result) > 0){
			return true;
		} else{
			return false;
		};

	};
		
};

	

