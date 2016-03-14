
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
	case 'cp_reply_type': // comments or replies

		$cp_notify_msg_title = "{$cp_comment_author->name} posted a comment or reply to {$cp_topic_title} by {$cp_topic_author->name}";
		$cp_notify_msg_description = "Their Comment or Reply as follows... <br/>
									{$cp_comment_description} <br/>
									You can view or reply to this by clicking on this link: {$cp_topic_url}";
		$cp_notify_msg_footer = "<p>If you do not want to receive this notification, please manage your subscription settings here: - http link -</p>";

		break;
	case 'cp_new_type': // new blogs or other entities

		$cp_notify_msg_title = "{$cp_topic_author->name} has created something new entitled '{$cp_topic_title}'";
		$cp_notify_msg_description = "The description of their new posting as follows... <br/>
									{$cp_topic_description} <br/>
									You can view or reply to this by clicking on this link: {$cp_topic_url}";
		$cp_notify_msg_footer = "<p>If you do not want to receive this notification, please manage your subscription settings here: - http link -</p>";

		break;
	case 'cp_mention_type': // mentions

		$cp_notify_msg_title = "{$cp_topic_author->name} has mentioned your name in their post or reply entitled '{$cp_topic_title}'";
		$cp_notify_msg_description = "The posting you were mentioned in as follows... <br/>
									{$cp_topic_description} <br/>
									You can view or reply to this by clicking on this link: {$cp_topic_url}";
		$cp_notify_msg_footer = "<p>If you do not want to receive this notification, please manage your subscription settings here: - http link -</p>";

		break;
	case 'cp_site_msg_type': // new messages

		$cp_notify_msg_title = "{$cp_topic_author->name} has sent you a site message entitled '{$cp_topic_title}'";
		$cp_notify_msg_description = "The content of the message as follows... <br/>
									{$cp_topic_description} <br/>
									You can view or reply to this by clicking on this link: {$cp_topic_url}";
		$cp_notify_msg_footer = "<p>If you do not want to receive this notification, please manage your subscription settings here: - http link -</p>";

		break;
	case 'cp_closed_grp_req_type':

		$cp_notify_msg_title = "{$cp_req_user->name} has sent you a join request to your group '{$cp_req_group->title}'";
		$cp_notify_msg_description = "Please see the request by clicking on this link - link - ";
		$cp_notify_msg_footer = "<p>This is an automated message, please do not reply</p>";

		break;
	case 'cp_helpdesk_req_type': // helpdesk
		break;

	case 'cp_group_add': // adding user to group

		$cp_notify_msg_title = elgg_echo('cp_notify:body_group_add:title',array('p1','p2'));
		$cp_notify_msg_description = elgg_echo('cp_notify:body_group_add:description',array('p1'));
		$cp_notify_msg_footer = "footer";

		break;

	case 'cp_group_invite':	// inviting user to group
		$cp_notify_msg_title = elgg_echo('cp_notify:body_group_invite:title',array('p1','p2'));
		$cp_notify_msg_description = elgg_echo('cp_notify:body_group_invite:description',array('p1','p2'));
		$cp_notify_msg_footer = "footer";
		break;

	case 'cp_group_invite_email':	// inviting non user to group
		$cp_notify_msg_title = elgg_echo('cp_notify:body_group_invite_email:title');
		$cp_notify_msg_description = elgg_echo('cp_notify:body_group_invite_email:description');
		$cp_notify_msg_footer = "footer";
		break;


	case 'cp_group_mail': // sending out group mail to all members
		$cp_notify_msg_title = elgg_echo('cp_notify:body_group_mail:title', array('p1','p2'));
		$cp_notify_msg_description = elgg_echo('cp_notify:body_group_mail:description');
		$cp_notify_msg_footer = "footer";
		break;


	case 'cp_friend_request': // send friend request
		$cp_notify_msg_footer = "footer";
		break;

	case 'cp_forgot_password': // requesting new password/ password reset
		$cp_notify_msg_footer = "footer";
		break;


	case 'cp_validate_user': // validating new user account
		$cp_notify_msg_footer = "footer";
		break;

	default:
		break;
}





// TODO: anchor link to french follows...

echo <<<___HTML

	<!-- beginning of email template -->
	<table width='100%' bgcolor='#fcfcfc' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td>

				<!-- email header -->
		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #055959'>
		        	This is a system-generated message from GCconnex. Please do not reply to this message / Ce message est genere automatiquement par GCconnex. SVP ne pas y repondre
		        </div>
				

				<!-- GCconnex banner -->
		     	<div width='100%' style='padding: 0 0 0 20px; color:#ffffff; font-family: sans-serif; font-size: 45px; line-height:38px; font-weight: bold; background-color:#047177;'>
		        	<span style='padding: 0 0 0 3px; font-size: 25px; color: #ffffff; font-family: sans-serif;'>GCconnex</span>
		        </div>


		        <!-- email divider -->
		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>






		        <!-- main content of the notification (ENGLISH) -->
		       	<!-- *optional* email message (DO NOT REPLY) -->
		     	<div width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>

	        	<!-- The French Follows... -->
	        	<span style='font-size:12px; font-weight: normal;'><i>(<a href='#gcc_fr_suit'>Le francais suit</a>)</i></span><br/>
        	   
        	   		This is a system-generated message from GCconnex, you're receiving this notification because there has been an update or reply to the content that you have been subscribed to. Please do not reply to this message, if you have any questions please consult the contact us/help page -link- <br/>
					Should you have any questions or concerns please contact our Helpdesk: gcconnex@tbs-sct.gc.ca or learn more about GCconnex and its features here -link-<br/>
                  	Thank you
		        </div>

		     

		        <div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:12px; line-height:22px; border-bottom:2px solid #f2eeed;'>
		        	<!-- TITLE OF CONTENT -->
		        	<h2 style='padding: 0px 0px 15px 0px'>
		        		<strong> {$cp_notify_msg_title} </strong>
		        	</h2>

		        	<!-- BODY OF CONTENT -->
		        	{$cp_notify_msg_description}

		        </div>






		        <!-- main content of the notification (FRENCH) -->
		       	<!-- *optional* email message (DO NOT REPLY) -->
		     	<div id='gcc_fr_suit' name='gcc_fr_suit' width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>
					Ceci est un message généré par le système de GCconnex , vous recevez cette notification, parce qu'il ya eu une mise à jour ou de répondre au contenu que vous avez été abonné. S'il vous plaît ne pas répondre à ce message, si vous avez des questions s'il vous plaît consulter le contactez-nous / page d'aide -link- <br/>
					Si vous avez des questions ou des préoccupations s'il vous plaît contacter notre Helpdesk : . Gcconnex@tbs-sct.gc.ca ou pour plus d'information clickez ici -link- <br/>
                  	Je vous remercie
		        </div>

		       	<div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:12px; line-height:22px; border-bottom:1px solid #f2eeed;'>
		       		<!-- TITLE OF CONTENT -->
		       		<h2 style='padding: 0px 0px 15px 0px'>
		       			<strong> {$cp_notify_msg_title} </strong>
		       		</h2>

		       		<!-- BODY OF CONTENT -->
		       		{$cp_notify_msg_description}

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

___HTML;



