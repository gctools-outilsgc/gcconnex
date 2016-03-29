<?php

$english = array(
	
	// texts that will be displayed in the email notification
	'cp_notification:email_header' => 'This is a system-generated message from GCconnex. Please do not reply to this message',
		
	'cp_notification:email_header_msg' => "This is a system-generated message from GCconnex, you're receiving this notification because there has been an update or reply to the content that you have been subscribed to. If you have any questions or concerns please consult the contact us page here: %s 
		Should you have any questions or concerns, please contact our Helpdesk at gcconnex@tbs-sct.gc.ca or learn more about GCconnex and its features here: %s <br/>
		Thank you",
	
	// email subject lines	
	'cp_notify:subject:group_add_user' => '%s has added you into their group %s',
	
	'cp_notify:subject:group_invite_user' => '%s has invited you to join their group %s',
		
	'cp_notify:subject:group_invite_user_by_email' => '%s has invited you to join their group %s',
		
	'cp_notify:subject:group_request' => '%s has requested to join the group %s',
	
	'cp_notify:subject:group_mail' => "%s has sent out a group message '%s'",
	
	'cp_notify:subject:friend_request' => "%s has sent you a colleague request",
	
	'cp_notify:subject:forgot_password' => "You have requested a password reset",
	
	'cp_notify:subject:validate_user' => "Please validate account for %s",
	
	'cp_notify:subject:group_join_request' => "%s has requested to join your group '%s'",
	
	'cp_notify:subject:likes' => "%s has liked your post '%s'",
	
	'cp_notify:subject:comments' => "%s has posted a comment or reply to '%s'",
	
	'cp_notify:subject:site_message' => "%s has sent you a new message '%s'",
	
	'cp_notify:subject:new_content' => "%s has posted something new entitled '%s'",
	
	'cp_notify:subject:mention' => "%s has mentioned you in their new post or reply",
	
	'cp_notify:subject:hjtopic' => "New Forum Topic had been posted",
	
	'cp_notify:subject:hjpost' => "New reply to a Forum Topic",
	

	// email notification content (title & corresponding description) 
	'cp_notify:body_likes:title' => "%s has liked your post called '%s'",
	
	'cp_notify:body_likes:description' => "You can view your content by clicking on this link: %s",
		

	'cp_notify:body_comments:title' => "%s posted a comment or reply to %s by %s",
	
	'cp_notify:body_comments:description' => "Their comment or reply as follows... <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",
	
	'cp_notify:body_new_content:title' => "%s has created something new entitled '%s'",
	
	'cp_notify:body_new_content:description' => "The description of their new posting as follows... <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",
	
		
	'cp_notify:body_mention:title' => "%s has mentioned your name in their post or reply entitled '%s'",
	
	'cp_notify:body_mention:description' => "The posting you were mentioned in as follows... <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",
	

	// site message
	'cp_notify:body_site_msg:title' => "%s has sent you a site message entitled '%s'",
	
	'cp_notify:body_site_msg:description' => "The content of the message as follows... <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",
	

	// group requesting membership
	'cp_notify:body_group_request:title' => "%s has sent you a join request to your group '%s'",
	
	'cp_notify:body_group_request:description' => "Please see the request by clicking on this link: %s,
		%s",
	

	'cp_notify:body_group_add:title' => "%s has added you into their group '%s'",
	
	'cp_notify:body_group_add:description' => "You have been added to the group %s with the following message... <br/>",
	

	'cp_notify:body_group_invite:title' => "%s has invited you to join their group '%s'",
	
	'cp_notify:body_group_invite:description' => "You have been invited to join the group '%s' with the following message... <br/>
		%s <br/>
		You can view your invitation by clicking here: %s",
		

	'cp_notify:body_group_mail:title' => "%s has sent out a message to all its members '%s'",
	
	'cp_notify:body_group_mail:description' => "The group owner or administrator has sent out a message to all its members with the following message... <br/>
		%s",
	
	
	'cp_notify:body_friend_req:title' => '%s has sent you a colleague request',
	
	'cp_notify:body_friend_req:description' => "%s has sent you a colleague request and are waiting for you to accept them <br/>
		To view the colleague request invitation please click on this linke: %s",
	
	'cp_notify:body_forgot_password:title' => "There was a password reset request from this IP: <code %s </code>",
	
	'cp_notify:body_forgot_password:description' => "There was a request to have a password reset from this user's IP:<code %s </code> <br/>
		Please go to this link to have your password resetted for %s's account: %s",
		
	'cp_notify:body_validate_user:title' => "Please validate your new account for %s",
	'cp_notify:body_validate_user:description' => "Welcome to GCconnex, to complete your registration, please validate the account registered under %s by going to this link: %s",


	'cp_notify:body_hjtopic:title' => "New Forum Topic has been posted",

	'cp_notify:body_hjtopic:description' => "",


	'cp_notify:body_hjforum:title' => "New Post in a Forum Topic has been posted",

	'cp_notify:body_hjforum:description' => "",



	// email notification footer text (1 and 2)
	'cp_notify:footer' => "<p>If you do not want to receive this notification, please manage your subscription settings here: %s</p>",

    'cp_notify:footer2' => "This is an automated message, please do not reply",



	// texts that will be displayed in the site pages
	'cp_notify:panel_title' => 'Subscription settings (click to edit email: %s)',
	'cp_notify:quicklinks' => 'Subscription Quick Links',
	'cp_notify:content_name' => 'Content Name',
	'cp_notify:email' => 'Notify by e-mail',
	'cp_notify:site_mail' => 'Notify by site mail',
	'cp_notify:subscribe' => 'Subscribe',
	'cp_notify:unsubscribe' => 'Unsubscribe',
	'cp_notify:not_subscribed' => 'Not Subscribed',

	'cp_notify:no_group_sub' => "You have not subscribed to any Group content",
	'cp_notify:no_sub' => "You have not subscribed to any content",

	"cp_notify:sidebar:no_subscriptions" => "<i>No Subscriptions Available</i>",
	"cp_notify:sidebar:group_title" => "Group + Content Subscriptions",
	"cp_notify:sidebar:subs_title" => "Personal Subscriptions",

);

add_translation("en", $english);