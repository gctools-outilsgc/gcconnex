<?php

$site = elgg_get_site_entity();
$site_name = $site->name;
$contact_us = "{$site->getURL()}mod/contactform/?utm_source=notification_digest&utm_medium=email";

$english = array(
	'cp_newsletter:NO_content_notifications' => "New content notifications is disabled, use the digest or newsfeed",

	'cp_notification:group_invite' => "<p>%s</p><p>Click the following link to view your invitation (you must be logged in to view this page): %s</p>
	<p>Need help? See the article '<a href='%s'>How to join a group?</a>' or <a href='%s'>contact us</a></p>",

	'cp_notification:group_invite_email' => "<p>%s</p><p><b>Join us on %s!</b> <a href='%s'>Create a %s account using this link</a> to be automatically added to the group.</p>
	<p>If you decide to create your account at a later time using the <a href='%s'>Registration form</a> on %s, you can join this group by entering the following code on your Group Invitations page: %s</p>
	<p><b>Already a member of %s?</b> <a href='%s'>Login</a> and go to your Group Invitations page to accept (or decline) the invitation.</p>
	<p>Need help? See the article '<a href='%s'>How to join a group?</a>' or <a href='%s'>contact us</a></p>",

	'notifications:did_not_send' => "Notifications did not send",

	'minor_save:title' => "Don’t want to send a notification?",
	'minor_save:description' => "Posting new content will send out notifications to those who are subscribed. As the group owner or operator, you can decide not to send out notifications about the new content you post in the group. To do so, select the option “Do not send a notification” below.",
	'minor_save:checkbox_label' => " Do not send a notification",

	'cp_notifications:name' => "Notification settings",
	'cp_notification:save:success' => "Settings have been saved successfully",
	'cp_notification:save:failed' => "Settings did not save successfully",

	/// SETTINGS PAGE: Newsletter translation texts
	'cp_newsletter:notice' => "Choose how you want to be notified of GCconnex activities of interest to you. The <strong>notifications digest</strong> can be used to receive a daily or weekly email that provides a summary of the activities to which you are subscribed. Prefer to receive instant notification? Forgo the digest and select the content for which you want to receive notification in real-time. Please note that email notifications are sent to the email address used in your <a href='{$site->getURL()}settings/user/?utm_source=notification_digest&utm_medium=email'>Account Settings</a>. See: “<a href='http://www.gcpedia.gc.ca/wiki/GCconnex_User_Help/Manage_Account_Settings/How_Do_I_Change_My_Notifications_Settings%3F?utm_source=notification_digest&utm_medium=email'>How Do I Change My Notifications Settings</a>?” for more information.",
	'cp_newsletter:notice:disable_digest' => "The notifications digest is now enabled; please select your digest preferences below (frequency and language preference). The digest will include all content selected in the 'Email' column below, as well the subscriptions in the 'Other content subscriptions' section. If you choose to enable the notifications digest, you will no longer receive real-time (instant) notifications by email and/or on the site, about activities happening on GCconnex (with the exception of administrative-type notifications).",

	'cp_newsletter:subject:daily' => 'Your Daily Digest', 
	'cp_newsletter:subject:weekly' => 'Your Weekly Digest', 
	'cp_newsletter:enable_digest_option' => "Enable your notifications digest",
	'cp_newsletter:label:english' => "English",
	'cp_newsletter:label:french' => "French",
	'cp_newsletter:label:daily' => "Daily",
	'cp_newsletter:label:weekly' => "Weekly",


	'cp_newsletter:information:digest_option' => "This will enable or disable the digest. Click \"Save\" to save your settings.",
	'cp_newsletter:information:digest_option:url' => "#",
	'cp_newsletter:information:frequency' => "This will determine how often you want to receive the digest",
	'cp_newsletter:information:frequency:url' => "#",
	'cp_newsletter:information:language' => "This will determine in which language you will receive the digest",
	'cp_newsletter:information:language:url' => "#",
	'cp_newsletter:information:select_all' => "This will only select the group itself, not the group content",
	'cp_newsletter:information:select_all:url' => "#",
	'cp_newsletter:set_frequency' => "How often do you want to receive the digest?",
	'cp_newsletter:set_language' => "In which language do you want to receive the digest?",


	'cp_notifications:subtype:groupforumtopic' => "Discussions",
	'cp_notifications:subtype:hjforumtopic' => "Forum Topic",
	'cp_notifications:subtype:hjforumpost' => "Topic reply",
	'cp_notifications:subtype:page' => "Page",
	'cp_notifications:subtype:page_top' => "Page",
	'cp_notifications:subtype:blog' => "Blog",
	'cp_notifications:subtype:bookmarks' => "Bookmark",
	'cp_notifications:subtype:file' => "File",
	'cp_notifications:subtype:album' => "Album",
	'cp_notifications:subtype:thewire' => "Wire",
	'cp_notifications:subtype:poll' => "Poll",
	'cp_notifications:subtype:event_calendar' => "Event Calendar",
	'cp_notifications:subtype:photo' => "Image",
	'cp_notifications:subtype:task' => "Task",


	'cp_notifications:mail_body:subtype:groupforumtopic' => "% posted a discussions: %s", 
	'cp_notifications:mail_body:subtype:hjforumtopic' => "%s posted a forum topic: %s", 
	'cp_notifications:mail_body:subtype:hjforumpost' => "%s posted a topic reply to: %s", 
	'cp_notifications:mail_body:subtype:page' => "%s posted a page: %s", 
	'cp_notifications:mail_body:subtype:page_top' => "%s posted a page: %s", 
	'cp_notifications:mail_body:subtype:blog' => "%s posted a blog: %s", 
	'cp_notifications:mail_body:subtype:bookmarks' => "%s posted a bookmark: %s", 
	'cp_notifications:mail_body:subtype:file' => "%s posted a file: %s", 

	'cp_notifications:mail_body:subtype:album' => "%s posted an album: %s", 
	'cp_notifications:mail_body:subtype:thewire' => "%s posted a new %s message titled:",
	'cp_notifications:mail_body:subtype:thewire_digest' => "%s posted a new %s message titled: %s",
	
	'cp_notifications:mail_body:subtype:thewireSubj' => "%s posted a new %s message",
	
	'cp_notifications:mail_body:subtype:thewireImage' => "%s posted a new message on the Wire:",
	'cp_notification_wire_image_only' => 'See Wire post image on the Wire',
	'cp_notification_wire_image' => '(See the Wire post to view the image)',
	
	
	
	'cp_notifications:mail_body:subtype:poll' => "%s created a poll: %s", 
	'cp_notifications:mail_body:subtype:event_calendar' => "%s posted an event: %s", 
	'cp_notifications:mail_body:subtype:photo' => "%s posted an image: %s", 
	'cp_notifications:mail_body:subtype:task' => "%s created a task: %s", 
	'cp_notifications:mail_body:subtype:likes' => "%s liked your post: %s",

	/// new translation require attention
	'cp_notifications:mail_body:subtype:file_upload' => "%s posted %s file(s): %s", 	


	/// new text
	'cp_notifications:mail_body:subtype:file_upload:singular' => "%s has uploaded %s file:",
	'cp_notifications:mail_body:subtype:file_upload:plural' => "%s has uploaded %s files:",
	'cp_notifications:mail_body:subtype:file_upload:group:singular' => "%s has uploaded %s file in %s:",
	'cp_notifications:mail_body:subtype:file_upload:group:plural' => "%s has uploaded %s files in %s:",



	'cp_notifications:mail_body:subtype:response' => "%s replied or commented on the post: %s",

	'cp_notifications:mail_body:subtype:any' => "%s posted a%s %s: %s", // john doe posted an idea vs john doe posted a blog

	'cp_notifications:mail_body:subtype:oppourtunity' => "%s posted an opportunity (%s): %s",

	'cp_notifications:mail_body:subtype:content_revision' => "%s revised the %s: %s", 
	'cp_notifications:mail_body:subtype:mention' => "%s mentioned you in the %s: %s", 

	'cp_notifications:mail_body:subtype:wire_mention' => "%s mentioned you on the %s",

	'cp_notifications:mail_body:subtype:content_share' => "%s shared your %s: %s", 
	'cp_notifications:mail_body:subtype:content_share:wire' => "%s shared your %s",
	'cp_notifications:mail_body:your_wire_post' => "Wire post",
	'cp_notifications:mail_body:wire_has_image' => " with an image",

	'cp_newsletter:other_content:notice' => "These subscriptions are only for content items that are not part of a group", 

	'cp_notifications:subtype:name:thewire' => "wire",

	'cp_notifications:no_colleagues' => "You do not have any colleagues",
    'cp_notifications:chkbox:email' => "Email",
    'cp_notifications:chkbox:site' => "Site",
	'cp_notifications:unsubscribe' => 'Unsubscribe',
	'cp_notifications:not_subscribed' => 'Not Subscribed',
	'cp_notifications:pick_colleagues' => 'Subscribe to your colleagues',
	'cp_notifications:group_content'=>'Group Content',

    'cp_notifications:no_group_subscription' => "Nothing to load",
 	'cp_notifications:no_personal_subscription' => "No content subscription",

 	'cp_notifications:loading' => 'Loading...',
	'cp_notifications:subscribe_all_label' => "<a href='%s'>Subscribe</a> or <a href='%s'> Unsubscribe</a> to all groups and their content",
	'cp_notifications:chkbox:select_all_group_for_notification' => "Select all groups (this will not select the group content)",
    'cp_notify:personal_bulk_notifications' => 'Enable Notifications Digest',

    'cp_notifications:personal_likes' => 'Notify me when someone likes my content',
    'cp_notifications:personal_mentions' => 'Notify me when someone @mentions me',
    'cp_notifications:personal_content' => 'Notify me when something happens on content I create',
    'cp_notifications:personal_colleagues' => 'Notify me when my colleagues create content',
	'cp_notifications:personal_opportunities' => "Notify me when a new opportunity I have opted in for is created in the Career Marketplace",

	'cp_notifications:no_group_content' => "(No group content subscription)",

	/// SETTINGS PAGE: Notification headings
	'cp_notifications:heading:page_title' => 'Your Subscriptions',
	'cp_notifications:your_email' => "your email",
	'cp_notifications:heading:newsletter_section' => "Notifications Digest",
 	'cp_notifications:heading:personal_section'=>'Personal Notifications',
    'cp_notifications:heading:colleague_section'=>'Colleague Notifications',
    'cp_notifications:heading:group_section' => 'Group Notifications',
 	'cp_notifications:heading:nonGroup_section' => 'Other Content Subscriptions',

	'cp_notifications:subtype:name:thewire' => "Wire",
	
	/// (NEWSLETTER) THROUGH EMAIL SERVER, EMAIL CONTENT: Newsletter email notifications
	'cp_newsletter:title:nothing' => "Your {$site_name} Digest: Nothing to report today",
	'cp_newsletter:body:nothing' => "It seems it was quiet in your network on GCconnex. Join <a href='{$site->getURL()}groups/all?filter=popular?utm_source=notification_digest&utm_medium=email'>groups</a> of interest, share information and add new <a href='{$site->getURL()}members/popular?utm_source=notification_digest&utm_medium=email'>colleagues</a> to stay informed and grow your network!",
	'cp_newsletter:title' => "Your {$site_name} Digest: New activities to report!", 
	'cp_newsletter:greeting' => "Good morning %s. Here are your notifications for <strong>%s</strong>",


	/// NEWSLETTER HEADINGS
	'cp_newsletter:heading:notify:personal:singular' => "Personal notification", 	
	'cp_newsletter:heading:notify:personal:plural' => "Personal notifications", 
	
	'cp_newsletter:heading:notify:mission:singular' => "Career Marketplace notification", 	
	'cp_newsletter:heading:notify:mission:plural' => "Career Marketplace notifications", 
	
	'cp_newsletter:heading:notify:group:singular' => "Group notification", 	
	'cp_newsletter:heading:notify:group:plural' => "Group notifications", 
	
	'cp_newsletter:heading:notify:cp_wire_share:singular' => "Shared content.",  	
	'cp_newsletter:heading:notify:cp_wire_share:plural' => "Shared content.", 
	
	'cp_newsletter:heading:notify:friend_request:singular' => "New colleague request", 
	'cp_newsletter:heading:notify:friend_request:plural' => "New colleague requests", 

	'cp_newsletter:heading:notify:friend_approved:singular' => "%s user approved your colleague request", 	
	'cp_newsletter:heading:notify:friend_approved:plural' => "%s users approved your colleague request", 

	'cp_newsletter:heading:notify:likes:singular' => "Like received on your content", 
	'cp_newsletter:heading:notify:likes:plural' => "Likes received on your content", 

	'cp_newsletter:heading:notify:new_post:singular' => "New item has been posted by your colleague", 
	'cp_newsletter:heading:notify:new_post:plural' => "New items have been posted by your colleagues",
	
	'cp_newsletter:heading:notify:new_post:group:singular' => "New item has been posted",
	'cp_newsletter:heading:notify:new_post:group:plural' => "New items have been posted",

	'cp_newsletter:heading:notify:content_revision:singular' => "Item has been revised", 
	'cp_newsletter:heading:notify:content_revision:plural' => "Items have been revised", 

	'cp_newsletter:heading:notify:cp_mention:singular' => "Person mentioned you.", 	
	'cp_newsletter:heading:notify:cp_mention:plural' => "People mentioned you.", 

	'cp_newsletter:heading:notify:forum_topic:singular' => "New forum topic", 	
	'cp_newsletter:heading:notify:forum_topic:plural' => "New forum topics", 
	
	'cp_newsletter:heading:notify:forum_reply:singular' => "Reply to forum topic", 	
	'cp_newsletter:heading:notify:forum_reply:plural' => "Replies to forum topics", 
	
	'cp_newsletter:heading:notify:response:singular' => "Response to other content subscriptions", 	
	'cp_newsletter:heading:notify:response:plural' => "Responses to other content subscriptions", 
	

	'cp_newsletter:digest:opportunities:date' => "Closing date: ",

	/// (INSTANT EMAIL) EMAIL CONTENT: Normal email notifications
	'cp_newsletter:footer:notification_settings' => "To unsubscribe or manage these messages, please login and visit your <a href='{$site->getURL()}settings/notifications/%s?utm_source=notification_digest&utm_medium=email'> Notification Settings</a>.",
	'cp_newsletter:ending' => "<p>Regards,</p> <p>The GCTools Team</p>",

    'cp_notifications:contact_help_desk'=> "Should you have any concerns, please use the <a href='{$site->getURL()}mod/contactform/?utm_source=notification_digest&utm_medium=email'>Contact us form</a>.",


	/// notification header
	'cp_notification:email_header' => 'This is a system-generated message from GCconnex. Please do not reply to this message',
	'cp_notification:email_header_msg' => "",	

	// add user to group section
	'cp_notify:subject:group_add_user' => "You have been added to the group '%s'",
	'cp_notify:body_group_add:title' => "You have been added to the group '%s'",
	'cp_notify:body_group_add:description' => "You have been added to the group %s: <br/>%s",


	'cp_newsletter:body:view_comment_reply' => 'View comment or discussion reply',
	'cp_new_mission:subject' => "A new opportunity was posted on the Career Marketplace",


	// content edit section
	'cp_notify:subject:edit_content' => "%s '%s' has been updated by %s",
	'cp_notify:body_edit:title' => "This %s has been edited.",
	'cp_notify:body_edit:description' => "<a href='%s'>View or comment</a> <br/>
		You can like, share or subscribe to this content directly in GCconnex",


	// group invite user section
	'cp_notify:subject:group_invite_user' => "%s invited you to join their group %s",
	'cp_notify:body_group_invite:title' => "%s invited you to join the group '%s'",
	'cp_notify:body_group_invite:description' => "You have been invited to join the group '%s'<br/>
		%s <br/>
		Click here to view your invitation: %s",


	// group invite by email section
	'cp_notify:subject:group_invite_email' => "%s invited you to join the group '%s'",
	'cp_notify:subject:group_invite_user_by_email' => "%s invited you to join the group %s",
	'cp_notify:body_group_invite_email:title' => "<a href='%s'>%s</a> invited you to join the <a href='%s'>%s</a> group on GCconnex. <br>",
	'cp_notify:body_group_invite_email:description' => "<a href='%s'>Register now</a> and be automatically added to the group.<br/><br/>

	If you would like to register at a later time using the <a href='https://gcconnex.gc.ca/register'>Registration form</a> on GCconnex, you can join the group by using the following code on your <a href='%s'>group invitations</a> page: %s .<br/><br/>
 
	Already on GCconnex? Your email address may out of date. <a href='https://gcconnex.gc.ca/login'>Login</a> and update your account settings.<br/> ",
	
	'cp_notify:footer:no_user' => 'Learn more about <a href="http://www.gcpedia.gc.ca/wiki/GCTools/GCconnex?utm_source=notification&utm_medium=email">GCconnex</a>, the professional networking and collaborative workspace for the public service.<br/>
	Need help? <a href="https://gcconnex.gc.ca/mod/contactform/?utm_source=notification&utm_medium=email">Contact us</a>.',
	
	'cp_personalized_message' => "<div style='border: 1px solid #047177; padding:5px; margin-bottom:10px;'>Personalized message from %s:<br/><i>%s</i></div>",


	// group mail section
	'cp_notify:subject:group_mail' => "You have received a message titled '%s' from the group '%s'",
	'cp_notify:body_group_mail:title' => "You have received a message titled '%s' from the group '%s'",
	'cp_notify:body_group_mail:description' => "The group owner or administrator has sent the following message: <br/>
		%s",


	// group join request section
	'cp_notify:subject:group_request' => '%s requested to join the group %s',
	'cp_notify:subject:group_join_request' => "%s requested to join your group '%s'",
	'cp_notify:body_group_request:title' => "%s sent you a request to join the group '%s'",
	'cp_notify:body_group_request:description' => "See the request by clicking on this link: %s,
		%s",


	// likes section
	'cp_notify:subject:likes_group' => "%s liked your group '%s'",
	'cp_notify:body_likes_group:title' => "%s liked your group '%s'",
	'cp_notify:body_likes_group:description' => "View your group: %s",

	'cp_notify:subject:likes' => "%s liked your post '%s'",
	'cp_notify:body_likes:title' => "%s liked your post '%s'",

	'cp_notify:subject:likes_wire' => "%s liked your wire post",
	'cp_notify:body_likes_wire:title' => "%s liked your wire post '%s'",
	'cp_notify:body_likes_image_wire:title' => "%s liked your wire post with an image'",

	'cp_notify:subject:likes_comment' => "%s liked your comment from '%s'",
	'cp_notify:body_likes_comment:title' => "%s liked your comment from '%s'", 
	'cp_notify:body_likes_comment:description' => "Your comment from '%s' was liked by %s", 

	'cp_notify:subject:likes_discussion' => "%s liked your reply to '%s'",
	'cp_notify:body_likes_discussion_reply:title' => "%s liked your reply to '%s'", 
	'cp_notify:body_likes_discussion_reply:description' => "Your reply to '%s' was liked by %s",

	'cp_notify:subject:likes_user_update' => "%s liked your your updated avatar or your new colleague connection",
	'cp_notify:body_likes_user_update:title' => "%s liked your your updated avatar or your new colleague connection",
	'cp_notify:body_likes_user_update:description' => "Your recent avatar update or your new colleague connection was liked by %s", 

	'cp_notify:body_likes:description' => "You can view your content by clicking on this link: %s",


	// posted comment section

	'cp_notify:subject:comments' => "A comment was posted in the group %s",
	'cp_notify:subject:comments_discussion' => "A discussion reply was posted in the group %s",

	'cp_notify:subject:comments_user' => "A comment was posted in %s's topic",

	'cp_notify:body_comments:title' => "<a href='%s'>%s</a> posted a new comment on the %s, <a href='%s'>%s</a>",
	'cp_notify:body_comments:title_discussion' => "<a href='%s'>%s</a> posted a new reply on the %s, <a href='%s'>%s</a>",
	
	'cp_notify:body_comments:description' => "<a href='%s'>View or comment</a>",
	'cp_notify:body_comments:description_discussion' => "<a href='%s'>View or reply</a>",

	// colleague notifications (c_cp_notify:*)
	'c_cp_notify:subject:comments' => 'New comment on the %s %s', // New comment on the <blog> <title of blog>
	'c_cp_notify:body_comments:title' => "%s posted a comment on the %s ''",
	'c_cp_notify:body_comments:description' => '',


	// site message section
	'cp_notify:subject:site_message' => "%s sent you a new message '%s'",
	'cp_notify:body_site_msg:title' => "%s sent you a site message titled '%s'",
	'cp_notify:body_site_msg:description_site' => "The content of the message is: <br/>
		%s",
	'cp_notify:body_site_msg:description_email' => "The content of the message is: <br/>
		%s <br/>
		You can view or reply to this by clicking on this link: %s",

	// welcome message
	'cp_notify:body_welcome_msg:title' => '%s sent you a welcome message',
	'cp_notify:body_welcome_msg:description' => "The content of the message is : <br/> 
		%s <br/> ",


	// new content posted section
	'cp_notify_usr:subject:new_content' => "%s posted a new %s with the title '%s'",
	'cp_notify_usr:subject:new_content2' => "%s posted a new %s",
	'cp_notify:subject:new_content' => "A new %s was posted in group %s",

	// +------ cyu - modified : <username> posted a new <item type> titled <item name>
	'cp_notify:body_new_content:title' => "<a href='%s'>%s</a> posted a new %s titled <a href='%s'>%s</a>",
	'cp_notify:body_new_content:title2' => "<a href='%s'>%s</a> posted a new %s in <a href='%s'>%s</a>",
	'cp_notify:body_new_content:title3' => "<a href='%s'>%s</a> posted a new %s message titled",

	

	'cp_notify:body_new_content:description' => "The description of the new posting is: <br/>
		%s <br/>
		<a href='%s'>View or comment</a> <br/>
		You can like, share or subscribe to this content directly in GCconnex",

	'cp_notify:body_new_content:description_discussion' => "The description of the new posting is: <br/>
		%s <br/>
		<a href='%s'>View or reply</a> <br/>
		You can like, share or subscribe to this content directly in GCconnex",

	'cp_notify:body_new_content:no_description_discussion' => "<a href='%s'>View or reply</a> <br/>
		You can like, share or subscribe to this content directly in GCconnex",

	// mentioned section
	'cp_notify:subject:mention' => "%s mentioned you on GCconnex",
	'cp_notify:body_mention:title' => "%s mentioned you in their post or reply titled '%s'",
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
	'cp_notify:subject:approve_friend' => "%s approved your colleague request",
	'cp_notify:body_friend_approve:title' => "%s approved your colleague request",
	'cp_notify:body_friend_approve:description' => "%s approved your colleague request",


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
	'cp_notify:body_invite_new_user:title' => "You have been invited to join GCconnex by %s",
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
		Please click on this link to have the password reset for %s's account: %s",
		

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
	'cp_notify:wireshare:subject' => "%s shared your content on the wire",
	'cp_notify:body_wireshare:title' => "%s shared your content on the wire",

	// (shared your wire post)
	'cp_notify:body:contentshare:description' => "	<p>%s shared your content on the wire.</p> 
													<p><i>%s</i></p> <br/>
													<p><strong>Source:</strong> %s</p> 
													<p><a href='%s'>View or reply</a> on GCconnex.</p>",


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
	'cp_notify:event_request:subject' => "%s want to add %s to his calendar ",
	'cp_notify:body_event_request:title' => "Calendar request",
	'cp_notify:body_event_request:description' => '%s made a request to add %s to his calendar<br><br>To view the request, click here: <a href="%s">Review Request</a>',

	// event calendar (update)
	'cp_notify:event_update:subject' => "The Event %s has been updated",


	// email notification footer text (1 and 2)
	'cp_notify:footer' => "Learn more about <a href='http://www.gcpedia.gc.ca/wiki/GCconnex_User_Help/Manage_Account_Settings/How_Do_I_Change_My_Notifications_Settings%3F?utm_source=notification&utm_medium=email'>GCconnex notifications</a>. ",
	'cp_notify:footer2' => "Need help? <a href='".elgg_get_site_url()."contactform/?utm_source=notification&utm_medium=email'>Contact us</a>.<br/>To unsubscribe from these notifications, login to GCconnex and edit your <a href='%s'>notifications' settings</a>.",


	'cp_notify:quicklinks' => 'Subscription Quick Links',
	'cp_notify:content_name' => 'Content Name',
	'cp_notify:email' => 'Notify by e-mail',
	'cp_notify:site_mail' => 'Notify by site mail',
	'cp_notify:subscribe' => 'Subscribe',


	'cp_notify:no_group_sub' => "You have not subscribed to any Group content",
	'cp_notify:no_sub' => "You have not subscribed to any content",

	"cp_notify:sidebar:no_subscriptions" => "<i>No Subscriptions Available</i>",
	"cp_notify:sidebar:group_title" => "Group you are member of",
	"cp_notify:sidebar:subs_title" => "Personal Subscriptions",
    

    'cp_notify:visitTutorials'=>'To learn more about GCconnex and its features visit the <a href="http://www.gcpedia.gc.ca/wiki/GCconnex_User_Help/See_All">GCconnex User Help</a>.<br/>
	                             Thank you',

	// cyu - new message in place for email content revamp
	'cp_notify:french_follows' => "<i>(Le fran&ccedil;ais suit)</i>",
	'cp_notify:readmore' => "<a href='%s'>Read more</a>",

	
    'cp_notify:emailsForGroup'=>'Select All',


    'cp_notify:notifNewContent'=>'Notify me when new content is created (Discussion, Files, etc.)',
    'cp_notify:notifComments'=>'Notify me when comments are created',
    
    'cp_notify:siteForGroup'=>'Select All',
    'cp_notify:unsubBell'=>'You are subscribed to this content. Click to unsubscribe.',
    'cp_notify:subBell'=>'You are not subscribed to this content. Click to subscribe and receive notifications about this content.',
    'cp_notify:comingSoon'=>'Coming soon!',
   

    'cp_notify:start_subscribe' => 'Start Subscription',
    'cp_notify:stop_subscribe' => 'Stop Subscription',


	'cp_notify:minor_edit' => 'Minor Edit',
	'cp_notify:sidebar:forum_title' => 'Forum and Forum Topics',

	'cp_notify:wirepost_generic_title' => 'Wire post',

	'cp_notify:unsubscribe_all_label' => 'Click here to unsubscribe to all the groups update',

	'cp_notify:no_subscription' => 'There are no subscriptions',

	'not_contact_person' => 'Not the right contact?',
);

add_translation("en", $english);
