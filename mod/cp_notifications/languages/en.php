<?php

$english = array(
	
	// e-mail header text
	'cp_notification:email_header' => 'This is a system-generated message from GCconnex. Please do not reply to this message',
	'cp_notification:email_header_msg' => "",	

	// add user to group section
	'cp_notify:subject:group_add_user' => "You have been added the group '%s'",
	'cp_notify:body_group_add:title' => "You have been added to the group '%s'",
	'cp_notify:body_group_add:description' => "You have been added to the group %s: <br/>%s",


	// content edit section
	'cp_notify:subject:edit_content' => "%s has been updated by %s",
	'cp_notify:body_edit:title' => "This content has been edited. Click here to view the content: %s",
	'cp_notify:body_edit:description' => "To unsubscribe to this notification: %s",


	// group invite user section
	'cp_notify:subject:group_invite_user' => "%s invited you to join their group %s",
	'cp_notify:body_group_invite:title' => "%s invited you to join the group '%s'",
	'cp_notify:body_group_invite:description' => "You have been invited to join the group '%s'<br/>
		%s <br/>
		Click here to view your invitation: %s",


	// group invite by email section
	'cp_notify:subject:group_invite_email' => "%s invited you to join the group '%s'",
	'cp_notify:subject:group_invite_user_by_email' => "%s invited you to join the group %s",
	'cp_notify:body_group_invite_email:title' => "You are invited to join a group on GCconnex",
	'cp_notify:body_group_invite_email:description' => "You are invited to join the '%s' GCconnex group, please register or log in to GCconnex, then click on this link: %s or use this code on the group invitation page: '%s' <br/> %s",


	// group mail section
	'cp_notify:subject:group_mail' => "You have received a message entitled '%s' from the group '%s'",
	'cp_notify:body_group_mail:title' => "You have received a message entitled '%s' from the group '%s'",
	'cp_notify:body_group_mail:description' => "The group owner or administrator has sent the following message: <br/>
		%s",


	// group join request section
	'cp_notify:subject:group_request' => '%s requested to join the group %s',
	'cp_notify:subject:group_join_request' => "%s requested to join your group '%s'",
	'cp_notify:body_group_request:title' => "%s sent you a request to join the group '%s'",
	'cp_notify:body_group_request:description' => "See the request by clicking on this link: %s,
		%s",


	// likes section
	'cp_notify:subject:likes' => "%s liked your post '%s'",
	'cp_notify:body_likes:title' => "%s liked your post '%s'",

	'cp_notify:subject:likes_wire' => "%s liked your wire post",
	'cp_notify:body_likes_wire:title' => "%s liked your wire post '%s'",

	'cp_notify:subject:likes_comment' => "%s liked your comment from '%s'",
	'cp_notify:body_likes_comment:title' => "%s liked your comment from '%s'", 
	'cp_notify:body_likes_comment:description' => "Your comment from '%s' was liked by %s", 

	'cp_notify:subject:likes_discussion' => "%s liked your reply to '%s'",
	'cp_notify:body_likes_discussion_reply:title' => "%s liked your reply to '%s'", 
	'cp_notify:body_likes_discussion_reply:description' => "Your reply to '%s' was liked by %s",

	'cp_notify:subject:likes_user_update' => "%s liked your your updated avatar or your new colleague connection",
	'cp_notify:body_likes_user_update:title' => "%s liked your your updated avatar or your new colleague connection",
	'cp_notify:body_likes_user_update:description' => "Your recent avatar update or your new colleague connection was liked by %s", 

	// cyu - there doesn't seem to be any differentiation between updated avatar and colleague connection
	/*
	'cp_notify:subject:likes_user_update_avatar' => "%s liked your your updated avatar", // Please update
	'cp_notify:body_likes_user_update:title_avatar' => "%s liked your updated avatar", // Please update
	'cp_notify:body_likes_user_update:description_avatar' => "Your recent avatar update was liked by %s", // Please update
	
	'cp_notify:subject:likes_user_update_colleague' => "%s liked your new colleague connection", // Please update
	'cp_notify:body_likes_user_update:title_colleague' => "%s liked your recent update on your '%s'", // Please update
	'cp_notify:body_likes_user_update:description_colleague' => "Your recent update on your '%s' was liked by %s", // Please update
	*/

	'cp_notify:body_likes:description' => "You can view your content by clicking on this link: %s",


	// posted comment section
	'cp_notify:subject:comments' => "%s posted a comment on '%s'",
	'cp_notify:body_comments:title' => "%s posted a comment to '%s' by %s",
	'cp_notify:body_comments:description' => "The comment is: <br/>
		%s <br/>
		You can view or reply to this by clicking on the following link: %s",


	// site message section
	'cp_notify:subject:site_message' => "%s sent you a new message '%s'",
		'cp_notify:body_site_msg:title' => "%s sent you a site message entitled '%s'",
	'cp_notify:body_site_msg:description' => "The content of the message is: <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",


	// new content posted section
	'cp_notify:subject:new_content' => "%s posted a new %s with the title '%s'",

	'cp_notify:subject:in' => " in %s",

	'cp_notify:body_new_content:title' => "%s posted new content entitled '%s'",
	'cp_notify:body_new_content:description' => "The description of the new posting is: <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",


	// mentioned section
	'cp_notify:subject:mention' => "%s mentioned you on GCconnex",
	'cp_notify:body_mention:title' => "%s mentioned you in their post or reply entitled '%s'",
	'cp_notify:body_mention:description' => "Here is the post where you were mentioned: <br/>
		%s <br/>
		You can view or reply to this post by clicking on this link: %s",


	// hjtopic section
	'cp_notify:subject:hjtopic' => "%s posted a new forum topic titled '%s'",
	'cp_notify:body_hjtopic:title' => "A new forum topic has been posted with the title '%s'",
	'cp_notify:body_hjtopic:description' => "The description of the new posting is: <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",


	// hjpost (replies/comment) section
	'cp_notify:subject:hjpost' => "%s replied to a the forum topic '%s'",
	'cp_notify:body_hjpost:title' => "A new post has been added to the forum topic '%s'",
	'cp_notify:body_hjpost:description' => "The post or reply as follows: <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",


	// friend approval section
	'cp_notify:subject:approve_friend' => "%s approved your colleague's request",
	'cp_notify:body_friend_approve:title' => "%s approved your colleague's request",
	'cp_notify:body_friend_approve:description' => "%s approved your colleague's request",


	// mention user on the wire section
	'cp_notify:subject:wire_mention' => "%s mentioned you on the wire",
	'cp_notify:body_wire_mention:title' => "You've been mentioned on the wire",
	'cp_notify:body_wire_mention:description' => "%s mentioned you in his/her wire post. <br/>
		To view your mentions on the wire, click here: %s",


	// add new user to gcconnex section
	'cp_notify:subject:add_new_user' => "You have been added as a new user in GCconnex",
	'cp_notify:body_add_new_user:title' => "You have been added as a new user in GCconnex",
	'cp_notify:body_add_new_user:description' => "You can now log in using the following credentials <br/>
		Username: %s  and Password: %s",


	// invited to join GCconnex section
	'cp_notify:subject:invite_new_user' => "You have been invited to join GCconnex",
	'cp_notify:body_invite_new_user:title' => "You have been invited to join GCconnex",
	'cp_notify:body_invite_new_user:description' => "Join the professionnal networking and collaborative workspace for all public service. You can proceed to your GCconnex registration through this link %s", 


	// transfer admin
	'cp_notify:subject:group_admin_transfer' => "You are now the owner of the group '%s'", 
	'cp_notify:body_group_admin_transfer:title' => "You are now the owner of the group '%s'",
	'cp_notify:body_group_admin_transfer:description' => "%s has transfered you the ownership of the group '%s'.<br/><br/>
		To visit the group, please click on the following link: <br/> 
		%s",


	// add group operator section
	'cp_notify:subject:add_grp_operator' => "The owner of the group '%s' delegated operator rights to you",
	'cp_notify:body_add_grp_operator:title' => "The owner of the group '%s' delegated operator rights to you",
	'cp_notify:body_add_grp_operator:description' => "%s has delegated you as an operator of the group '%s'.<br/><br/>
		To visit the group, please click on the following link: <br/> 
		%s", // translate
	

	// friend request section
	'cp_notify:subject:friend_request' => "%s wants to be your colleague!",
	'cp_notify:body_friend_req:title' => '%s wants to be your colleague!',
	'cp_notify:body_friend_req:description' => "%s wants to be your colleague and is waiting for you to approve the request... So login now to approve the request!<br/>
		You can view your pending colleague requests : %s",
	

	// forgot password 
	'cp_notify:subject:forgot_password' => "You have requested a password reset",
	'cp_notify:body_forgot_password:title' => "There was a password reset request from this IP address: <code> %s </code>",
	'cp_notify:body_forgot_password:description' => "There was a request to have a password reset from this user's IP address:<code> %s </code> <br/>
		Please click on this link to have the password resetted for %s's account: %s",
		

	// validate user 
	'cp_notify:subject:validate_user' => "Please validate account for %s",
	'cp_notify:body_validate_user:title' => "Please validate your new account for %s",
	'cp_notify:body_validate_user:description' => "Welcome to GCconnex, to complete your registration, please validate the account registered under %s by clicking on this link: %s",


	// user posting message on messageboard section
	'cp_notify:messageboard:subject' => "Someone wrote on your message board",
	'cp_notify:body_messageboard:title' => "Someone wrote on your message board",
	'cp_notify:body_messageboard:description' => "%s wrote on your messageboard with the following message: <br/><br/>
		%s <br/>
		To view your messageboard, please click on the following link: %s",


	// sharing content on wire section
	'cp_notify:wireshare:subject' => "%s shared your %s with title '%s'",
	'cp_notify:body_wireshare:title' => "%s shared your %s with title '%s'",
	'cp_notify:body_wireshare:description' => "%s has shared your %s on the wire, to view or reply to this please click on the following link: %s",
	'cp_notify:wireshare_thewire:subject' => "%s shared your message on the wire",

	// event calendar section
	'cp_notify:event:subject' => "Event calendar",
	'cp_notify:body_event:title' => "Event calendar",
	'cp_notify:body_event:description' => 'Information: <br/> %s',

	'cp_notify:body_event:event_title' => '<b>Title:</b> %s',
	'cp_notify:body_event:event_time_duration' => '<b>When:</b> %s',
	'cp_notify:body_event:event_location' => '<b>Venue:</b> %s',
	'cp_notify:body_event:event_room' => '<b>Room:</b> %s',
	'cp_notify:body_event:event_teleconference' => '<b>Online meeting and teleconference:</b> %s',
	'cp_notify:body_event:event_additional' => '<b>Additional information:</b> %s',
	'cp_notify:body_event:event_fees' => '<b>Fees:</b> %s',
	'cp_notify:body_event:event_organizer' => '<b>Organiser:</b> %s',
	'cp_notify:body_event:event_contact' => '<b>Contact:</b> %s',
	'cp_notify:body_event:event_long_description' => '<b>Long description:</b> %s',
	'cp_notify:body_event:event_language' => '<b>Event language:</b> %s',
	'cp_notify:body_event:event_link' => '<b>Add to my Outlook calendar:</b> %s',
	'cp_notify:body_event:event_add_to_outlook' => 'Add to my outlook calendar',

	// event calendar (request) section
	'cp_notify:event_request:subject' => "%s want to add %s at his calendar ", // NEW
	'cp_notify:body_event_request:title' => "Calendar request", // NEW
	'cp_notify:body_event_request:description' => '%s make a request to add %s to his calendar<br><br>To view the request, click here: <a href="%s">Demande d\'ajout</a>', //  Check URL or link

	// event calendar (update)
	'cp_notify:event_update:subject' => "The Event %s has been updated", // NEW


	// email notification footer text (1 and 2)
	'cp_notify:footer' => "<p>If you do not want to receive these types of notifications, you can change your subscription settings by clicking on this link: %s</p>", // Check URL or link
    'cp_notify:footer2' => "",




	// texts that will be displayed in the site pages
    'cp_notifications:usersettings:title' => 'Notifications Settings',

    'label:email' => "Email",
    'label:site' => "Site",
	'cp_notify:panel_title' => 'Subscription settings (click to edit %s)',
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
	"cp_notify:sidebar:group_title" => "Group you are member of",
	"cp_notify:sidebar:subs_title" => "Personal Subscriptions",
    
    'cp_notify:contactHelpDesk'=>'Should you have any concerns, please use the <a href="https://gcconnex.gc.ca/mod/contactform/">Contact us form</a>.',
    'cp_notify:visitTutorials'=>'To learn more about GCconnex and its features visit the <a href="http://www.gcpedia.gc.ca/wiki/GCconnex_User_Help/See_All">GCconnex User Help</a>.<br/>
	                             Thank you',
    'cp_notify:personal_likes'=>'Notify me when someone likes my content',
    'cp_notify:personal_mentions'=>'Notify me when someone @mentions me',
    'cp_notify:personal_content'=>'Notify me when something happens on content I create',

    'cp_notify:pickColleagues' => 'Subscribe to your colleagues',
    'cp_notify:colleagueContent'=>'Notify me when my colleagues create content',
    'cp_notify:emailsForGroup'=>'Select All',
    'cp_notify:groupContent'=>'Group Content',
    'cp_notify:notifNewContent'=>'Notify me when new content is created (Discussion, Files, etc.)',
    'cp_notify:notifComments'=>'Notify me when comments are created',
    'cp_notify:siteForGroup'=>'Select All',
    'cp_notify:unsubBell'=>'You are subscribed to this content. Click to unsubscribe.',
    'cp_notify:subBell'=>'You are not subscribed to this content. Click to subscribe and recieve notifications about this content.',
    'cp_notify:comingSoon'=>'Coming soon!',
    'cp_notify:personalNotif'=>'Personal Notifications',
    'cp_notify:collNotif'=>'Colleague Notifications',
    'cp_notify:groupNotif'=>'Group Notifications',

    'cp_notify:start_subscribe' => 'Start Subscription',
    'cp_notify:stop_subscribe' => 'Stop Subscription',

    'cp_notify:personal_bulk_notifications' => 'Enable Notification Digest',
	'cp_notify:minor_edit' => 'Minor Edit',
	'cp_notify:sidebar:forum_title' => 'Forum and Forum Topics',

	'cp_notify:wirepost_generic_title' => 'Wire post',
	'cp_notify:subscribe_all_label' => "<a href='%s'>Subscribe</a> or <a href='%s'> Unsubscribe</a> to all groups and their content",
	'cp_notify:unsubscribe_all_label' => 'Click here to unsubscribe to all the groups update',
	'cp_notify:personal_setting' => 'Your Subscriptions',
	'cp_notify:no_subscription' => 'There are no subscriptions',
);

add_translation("en", $english);