
<?php

$title = $vars['title'];

$cp_topic_title = $vars['cp_topic_title'];
$cp_topic_description = $vars['cp_topic_description'];
$cp_topic_author = get_user($vars['cp_topic_author']);
$cp_topic_url = $vars['cp_topic_url'];

$cp_comment_author = get_user($vars['cp_comment_author']);
$cp_comment_description = $vars['cp_comment_description'];

$cp_notify_footer = "-";

$cp_req_user = $vars['cp_group_req_user'];
$cp_req_group = $vars['cp_group_req_group'];


$msg_type = $vars['cp_msg_type'];

//$test=elgg_language_key_exists('cp_notify:footer2','fr');

$cp_notify_msg_footer = elgg_echo('cp_notify:footer2',array(),'fr') .' | '. elgg_echo('cp_notify:footer2',array(),'en');

switch ($msg_type) {
	case 'cp_likes_type': // likes
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes:title',array($vars['cp_liked_by'],$cp_topic_title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes:title',array($vars['cp_liked_by'],$cp_topic_title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes:description',array($cp_topic_url),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes:description',array($cp_topic_url),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;

	case 'cp_reply_type': // comments or replies

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_comments:title', array($cp_comment_author->name,$cp_topic_title,$cp_topic_author->name),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_comments:title', array($cp_comment_author->name,$cp_topic_title,$cp_topic_author->name),'fr');
		
		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_comments:description',array($cp_comment_description,$cp_topic_url),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_comments:description',array($cp_comment_description,$cp_topic_url),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'),'fr');
		break;

	case 'cp_new_type': // new blogs or other entities

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_new_content:title',array($cp_topic_author->name,$cp_topic_title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_new_content:title',array($cp_topic_author->name,$cp_topic_title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_new_content:description',array($cp_topic_description,$cp_topic_url),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_new_content:description',array($cp_topic_description,$cp_topic_url),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'),'fr');
		break;

	case 'cp_mention_type': // mentions

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_mention:title',array($cp_topic_author->name,$cp_topic_title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_mention:title',array($cp_topic_author->name,$cp_topic_title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_mention:description', array($cp_topic_description,$cp_topic_url),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_mention:description', array($cp_topic_description,$cp_topic_url),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'),'fr');
		break;

	case 'cp_site_msg_type': // new messages

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_site_msg:title',array($cp_topic_author->name,$cp_topic_title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_site_msg:title',array($cp_topic_author->name,$cp_topic_title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_site_msg:description',array($cp_topic_description,$cp_topic_url),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_site_msg:description',array($cp_topic_description,$cp_topic_url),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'),'fr');
		
		break;
	case 'cp_closed_grp_req_type':

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_request:title', array($cp_req_user->name,$cp_req_group->title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_request:title', array($cp_req_user->name,$cp_req_group->title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_request:description',array(),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_request:description',array(),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;

	case 'cp_helpdesk_req_type': // helpdesk - has its own mailing system....
		break;

	case 'cp_group_add': // adding user to group

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_add:title',array('p1','p2'),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_add:title',array('p1','p2'),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_add:description',array('p1'),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_add:description',array('p1'),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'fr');
		break;

	case 'cp_group_invite':	// inviting user to group

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_invite:title',array($vars['cp_group_invite_from']['name'],$vars['cp_group']['name']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_invite:title',array($vars['cp_group_invite_from']['name'],$vars['cp_group']['name']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_invite:description',array($vars['cp_group']['name'],$vars['cp_invitation_msg'],$vars['cp_invitation_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_invite:description',array($vars['cp_group']['name'],$vars['cp_invitation_msg'],$vars['cp_invitation_url']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;

	case 'cp_group_invite_email':	// inviting non user to group

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_invite_email:title',array(),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_invite_email:title',array(),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_invite_email:description',array(),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_invite_email:description',array(),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_group_mail': // sending out group mail to all members
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_mail:title', array($vars['cp_group']['name'],$vars['cp_group_subject']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_mail:title', array($vars['cp_group']['name'],$vars['cp_group_subject']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_mail:description',array($vars['cp_group_message']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_mail:description',array($vars['cp_group_message']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_friend_request': // send friend request
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_friend_req:title',array($vars['cp_friend_request_from']['name']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_friend_req:title',array($vars['cp_friend_request_from']['name']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_friend_req:description',array($vars['cp_friend_request_from']['name'],$vars['cp_friend_invitation_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_friend_req:description',array($vars['cp_friend_request_from']['name'],$vars['cp_friend_invitation_url']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;

	case 'cp_forgot_password': // requesting new password/ password reset
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_forgot_password:title',array(),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_forgot_password:title',array(),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_forgot_password:description',array(),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_forgot_password:description',array(),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_validate_user': // validating new user account
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_validate_user:title',array($vars['cp_validate_user']['email']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_validate_user:title',array($vars['cp_validate_user']['email']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_validate_user:description',array($vars['cp_validate_user']['email'],$vars['cp_validate_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_validate_user:description',array($vars['cp_validate_user']['email'],$vars['cp_validate_url']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;

	default:
		break;
}





$email_notification_header = elgg_echo('cp_notification:email_header',array(),'en') . ' / ' . elgg_echo('cp_notification:email_header',array(),'fr');
$french_follows = '<a href="#gcc_fr_suit">Le francais suit</a>';

$email_notification_header_msg_en = elgg_echo('cp_notification:email_header_msg', array('https://gcconnex.gc.ca/mod/contactform/','http://www.gcpedia.gc.ca/wiki/GC2.0_Tools_Help_Centre/GCconnex'),'en');
$email_notification_header_msg_fr = elgg_echo('cp_notification:email_header_msg', array('https://gcconnex.gc.ca/mod/contactform/','http://www.gcpedia.gc.ca/wiki/Centre_d%27aide_pour_les_outils_GC2.0/GCconnex'),'fr');


echo <<<___HTML
<html>
<body>
	<!-- beginning of email template -->
	<table width='100%' bgcolor='#fcfcfc' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td>

				<!-- email header -->
		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #055959'>
		        	{$email_notification_header}
		        </div>
				

				<!-- GCconnex banner -->
		     	<div width='100%' style='padding: 0 0 0 20px; color:#ffffff; font-family: sans-serif; font-size: 45px; line-height:38px; font-weight: bold; background-color:#047177;'>
		        	<span style='padding: 0 0 0 3px; font-size: 25px; color: #ffffff; font-family: sans-serif;'>GCconnex</span>
		        </div>


		        <!-- email divider -->
		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>

<!-- english -->


		        <!-- main content of the notification (ENGLISH) -->
		       	<!-- *optional* email message (DO NOT REPLY) -->
		     	<div width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>

	        		<!-- The French Follows... -->
	        		<span style='font-size:12px; font-weight: normal;'><i>({$french_follows})</i></span><br/>
        	   		{$email_notification_header_msg_en}
		        </div>

		     

		        <div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:12px; line-height:22px; border-bottom:2px solid #f2eeed;'>
		        	<!-- TITLE OF CONTENT -->
		        	<h2 style='padding: 0px 0px 15px 0px'>
		        		<strong> {$cp_notify_msg_title_en} </strong>
		        	</h2>

		        	<!-- BODY OF CONTENT -->
		        	{$cp_notify_msg_description_en}

		        </div>


<!-- french -->

		        <!-- main content of the notification (FRENCH) -->
		       	<!-- *optional* email message (DO NOT REPLY) -->
		     	<div id="gcc_fr_suit" name="gcc_fr_suit" width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>
		     		{$email_notification_header_msg_fr}
		        </div>

		       	<div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:12px; line-height:22px; border-bottom:1px solid #f2eeed;'>
		       		<!-- TITLE OF CONTENT -->
		       		<h2 style='padding: 0px 0px 15px 0px'>
		       			<strong> {$cp_notify_msg_title_fr} </strong>
		       		</h2>

		       		<!-- BODY OF CONTENT -->
		       		{$cp_notify_msg_description_fr}

		        </div>


		        <!-- email divider -->
		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>

		        <!-- email footer -->
		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #055959'>
		        	{$cp_notify_msg_footer}
		        </div>

			</td>
		</tr>
	</table>
</body>
</html>
___HTML;



