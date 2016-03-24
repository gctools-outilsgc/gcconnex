
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
switch ($msg_type) {
	case 'cp_likes_type': // likes
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes:title_en',array($vars['cp_liked_by'],$cp_topic_title));
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes:title_fr',array($vars['cp_liked_by'],$cp_topic_title));

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes:description_en',array($cp_topic_url));
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes:description_fr',array($cp_topic_url));

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2_en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2_fr');
		break;

	case 'cp_reply_type': // comments or replies

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_comments:title_en', array($cp_comment_author->name,$cp_topic_title,$cp_topic_author->name));
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_comments:title_fr', array($cp_comment_author->name,$cp_topic_title,$cp_topic_author->name));
		
		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_comments:description_en',array($cp_comment_description,$cp_topic_url));
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_comments:description_fr',array($cp_comment_description,$cp_topic_url));

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer_en',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'));
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer_fr',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'));
		break;

	case 'cp_new_type': // new blogs or other entities

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_new_content:title_en',array($cp_topic_author->name,$cp_topic_title));
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_new_content:title_fr',array($cp_topic_author->name,$cp_topic_title));

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_new_content:description_en',array($cp_topic_description,$cp_topic_url));
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_new_content:description_fr',array($cp_topic_description,$cp_topic_url));

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer_en',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'));
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer_fr',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'));
		break;

	case 'cp_mention_type': // mentions

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_mention:title_en',array($cp_topic_author->name,$cp_topic_title));
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_mention:title_fr',array($cp_topic_author->name,$cp_topic_title));

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_mention:description_en', array($cp_topic_description,$cp_topic_url));
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_mention:description_fr', array($cp_topic_description,$cp_topic_url));

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer_en',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'));
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer_fr',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'));
		break;

	case 'cp_site_msg_type': // new messages

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_site_msg:title_en',array($cp_topic_author->name,$cp_topic_title));
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_site_msg:title_fr',array($cp_topic_author->name,$cp_topic_title));

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_site_msg:description_en',array($cp_topic_description,$cp_topic_url));
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_site_msg:description_fr',array($cp_topic_description,$cp_topic_url));

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer_en',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'));
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer_fr',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'));
		
		break;
	case 'cp_closed_grp_req_type':

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_request:title_en', array($cp_req_user->name,$cp_req_group->title));
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_request:title_fr', array($cp_req_user->name,$cp_req_group->title));

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_request:description_en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_request:description_fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2_en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2_fr');
		break;

	case 'cp_helpdesk_req_type': // helpdesk - has its own mailing system....
		break;

	case 'cp_group_add': // adding user to group

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_add:title_en',array('p1','p2'));
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_add:title_fr',array('p1','p2'));

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_add:description_en',array('p1'));
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_add:description_fr',array('p1'));

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2_en');
		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2_fr');
		break;

	case 'cp_group_invite':	// inviting user to group

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_invite:title_en',array($vars['cp_group_invite_from']['name'],$vars['cp_group']['name']));
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_invite:title_fr',array($vars['cp_group_invite_from']['name'],$vars['cp_group']['name']));

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_invite:description_en',array($vars['cp_group']['name'],$vars['cp_invitation_msg'],$vars['cp_invitation_url']));
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_invite:description_fr',array($vars['cp_group']['name'],$vars['cp_invitation_msg'],$vars['cp_invitation_url']));

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2_en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2_fr');
		break;

	case 'cp_group_invite_email':	// inviting non user to group

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_invite_email:title_en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_invite_email:title_fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_invite_email:description_en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_invite_email:description_fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2_en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2_fr');
		break;


	case 'cp_group_mail': // sending out group mail to all members
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_mail:title_en', array($vars['cp_group']['name'],$vars['cp_group_subject']));
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_mail:title_fr', array($vars['cp_group']['name'],$vars['cp_group_subject']));

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_mail:description_en',array($vars['cp_group_message']));
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_mail:description_fr',array($vars['cp_group_message']));

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2_en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2_fr');
		break;


	case 'cp_friend_request': // send friend request
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_friend_req:title_en',array($vars['cp_friend_request_from']['name']));
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_friend_req:title_fr',array($vars['cp_friend_request_from']['name']));

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_friend_req:description_en',array($vars['cp_friend_request_from']['name'],$vars['cp_friend_invitation_url']));
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_friend_req:description_fr',array($vars['cp_friend_request_from']['name'],$vars['cp_friend_invitation_url']));

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2_en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2_fr');
		break;

	case 'cp_forgot_password': // requesting new password/ password reset
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_forgot_password:title_en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_forgot_password:title_fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_forgot_password:description_en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_forgot_password:description_fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2_en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2_fr');
		break;


	case 'cp_validate_user': // validating new user account
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_validate_user:title_en',array($vars['cp_validate_user']['email']));
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_validate_user:title_en',array($vars['cp_validate_user']['email']));

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_validate_user:description_en',array($vars['cp_validate_user']['email'],$vars['cp_validate_url']));
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_validate_user:description_en',array($vars['cp_validate_user']['email'],$vars['cp_validate_url']));

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2_en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2_fr');
		break;

	default:
		break;
}





$email_notification_header = elgg_echo('cp_notification:email_header_en') . ' / ' . elgg_echo('cp_notification:email_header_fr');
$french_follows = '<a href="#gcc_fr_suit">Le francais suit</a>';

$email_notification_header_msg_en = elgg_echo('cp_notification:email_header_msg_en');
$email_notification_header_msg_fr = elgg_echo('cp_notification:email_header_msg_fr');


echo <<<___HTML

	<!-- beginning of email template -->
	<table width='100%' bgcolor='#fcfcfc' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td>

				<!-- email header -->
		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #055959'>
		        	{$email_notification_header_en} / {$email_notification_header_fr}
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
		        	{$cp_notify_msg_footer_en} / {$cp_notify_msg_footer_fr}
		        </div>

			</td>
		</tr>
	</table>

___HTML;



