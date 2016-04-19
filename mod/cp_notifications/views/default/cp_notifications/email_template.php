
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

$cp_notify_msg_footer = elgg_echo('cp_notify:footer2',array(),'fr') .'  '. elgg_echo('cp_notify:footer2',array(),'en');

$event = $vars['event'];
$startdate = $vars['startdate'];
$enddate = $vars['enddate'];
$title = $event->title;
$location =$event->venue;
$teleconference = $event->teleconference;
$additional = $event->additional;
$fees = $event->fees;
$organiser = $event->organiser;
$contact = $event->contact;
$long_description = $event->long_description;
$description = $event->description;
$language = $event->language;
$informationEn = '<h3 style ="font-family:sans-serif";>Infos</h3>';
$informationFr = '<h3 style ="font-family:sans-serif";>Infos</h3>';

if($title){
	$informationEn .= '<b>Title:</b> '.$title.'<br/>';
	$informationFr .= '<b>Titre:</b> '.$title.'<br/>';
}if($startdate){
	$informationEn .= '<b>When:</b> '.$startdate.' - '.$enddate.'<br/>';
	$informationFr .= '<b>Quand:</b> '.$startdate.' - '.$enddate.'<br/>';
}if($location){
	$informationEn .= '<b>Venue:</b> '.$location.'<br/>';
	$informationFr .= '<b>Lieu:</b> '.$location.'<br/>';
}if($contact){
	$informationEn .= '<b>Contact:</b> '.$contact.'<br/>';
	$informationFr .= '<b>Personne ressource:</b> '.$contact.'<br/>';
}if($fees){
	$informationEn .= '<b>Fees:</b> '.$fees.'<br/>';
	$informationFr .= '<b>Prix:</b> '.$fees.'<br/>';
}if($teleconference){
	$informationEn .= '<b>Online meeting and teleconference:</b> '.$teleconference.'<br/>';
	$informationFr .= '<b>Réunion en ligne et téléconférence:</b> '.$teleconference.'<br/>';
}if($additional){
	$informationEn .= '<b>Additional information:</b> '.$additional.'<br/>';
	$informationFr .= '<b>Information additionelle:</b> '.$additional.'<br/>';
}if($organiser){
	$informationEn .= '<b>Organiser:</b> '.$organiser.'<br/>';
	$informationFr .= '<b>Organisateur:</b> '.$organiser.'<br/>';
}if($description){
	$informationEn .= '<b>Description:</b> '.$description.'<br/>';
	$informationFr .= '<b>Description:</b> '.$description.'<br/>';
}if($language){
	$informationEn .= '<b>Event language:</b> '.$language.'<br/>';
	$informationFr .= '<b>Langue de l\'événement:</b> '.$language.'<br/>';
}if($long_description){
	$informationEn .= '<b>Long description:</b> '.$long_description.'<br/>';
	$informationFr .= '<b>Longue description:</b> '.$long_description.'<br/>';
}

switch ($msg_type) {

	case 'cp_wire_mention':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_wire_mention:title',array($vars['cp_mention_by']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_wire_mention:title',array($vars['cp_mention_by']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_wire_mention:description',array($vars['cp_mention_by'],$vars['cp_view_mention']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_wire_mention:description',array($vars['cp_mention_by'],$vars['cp_view_mention']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_friend_approve':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_friend_approve:title',array($vars['cp_approver']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_friend_approve:title',array($vars['cp_approver']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_friend_approve:description',array($vars['cp_approver']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_friend_approve:description',array($vars['cp_approver']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_likes_type': // likes
		
		if ($vars['cp_subtype'] === 'thewire') { 
			$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes_wire:title',array($vars['cp_liked_by'],$vars['cp_description']),'en');
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes_wire:title',array($vars['cp_liked_by'],$vars['cp_description']),'fr');
		} else { 
			$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes:title',array($vars['cp_liked_by'],$vars['cp_comment_from']),'en');
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes:title',array($vars['cp_liked_by'],$vars['cp_comment_from']),'fr');
		}

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes:description',array($vars['cp_content_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes:description',array($vars['cp_content_url']),'fr');

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
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_site_msg:title',array($vars['cp_topic_author'],$cp_topic_title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_site_msg:title',array($vars['cp_topic_author'],$cp_topic_title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_site_msg:description',array($cp_topic_description,$cp_topic_url),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_site_msg:description',array($cp_topic_description,$cp_topic_url),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'),'fr');		
		break;


	case 'cp_closed_grp_req_type':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_request:title', array($vars['cp_group_req_user']->name,$vars['cp_group_req_group']->name),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_request:title', array($vars['cp_group_req_user']->name,$vars['cp_group_req_group']->name),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_request:description',array($vars['cp_group_req_group']->name,$vars['cp_group_req_group']->getURL()),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_request:description',array($vars['cp_group_req_group']->name,$vars['cp_group_req_group']->getURL()),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_helpdesk_req_type': // helpdesk - has its own mailing system....
		break;


	case 'cp_group_add': // adding user to group
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_add:title',array($vars['cp_group']['name']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_add:title',array($vars['cp_group']['name']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_add:description',array($vars['cp_group']['name']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_add:description',array($vars['cp_group']['name']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_group_invite':	// inviting user to group
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_invite:title',array($vars['cp_group_invite_to']['name'],$vars['cp_group']['name']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_invite:title',array($vars['cp_group_invite_to']['name'],$vars['cp_group']['name']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_invite:description',array($vars['cp_group']['name'],$vars['cp_invitation_msg'],$vars['cp_invitation_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_invite:description',array($vars['cp_group']['name'],$vars['cp_invitation_msg'],$vars['cp_invitation_url']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_group_invite_email':	// inviting non user to group
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_invite_email:title',array(),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_invite_email:title',array(),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_invite_email:description',array($vars['cp_group_invite']->name,$vars['cp_invitation_url'],$vars['cp_invitation_code'],$vars['cp_invitation_msg']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_invite_email:description',array($vars['cp_group_invite']->name,$vars['cp_invitation_url'],$vars['cp_invitation_code'],$vars['cp_invitation_msg']),'fr');
		
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
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_forgot_password:title',array($vars['cp_password_request_ip']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_forgot_password:title',array($vars['cp_password_request_ip']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_forgot_password:description',array($vars['cp_password_request_ip'],$vars['cp_password_request_user'],$vars['cp_password_request_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_forgot_password:description',array($vars['cp_password_request_ip'],$vars['cp_password_request_user'],$vars['cp_password_request_url']),'fr');

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


	case 'cp_likes_comments':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes_comment:title',array($vars['cp_liked_by'],$vars['cp_comment_from']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes_comment:title',array($vars['cp_liked_by'],$vars['cp_comment_from']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes_comment:description',array($vars['cp_comment_from'],$vars['cp_liked_by']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes_comment:description',array($vars['cp_comment_from'],$vars['cp_liked_by']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_likes_topic_replies': // discussion replies
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes_discussion_reply:title',array($vars['cp_liked_by'],$vars['cp_comment_from']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes_discussion_reply:title',array($vars['cp_liked_by'],$vars['cp_comment_from']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes_discussion_reply:description',array($vars['cp_comment_from'],$vars['cp_liked_by']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes_discussion_reply:description',array($vars['cp_comment_from'],$vars['cp_liked_by']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_likes_user_update':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes_user_update:title',array($vars['cp_liked_by']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes_user_update:title',array($vars['cp_liked_by']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes_user_update:description',array($vars['cp_liked_by']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes_user_update:description',array($vars['cp_liked_by']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_hjtopic':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_hjtopic:title',array($vars['cp_topic_author'],$vars['cp_hjtopic_title']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_hjtopic:title',array($vars['cp_topic_author'],$vars['cp_hjtopic_title']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_hjtopic:description',array($vars['cp_hjtopic_description'],$vars['cp_hjtopic_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_hjtopic:description',array($vars['cp_hjtopic_description'],$vars['cp_hjtopic_url']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_hjpost':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_hjpost:title',array($vars['cp_topic_author'],$vars['cp_topic_title']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_hjpost:title',array($vars['cp_topic_author'],$vars['cp_topic_title']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_hjpost:description',array($vars['cp_hjpost_description'],$vars['cp_hjpost_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_hjpost:description',array($vars['cp_hjpost_description'],$vars['cp_hjpost_url']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_useradd': // username password
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_add_new_user:title',array(),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_add_new_user:title',array(),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_add_new_user:description',array($vars['cp_username'],$vars['cp_password']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_add_new_user:description',array($vars['cp_username'],$vars['cp_password']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_friend_invite': // link
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_invite_new_user:title',array(),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_invite_new_user:title',array(),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_invite_new_user:description',array($vars['cp_join_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_invite_new_user:description',array($vars['cp_join_url']),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer2',array(),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer2',array(),'fr');
		break;


	case 'cp_event': // validating new user account
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_event:title',array($cp_topic_author->name,$cp_topic_title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_event:title',array($cp_topic_author->name,$cp_topic_title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_event:description',array($cp_topic_description,$informationEn),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_event:description',array($cp_topic_description,$informationFr),'fr');

		$cp_notify_msg_footer_en = elgg_echo('cp_notify:footer',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'),'en');
		$cp_notify_msg_footer_fr = elgg_echo('cp_notify:footer',array(elgg_get_site_url().'/settings/plugins/admin/cp_notifications'),'fr');
		break;

	default:
		break;
}




if ($msg_type !== 'cp_site_msg_type' && $msg_type !== 'cp_group_mail') {
	error_log("this is header: {$msg_type}");
	$email_notification_header = elgg_echo('cp_notification:email_header',array(),'en') . ' | ' . elgg_echo('cp_notification:email_header',array(),'fr');
}
$french_follows = '<a href="#gcc_fr_suit">Le francais suit</a>';

// this is not used anywhere
//$email_notification_header_msg_en = elgg_echo('cp_notification:email_header_msg', array('https://gcconnex.gc.ca/mod/contactform/','http://www.gcpedia.gc.ca/wiki/GC2.0_Tools_Help_Centre/GCconnex'),'en');
//$email_notification_header_msg_fr = elgg_echo('cp_notification:email_header_msg', array('https://gcconnex.gc.ca/mod/contactform/','http://www.gcpedia.gc.ca/wiki/Centre_d%27aide_pour_les_outils_GC2.0/GCconnex'),'fr');

$email_notif_footer_msg_fr1 = elgg_echo('cp_notify:contactHelpDesk', array(),'fr');
$email_notif_footer_msg_fr2 = elgg_echo('cp_notify:visitTutorials', array(),'fr');
$email_notif_footer_msg_en1 = elgg_echo('cp_notify:contactHelpDesk', array(),'en');
$email_notif_footer_msg_en2 = elgg_echo('cp_notify:visitTutorials', array(),'en');


echo <<<___HTML
<html>
<body>
	<!-- beginning of email template -->
	<div width='100%' bgcolor='#fcfcfc'>
		<div>
			<div>

				<!-- email header -->
		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #055959'>
		        	{$email_notification_header}
		        </div>
				

				<!-- GCconnex banner -->
		     	<div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#047177;'>
		        	<span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'>GCconnex</span>
		        </div>


		        <!-- email divider -->
		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>

<!-- english -->


		        <!-- main content of the notification (ENGLISH) -->
		       	<!-- *optional* email message (DO NOT REPLY) -->
		     	<div width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>

	        		<!-- The French Follows... -->
	        		<span style='font-size:12px; font-weight: normal;'><i>({$french_follows})</i></span><br/>
        	   		
		        </div>

		     

		        <div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px; '>
		        	<!-- TITLE OF CONTENT -->
		        	<h2 style='padding: 0px 0px 15px 0px; font-family:sans-serif';>
		        		<strong> {$cp_notify_msg_title_en} </strong>
		        	</h2>

		        	<!-- BODY OF CONTENT -->
		        	
		        	{$cp_notify_msg_description_en}
		        	
		        </div>
                <div style='margin-top:15px; padding: 5px; color: #6d6d6d; border-bottom: 1px solid #ddd;'>
                    <div>{$email_notif_footer_msg_en1}</div>
                    <div>{$email_notif_footer_msg_en2}</div>
                </div>
                

<!-- french -->

		        <!-- main content of the notification (FRENCH) -->
		       	<!-- *optional* email message (DO NOT REPLY) -->
		     	<div id="gcc_fr_suit" name="gcc_fr_suit" width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>
		     		
		        </div>

		       	<div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px;'>
		       		<!-- TITLE OF CONTENT -->
		       		<h2 style='padding: 0px 0px 15px 0px; font-family:sans-serif;'>
		       			<strong> {$cp_notify_msg_title_fr} </strong>
		       		</h2>

		       		<!-- BODY OF CONTENT -->
		       		{$cp_notify_msg_description_fr}
                    
		        </div>
                    <div style='margin-top:15px; padding: 5px; color: #6d6d6d;'>
                    <div>{$email_notif_footer_msg_fr1}</div>
                    <div>{$email_notif_footer_msg_fr2}</div>
                   
                    </div>

		        <!-- email divider -->
		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>

		        <!-- email footer -->
		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 16px; color: #055959'>
		        	{$cp_notify_msg_footer}
		        </div>

			</div>
		</div>
	</div>
</body>
</html>

___HTML;






