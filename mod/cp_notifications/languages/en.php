<?php

$english = array(
	
	// texts that will be displayed in the email notification
	'cp_notification:email_header' => 'This is a system-generated message from GCconnex. Please do not reply to this message',
		
	'cp_notification:email_header_msg' => "",//"This is a system-generated message from GCconnex, you're receiving this notification because there has been an update or reply to the content that you have been subscribed to. If you have any questions or concerns please consult the contact us page here: %s 
		//Should you have any questions or concerns, please contact our Helpdesk at gcconnex@tbs-sct.gc.ca or learn more about GCconnex and its features here: %s <br/>
		//Thank you",
	
	// email subject lines	
	'cp_notify:subject:group_add_user' => "You have been added you into the group '%s'",
	
	'cp_notify:subject:group_invite_user' => "%s has invited you to join their group %s",
		
	'cp_notify:subject:group_invite_user_by_email' => "%s has invited you to join the group %s",
		
	'cp_notify:subject:group_request' => '%s has requested to join the group %s',
	
	'cp_notify:subject:group_mail' => "%s has sent out a group message '%s'",
	
	'cp_notify:subject:friend_request' => "%s wants to be your colleague!",
	
	'cp_notify:subject:forgot_password' => "You have requested a password reset",
	
	'cp_notify:subject:validate_user' => "Please validate account for %s",
	
	'cp_notify:subject:group_join_request' => "%s has requested to join your group '%s'",
	
	'cp_notify:subject:likes' => "%s has liked your post '%s'",
	
	'cp_notify:subject:comments' => "%s has posted a comment or reply to '%s'",
	
	'cp_notify:subject:site_message' => "%s has sent you a new message '%s'",
	
	'cp_notify:subject:new_content' => "%s has posted a new %s entitled '%s'", // needs to be redone (updated) 398
	
	'cp_notify:subject:mention' => "%s has mentioned you in their new post or reply",
	
	'cp_notify:subject:hjtopic' => "A new forum topic has been posted",
	
	'cp_notify:subject:hjpost' => "A new reply to a forum topic has been posted",
	
	'cp_notify:subject:approve_friend' => "%s has approved your colleague's request",

	'cp_notify:subject:group_invite_email' => "%s invited you to join this group '%s'",


	'cp_notify:subject:likes_comment' => "%s has liked your comment from '%s'",
	'cp_notify:subject:likes_discussion' => "%s liked your reply to '%s'",
	'cp_notify:subject:likes_user_update' => "%s liked your recent update",
	'cp_notify:subject:add_new_user' => "You have been added as a new user in GCconnex",
	'cp_notify:subject:invite_new_user' => "You have been invited to join GCconnex",


	// email notification content (title & corresponding description) 

	'cp_notify:body_friend_approve:title' => "%s has approved your colleague's request",

	'cp_notify:body_friend_approve:description' => "%s has approved your colleague's request",


	'cp_notify:body_likes:title' => "%s has liked your post called '%s'",
	'cp_notify:body_likes:description' => "You can view your content by clicking on this link: %s",
		

	'cp_notify:body_comments:title' => "%s posted a comment or reply to %s by %s",
	
	'cp_notify:body_comments:description' => "Their comment or reply as follows: <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",
	
	'cp_notify:body_new_content:title' => "%s has posted a new content entitled '%s'", // needs to be revised
	
	'cp_notify:body_new_content:description' => "The description of the new posting is: <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",
	
		
	'cp_notify:body_mention:title' => "%s has mentioned you in their post or reply entitled '%s'",
	
	'cp_notify:body_mention:description' => "Here is the post where you were mentioned: <br/>
		%s <br/>
		You can view or reply to this post by clicking on this link: %s",
	

	// site message
	'cp_notify:body_site_msg:title' => "%s has sent you a site message entitled '%s'",
	
	'cp_notify:body_site_msg:description' => "The content of the message is: <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",
	

	// group requesting membership
	'cp_notify:body_group_request:title' => "%s has sent you a request to join the group '%s'",
	
	'cp_notify:body_group_request:description' => "Please see the request by clicking on this link: %s,
		%s",
	

	'cp_notify:body_group_invite_email:title' => "You are invited to join a group on GCconnex",
	'cp_notify:body_group_invite_email:description' => "You are invited to join the '%s' GCconnex group",


	'cp_notify:body_group_add:title' => "You have been added to the group '%s'",
	
	'cp_notify:body_group_add:description' => "You have been added to the group %s: <br/>%s",
	

	'cp_notify:body_group_invite:title' => "%s has invited you to join the group '%s'",
	
	'cp_notify:body_group_invite:description' => "You have been invited to join the group '%s'<br/>
		%s <br/>
		Click here to view your invitation: %s",
		

	'cp_notify:body_group_mail:title' => "%s has sent a message to all its members '%s'",
	
	'cp_notify:body_group_mail:description' => "The group owner or administrator has sent the following message to all its members: <br/>
		%s",
	
	
	'cp_notify:body_friend_req:title' => '%s wants to be your colleague!',
	
	'cp_notify:body_friend_req:description' => "%s wants to be your colleague and is waiting waiting for you to approve the request <br/>
		View your pending colleague requests here: %s",
	
	'cp_notify:body_forgot_password:title' => "There was a password reset request from this IP: <code> %s </code>",
	
	'cp_notify:body_forgot_password:description' => "There was a request to have a password reset from this user's IP:<code> %s </code> <br/>
		Please click on this link to have the password resetted for %s's account: %s",
		
	'cp_notify:body_validate_user:title' => "Please validate your new account for %s",
	'cp_notify:body_validate_user:description' => "Welcome to GCconnex, to complete your registration, please validate the account registered under %s by clicking on this link: %s",



	'cp_notify:body_hjtopic:title' => "A new forum topic has been posted",

	'cp_notify:body_hjtopic:description' => "The description of the new posting is: <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",



	'cp_notify:body_hjpost:title' => "A new post in a forum topic has been posted",

	'cp_notify:body_hjpost:description' => "Their post or reply as follows: <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",



	'cp_notify:body_likes_comment:title' => "%s has liked your comment from '%s'", 
	'cp_notify:body_likes_comment:description' => "Your comment from '%s' was liked by %s", 

	'cp_notify:body_likes_discussion_reply:title' => "%s liked your reply to '%s'", 
	'cp_notify:body_likes_discussion_reply:description' => "Your reply to '%s' was liked by %s",

	'cp_notify:body_likes_user_update:title' => "%s liked your recent update", 
	'cp_notify:body_likes_user_update:description' => "Your recent update was liked by %s",

	'cp_notify:body_add_new_user:title' => "You have been added as a new user in GCconnex",
	'cp_notify:body_add_new_user:description' => "You can now log in using the following credentials <br/>
		Username: %s  and Password: %s",

	'cp_notify:body_invite_new_user:title' => "You have been invited to join GCconnex",
	'cp_notify:body_invite_new_user:description' => "Join the professionnal networking and collaborative workspace for all public service. You can proceed to your GCconnex registration through this link %s", 

	'cp_notify:body_event:title' => "Add event to your calendar",
	'cp_notify:body_event:description' => '%s<br>%s', 


	// email notification footer text (1 and 2)
	'cp_notify:footer' => "<p>If you do not want to receive this notification, please manage your subscription settings here: %s</p>",

    'cp_notify:footer2' => "",//"This is an automated message, please do not reply",


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
    
    'cp_notify:contactHelpDesk'=>'Should you have any concerns, please use the <a href="https://gcconnex.gc.ca/mod/contactform/">Contact us form</a>.',
    'cp_notify:visitTutorials'=>'To learn more about GCconnex and its features visit the <a href="http://www.gcpedia.gc.ca/wiki/GCconnex_User_Help/See_All">GCconnex User Help</a>.<br/>
	                             Thank you',
    'cp_notify:personal_likes'=>'Notify me when someone likes my content',
    'cp_notify:personal_mentions'=>'Notify me when someone @mentions me',
    'cp_notify:personal_content'=>'Notify me when something happens on content I create',

    'cp_notify:pickColleagues' => 'Pick colleagues to subscribe', // need translations
    'cp_notify:colleagueContent'=>'Notify me when my colleagues create content',
    'cp_notify:emailsForGroup'=>'Recieve emails about group notifications',
    'cp_notify:groupContent'=>'Group Content',
    'cp_notify:notifNewContent'=>'Notify me when new content is created (Discussion, Files, etc.)',
    'cp_notify:notifComments'=>'Notify me when comments are created',
);

add_translation("en", $english);