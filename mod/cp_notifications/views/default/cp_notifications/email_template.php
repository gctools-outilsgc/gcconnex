
<?php

$cp_topic_title = $vars['cp_topic_title'];
$cp_msg_title = $vars['cp_msg_title'];
$cp_topic_description = $vars['cp_topic_description'];
$cp_msg_content = $vars['cp_msg_content'];
$cp_topic_author = get_user($vars['cp_topic_author']);
$cp_topic_author = get_user($vars['cp_topic_author']);
$cp_topic_url = $vars['cp_topic_url'];
$cp_msg_url = $vars['cp_msg_url'];

$cp_comment_author = get_user($vars['cp_comment_author']);
$cp_comment_description = $vars['cp_comment_description'];

$cp_notify_footer = "-";

$cp_req_user = $vars['cp_group_req_user'];
$cp_req_group = $vars['cp_group_req_group'];

$msg_type = $vars['cp_msg_type'];

//$cp_notify_msg_footer = elgg_echo('cp_notify:footer2',array(),'fr') .'  '. elgg_echo('cp_notify:footer2',array(),'en');

$current_username = elgg_get_logged_in_user_entity()->username;


// All info for the event_calendar email
$event = $vars['cp_event'];
$name = $vars['cp_topic_author'];
$event_infos = array(
	'title' => $event->title,
	'time_duration' => $vars['cp_event_time'],
	'location' => $vars['location'],
	'room' => $event->room,
	'teleconference' => $event->teleconference,
	'additional' => $event->calendar_additional,
	'fees' => $event->fees,
	'organizer' => $event->organizer,
	'contact' => $event->contact,
	'long_description' => $event->long_description,
	'description' => $event->description,
	'language' => $event->language,
	'link' => $vars['cp_event_invite_url']
);

$description_info_en = '';
$description_info_fr = '';

if (strcmp($vars['type_event'],'CANCEL') == 0) {
	$description_info_en .= '<h3 style ="font-family:sans-serif; color:#ff0000;">This event has been cancel!</h3>';
	$description_info_fr .= '<h3 style ="font-family:sans-serif; color:#ff0000;">Cet événement à été annulé!</h3>';
} elseif (strcmp($vars['type_event'],'UPDATE') == 0){
	$description_info_en .= '<h3 style ="font-family:sans-serif;">This event has been updated</h3>';//NEW
	$description_info_fr .= '<h3 style ="font-family:sans-serif;">Cet événement a été mis à jour.</h3>';//NEW
}else {
	$description_info_en .= '<h3 style ="font-family:sans-serif;">New event in your calendar</h3>';
	$description_info_fr .= '<h3 style ="font-family:sans-serif;">Nouvel événement dans votre calendrier</h3>';
}

//$description_info_en .= '<h3 style ="font-family:sans-serif";>Infos</h3>';
//$description_info_fr .= '<h3 style ="font-family:sans-serif";>Infos</h3>';

foreach ($event_infos as $info_key => $info_val) {
	if (($info_val != '') && (strcmp('link',$info_key) !== 0)) {//remove the double link in the email
		$description_info_en .= elgg_echo("cp_notify:body_event:event_{$info_key}", array($info_val), 'en').'<br/>';
		$description_info_fr .= elgg_echo("cp_notify:body_event:event_{$info_key}", array($info_val), 'fr').'<br/>';

		// cyu - make option so that "add to outlook" can be disabled
		// note: roundrect... snippets are html buttons for email
	}

}

$description_info_en .= /*'<b>'.elgg_echo('cp_notify:body_event:event_add_to_outlook', array(), 'en').'</b>:'.*/
				"<v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' xmlns:w='urn:schemas-microsoft-com:office:word' href='{$info_val}' style='height:40px;v-text-anchor:middle;width:125px;' arcsize='10%' strokecolor='#1e3650' fillcolor='#047177'>
					<w:anchorlock/>
					<center style='color:#ffffff; font-family:sans-serif;font-size:13px;font-weight:bold;'>".elgg_echo('cp_notify:body_event:event_add_to_outlook', array(), 'en')."</center>
				</v:roundrect><br/>";

			$description_info_fr .= /*'<b>'.elgg_echo('cp_notify:body_event:event_add_to_outlook', array(), 'fr').'</b> : '.*/
				"<v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' xmlns:w='urn:schemas-microsoft-com:office:word' href='{$info_val}' style='height:40px;v-text-anchor:middle;width:125px;' arcsize='10%' strokecolor='#1e3650' fillcolor='#047177'>
					<w:anchorlock/>
					<center style='color:#ffffff; font-family:sans-serif;font-size:13px;font-weight:bold;'>".elgg_echo('cp_notify:body_event:event_add_to_outlook', array(), 'fr')."</center>
				</v:roundrect><br/>";
$test = elgg_get_site_url()."/settings/plugins/{$current_username}/cp_notifications";

switch ($msg_type) {

	case 'cp_content_edit':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_edit:title',array($vars['cp_en_entity']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_edit:title',array($vars['cp_fr_entity']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_edit:description',array($vars['cp_content']->getURL()),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_edit:description',array($vars['cp_content']->getURL()),'fr');

		break;


	case 'cp_wire_mention':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_wire_mention:title',array($vars['cp_mention_by']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_wire_mention:title',array($vars['cp_mention_by']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_wire_mention:description',array($vars['cp_mention_by'],$vars['cp_wire_mention_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_wire_mention:description',array($vars['cp_mention_by'],$vars['cp_wire_mention_url']),'fr');

		break;


	case 'cp_friend_approve':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_friend_approve:title',array($vars['cp_approver']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_friend_approve:title',array($vars['cp_approver']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_friend_approve:description',array($vars['cp_approver']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_friend_approve:description',array($vars['cp_approver']),'fr');

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

		break;


	case 'cp_reply_type': // comments or replies

		$entity_m = array(
			'blog' => 'blogue',
			'bookmarks' => 'signet',
			'file' => 'fichier',
			'poll' => 'sondage',
			'event_calendar' => 'nouvel événement',
			'album' => "album d'image",
		);
		$entity_f = array(
			'image' => 'image',
			'idea' => 'idée',
			'page' => 'page',
			'page_top' => 'page',
			'task_top' => 'task',
			'task' => 'task',
			'groupforumtopic' => 'discussion',
		);

		// cyu - update
		$cp_comment_txt = strip_tags($vars['cp_comment']->description);
		//$cp_notify_msg_description_en = elgg_echo('cp_notify:body_comments:description',array($vars['cp_comment']->getURL()),'en');
		//$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_comments:description',array($vars['cp_comment']->getURL()),'fr');

		// GCCON-209: missing description (refer to requirements)
		$cp_notify_msg_description_en = $cp_comment_txt;
		$cp_notify_msg_description_fr = $cp_comment_txt;
		if (strlen($cp_comment_txt) > 200) {
			$cp_comment_txt = substr($cp_comment_txt, 0, 200);
			$cp_notify_msg_description_en = substr($cp_comment_txt, 0, strrpos($cp_comment_txt, ' ')).'... '.elgg_echo('cp_notify:readmore',array($vars['cp_comment']->getURL()),'en');
			$cp_notify_msg_description_fr = substr($cp_comment_txt, 0, strrpos($cp_comment_txt, ' ')).'... '.elgg_echo('cp_notify:readmore',array($vars['cp_comment']->getURL()),'fr');
		}

		if ($vars['cp_topic']->getSubtype() === 'groupforumtopic') {
			$cp_notify_msg_title_en = elgg_echo('cp_notify:body_comments:title_discussion', array($vars['cp_user_comment']->getURL(), $vars['cp_user_comment']->username, $vars['cp_topic_type'], $vars['cp_topic']->getURL(), $vars['cp_topic']->title),'en');
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_comments:title_discussion', array($vars['cp_user_comment']->getURL(), $vars['cp_user_comment']->username, $vars['cp_topic_type'], $vars['cp_topic']->getURL(), $vars['cp_topic']->title),'fr');

			$cp_notify_msg_description_en = elgg_echo('cp_notify:body_comments:description_discussion',array($vars['cp_comment']->getURL()),'en');
			$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_comments:description_discussion',array($vars['cp_comment']->getURL()),'fr');
		} else {
			$cp_notify_msg_title_en = elgg_echo('cp_notify:body_comments:title', array($vars['cp_user_comment']->getURL(), $vars['cp_user_comment']->username, $vars['cp_topic_type'], $vars['cp_topic']->getURL(), $vars['cp_topic']->title),'en');

			if (array_key_exists($vars['cp_topic_type'], $entity_f))
				$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_comments:title_f', array($vars['cp_user_comment']->getURL(), $vars['cp_user_comment']->username, $vars['cp_topic_type'], $vars['cp_topic']->getURL(), $vars['cp_topic']->title),'fr');
			else
				$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_comments:title_m', array($vars['cp_user_comment']->getURL(), $vars['cp_user_comment']->username, $vars['cp_topic_type'], $vars['cp_topic']->getURL(), $vars['cp_topic']->title),'fr');
		}

		break;


	case 'cp_new_type': // new blogs or other entities

		$entity_m = array(
			'blog' => 'blogue',
			'bookmarks' => 'signet',
			'poll' => 'sondage',
			'event_calendar' => 'nouvel événement',
		);
		$entity_f = array(
			'idea' => 'idée',
			'page' => 'page',
			'page_top' => 'page',
			'task_top' => 'task',
			'task' => 'task',
			'groupforumtopic' => 'discussion',
		);

		$entity_m2 = array(
			'file' => 'fichier',
		);
		$entity_f2 = array(
			'image' => 'image',
		);

		$entity_m3 = array(
			'album' => 'album d\'image',
		);

		// cyu - updated as per required (06-15-2016)
		$topic_author = get_entity($vars['cp_topic']->owner_guid);

		if($vars['cp_topic']->title1){
			$vars['cp_topic']->title =$vars['cp_topic']->title1;
		}

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_new_content:title',array($topic_author->getURL(), $topic_author->username, cp_translate_subtype($vars['cp_topic']->getSubtype()), $vars['cp_topic']->getURL(), $vars['cp_topic']->title),'en');
		if (array_key_exists($vars['cp_topic']->getSubtype(),$entity_f))
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_new_content:title_f',array($topic_author->getURL(), $topic_author->username, $entity_f[$vars['cp_topic']->getSubtype()], $vars['cp_topic']->getURL(), $vars['cp_topic']->title),'fr');
		else if (array_key_exists($vars['cp_topic']->getSubtype(),$entity_m))
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_new_content:title_m',array($topic_author->getURL(), $topic_author->username, $entity_m[$vars['cp_topic']->getSubtype()], $vars['cp_topic']->getURL(), $vars['cp_topic']->title),'fr');
		else if (array_key_exists($vars['cp_topic']->getSubtype(),$entity_f2))
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_new_content:title_f2',array($topic_author->getURL(), $topic_author->username, $entity_f2[$vars['cp_topic']->getSubtype()], $vars['cp_topic']->getURL(), $vars['cp_topic']->title),'fr');
		else if (array_key_exists($vars['cp_topic']->getSubtype(),$entity_m3))
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_new_content:title_m3',array($topic_author->getURL(), $topic_author->username, $entity_m3[$vars['cp_topic']->getSubtype()], $vars['cp_topic']->getURL(), $vars['cp_topic']->title),'fr');
		else 
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_new_content:title_m2',array($topic_author->getURL(), $topic_author->username, $entity_m2[$vars['cp_topic']->getSubtype()], $vars['cp_topic']->getURL(), $vars['cp_topic']->title),'fr');

		//$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_new_content:title',array($topic_author->getURL(), $topic_author->username, cp_translate_subtype($vars['cp_topic']->getSubtype()), $vars['cp_topic']->getURL(), $vars['cp_topic']->title),'fr');
		if($vars['cp_topic']->description1){
             $cp_topic_description = strip_tags($vars['cp_topic']->description1);
        }

		$cp_topic_description_en = $cp_topic_description;
		$cp_topic_description_fr = $cp_topic_description;
		if (strlen($cp_topic_description) > 200) {
			$cp_topic_description = substr($cp_topic_description, 0, 200);
			$cp_topic_description_en = substr($cp_topic_description, 0, strrpos($cp_topic_description, ' ')).'... '.elgg_echo('cp_notify:readmore',array($vars['cp_topic']->getURL()),'en');
			$cp_topic_description_fr = substr($cp_topic_description, 0, strrpos($cp_topic_description, ' ')).'... '.elgg_echo('cp_notify:readmore',array($vars['cp_topic']->getURL()),'fr');
		}
		if ($vars['cp_topic']->getSubtype() === 'groupforumtopic' /*|| $vars['cp_topic']->getContainerEntity() instanceof ElggGroup*/) {
			$cp_notify_msg_description_en = elgg_echo('cp_notify:body_new_content:description_discussion',array("<i>{$cp_topic_description_en}</i><br/>", $vars['cp_topic']->getURL()),'en');
			$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_new_content:description_discussion',array("<i>{$cp_topic_description_fr}</i><br/>", $vars['cp_topic']->getURL()),'fr');
		} else if (!$cp_topic_description) {
			$cp_notify_msg_description_en = elgg_echo('cp_notify:body_new_content:no_description_discussion',array($vars['cp_topic']->getURL()),'en');
			$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_new_content:no_description_discussion',array($vars['cp_topic']->getURL()),'fr');
		} else {
			$cp_notify_msg_description_en = elgg_echo('cp_notify:body_new_content:description',array("<i>{$cp_topic_description_en}</i><br/>", $vars['cp_topic']->getURL()),'en');
			$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_new_content:description',array("<i>{$cp_topic_description_fr}</i><br/>", $vars['cp_topic']->getURL()),'fr');
		}

		break;


	case 'cp_mention_type': // mentions
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_mention:title',array($vars['cp_author'],$vars['cp_content']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_mention:title',array($vars['cp_author'],$vars['cp_content']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_mention:description', array($vars['cp_content_desc'],$vars['cp_link']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_mention:description', array($vars['cp_content_desc'],$vars['cp_link']),'fr');

		break;


	case 'cp_site_msg_type': // new messages
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_site_msg:title',array($vars['cp_sender'],$cp_msg_title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_site_msg:title',array($vars['cp_sender'],$cp_msg_title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_site_msg:description',array($cp_msg_content,$cp_msg_url),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_site_msg:description',array($cp_msg_content,$cp_msg_url),'fr');

		break;


	case 'cp_closed_grp_req_type':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_request:title', array($vars['cp_group_req_user']->name,$vars['cp_group_req_group']->name),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_request:title', array($vars['cp_group_req_user']->name,$vars['cp_group_req_group']->name),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_request:description',array($vars['cp_group_req_group']->name,$vars['cp_group_req_group']->getURL()),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_request:description',array($vars['cp_group_req_group']->name,$vars['cp_group_req_group']->getURL()),'fr');

		break;


	case 'cp_helpdesk_req_type': // helpdesk - has its own mailing system....
		break;


	case 'cp_group_add': // adding user to group
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_add:title',array($vars['cp_group']['name']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_add:title',array($vars['cp_group']['name']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_add:description',array($vars['cp_group']['name'],$vars['cp_group']->getURL()),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_add:description',array($vars['cp_group']['name'],$vars['cp_group']->getURL()),'fr');

		break;


	case 'cp_group_invite':	// inviting user to group
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_invite:title',array($vars['cp_group_invite_to']['name'],$vars['cp_group']['name']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_invite:title',array($vars['cp_group_invite_to']['name'],$vars['cp_group']['name']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_invite:description',array($vars['cp_group']['name'],$vars['cp_invitation_msg'],$vars['cp_invitation_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_invite:description',array($vars['cp_group']['name'],$vars['cp_invitation_msg'],$vars['cp_invitation_url']),'fr');

		break;


	case 'cp_group_invite_email':	// inviting non user to group
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_invite_email:title',array(),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_invite_email:title',array(),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_invite_email:description',array($vars['cp_group_invite']->name,$vars['cp_invitation_url'],$vars['cp_invitation_code'],$vars['cp_invitation_msg']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_invite_email:description',array($vars['cp_group_invite']->name,$vars['cp_invitation_url'],$vars['cp_invitation_code'],$vars['cp_invitation_msg']),'fr');
		
		break;


	case 'cp_group_mail': // sending out group mail to all members
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_mail:title', array($vars['cp_group']['name'],$vars['cp_group_subject']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_mail:title', array($vars['cp_group']['name'],$vars['cp_group_subject']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_mail:description',array($vars['cp_group_message']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_mail:description',array($vars['cp_group_message']),'fr');

		break;


	case 'cp_friend_request': // send friend request
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_friend_req:title',array($vars['cp_friend_request_from']['name']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_friend_req:title',array($vars['cp_friend_request_from']['name']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_friend_req:description',array($vars['cp_friend_request_from']['name'],$vars['cp_friend_invitation_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_friend_req:description',array($vars['cp_friend_request_from']['name'],$vars['cp_friend_invitation_url']),'fr');

		break;

	case 'cp_forgot_password': // requesting new password/ password reset
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_forgot_password:title',array($vars['cp_password_request_ip']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_forgot_password:title',array($vars['cp_password_request_ip']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_forgot_password:description',array($vars['cp_password_request_ip'],$vars['cp_password_request_user'],$vars['cp_password_request_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_forgot_password:description',array($vars['cp_password_request_ip'],$vars['cp_password_request_user'],$vars['cp_password_request_url']),'fr');

		break;


	case 'cp_validate_user': // validating new user account
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_validate_user:title',array($vars['cp_validate_user']['email']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_validate_user:title',array($vars['cp_validate_user']['email']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_validate_user:description',array($vars['cp_validate_user']['email'],$vars['cp_validate_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_validate_user:description',array($vars['cp_validate_user']['email'],$vars['cp_validate_url']),'fr');

		break;


	case 'cp_likes_comments':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes_comment:title',array($vars['cp_liked_by'],$vars['cp_comment_from']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes_comment:title',array($vars['cp_liked_by'],$vars['cp_comment_from']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes_comment:description',array($vars['cp_comment_from'],$vars['cp_liked_by']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes_comment:description',array($vars['cp_comment_from'],$vars['cp_liked_by']),'fr');

		break;


	case 'cp_likes_topic_replies': // discussion replies

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes_discussion_reply:title',array($vars['cp_liked_by'],$vars['cp_comment_from']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes_discussion_reply:title',array($vars['cp_liked_by'],$vars['cp_comment_from']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes_discussion_reply:description',array($vars['cp_comment_from'],$vars['cp_liked_by']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes_discussion_reply:description',array($vars['cp_comment_from'],$vars['cp_liked_by']),'fr');

		break;


	case 'cp_likes_user_update':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes_user_update:title',array($vars['cp_liked_by']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes_user_update:title',array($vars['cp_liked_by']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes_user_update:description',array($vars['cp_liked_by']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes_user_update:description',array($vars['cp_liked_by']),'fr');

		break;


	case 'cp_hjtopic':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_hjtopic:title',array($vars['cp_hjtopic_title']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_hjtopic:title',array($vars['cp_hjtopic_title']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_hjtopic:description',array($vars['cp_hjtopic_description'],$vars['cp_hjtopic_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_hjtopic:description',array($vars['cp_hjtopic_description'],$vars['cp_hjtopic_url']),'fr');

		break;


	case 'cp_hjpost':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_hjpost:title',array($vars['cp_hjpost_title']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_hjpost:title',array($vars['cp_hjpost_title']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_hjpost:description',array($vars['cp_hjpost_description'],$vars['cp_hjpost_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_hjpost:description',array($vars['cp_hjpost_description'],$vars['cp_hjpost_url']),'fr');

		break;


	case 'cp_useradd': // username password
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_add_new_user:title',array(),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_add_new_user:title',array(),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_add_new_user:description',array($vars['cp_username'],$vars['cp_password']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_add_new_user:description',array($vars['cp_username'],$vars['cp_password']),'fr');

		break;


	case 'cp_friend_invite': // link
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_invite_new_user:title',array(),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_invite_new_user:title',array(),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_invite_new_user:description',array($vars['cp_join_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_invite_new_user:description',array($vars['cp_join_url']),'fr');

		break;


	case 'cp_event': //send event without ics

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_event:title',array($cp_topic_author->name,$cp_topic_title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_event:title',array($cp_topic_author->name,$cp_topic_title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_event:description',array($description_info_en),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_event:description',array($description_info_fr),'fr');

		break;

	case 'cp_event_request': 
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_event_request:title',array($cp_topic_author->name,$title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_event_request:title',array($cp_topic_author->name,$title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_event_request:description',array($name,$title,$vars['cp_event_invite_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_event_request:description',array($name,$title,$vars['cp_event_invite_url']),'fr');

		break;

	case 'cp_event_ics': // sent event with ics
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_event:title',array($cp_topic_author->name,$cp_topic_title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_event:title',array($cp_topic_author->name,$cp_topic_title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_event:description',array($description_info_en),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_event:description',array($description_info_fr),'fr');

		break;
	

	case 'cp_grp_admin_transfer':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_admin_transfer:title',array($vars['cp_group_name']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_admin_transfer:title',array($vars['cp_group_name']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_admin_transfer:description',array($vars['cp_appointer'],$vars['cp_group_name'],$vars['cp_group_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_admin_transfer:description',array($vars['cp_appointer'],$vars['cp_group_name'],$vars['cp_group_url']),'fr');

		break; 


	case 'cp_add_grp_operator':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_add_grp_operator:title',array($vars['cp_group_name']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_add_grp_operator:title',array($vars['cp_group_name']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_add_grp_operator:description',array($vars['cp_who_made_operator'],$vars['cp_group_name'],$vars['cp_group_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_add_grp_operator:description',array($vars['cp_who_made_operator'],$vars['cp_group_name'],$vars['cp_group_url']),'fr');

		break;


	case 'cp_messageboard':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_messageboard:title',array(),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_messageboard:title',array(),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_messageboard:description',array($vars['cp_writer_name'],$vars['cp_message_content'],$vars['cp_owner_profile']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_messageboard:description',array($vars['cp_writer_name'],$vars['cp_message_content'],$vars['cp_owner_profile']),'fr');

		break;


	case 'cp_wire_share':

		if (!$vars['cp_content']->title) {
			$cp_notify_msg_title_en = elgg_echo('cp_notify:body_wireshare:title2',array($vars['cp_shared_by']->name,cp_translate_subtype($vars['cp_content']->getSubtype())),'en');
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_wireshare:title2',array($vars['cp_shared_by']->name,cp_translate_subtype($vars['cp_content']->getSubtype())),'fr');
		} else {
			$cp_notify_msg_title_en = elgg_echo('cp_notify:body_wireshare:title',array($vars['cp_shared_by']->name,cp_translate_subtype($vars['cp_content']->getSubtype()),$vars['cp_content']->title),'en');
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_wireshare:title',array($vars['cp_shared_by']->name,cp_translate_subtype($vars['cp_content']->getSubtype()),$vars['cp_content']->title),'fr');
		}

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_wireshare:description',array($vars['cp_shared_by']->name,cp_translate_subtype($vars['cp_content']->getSubtype()),$vars['cp_wire_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_wireshare:description',array($vars['cp_shared_by']->name,cp_translate_subtype($vars['cp_content']->getSubtype()),$vars['cp_wire_url']),'fr');

		break;

	default:
		break;
}




if ($msg_type !== 'cp_site_msg_type' && $msg_type !== 'cp_group_mail') {	// if this was a message sent from a user, this is not system generated
	$email_notification_header = elgg_echo('cp_notification:email_header',array(),'en') . ' | ' . elgg_echo('cp_notification:email_header',array(),'fr');
}


$email_notif_footer_msg_fr1 = elgg_echo('cp_notify:contactHelpDesk', array(),'fr');
$email_notif_footer_msg_fr2 = elgg_echo('cp_notify:visitTutorials', array(),'fr');
$email_notif_footer_msg_en1 = elgg_echo('cp_notify:contactHelpDesk', array(),'en');
$email_notif_footer_msg_en2 = elgg_echo('cp_notify:visitTutorials', array(),'en');


$email_notification_footer_en = elgg_echo('cp_notify:footer',array(),'en');
$email_notification_footer_fr = elgg_echo('cp_notify:footer',array(),'fr');
$email_notification_footer_en2 = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/plugins/{$vars['user_name']->username}/cp_notifications"),'en');
$email_notification_footer_fr2 = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/plugins/{$vars['user_name']->username}/cp_notifications"),'fr');

$french_follows = elgg_echo('cp_notify:french_follows',array());
//error_log(">>>>>> {$email_notification_footer_en} / >>>>>>> ".elgg_get_site_url()."/settings/plugins/{$current_username}/cp_notifications");

echo<<<___HTML
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
	        		<span style='font-size:12px; font-weight: normal;'>{$french_follows}</span><br/>
        	   		
		        </div>

		     

		        <div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px; '>
		        	<!-- TITLE OF CONTENT -->
		        	<h4 style='padding: 0px 0px 5px 0px; font-family:sans-serif';>
		        		<strong> {$cp_notify_msg_title_en} </strong>
		        	</h4>

		        	<!-- BODY OF CONTENT -->
		        	
		        	{$cp_notify_msg_description_en}
		        	
		              </div>
                <div style='margin-top:15px; padding: 5px; color: #6d6d6d; border-bottom: 1px solid #ddd;'>
                    <div>{$email_notification_footer_en}{$email_notification_footer_en2}</div>
                </div>
                

<!-- french -->

		        <!-- main content of the notification (FRENCH) -->
		       	<div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px;'>
		       		<!-- TITLE OF CONTENT -->
		       		<h4 style='padding: 0px 0px 5px 0px; font-family:sans-serif;'>
		       			<strong> {$cp_notify_msg_title_fr} </strong>
		       		</h4>

				<!-- BODY OF CONTENT -->
		       		{$cp_notify_msg_description_fr}
                    
		        </div>
                    <div style='margin-top:15px; padding: 5px; color: #6d6d6d;'>
                   <div>{$email_notification_footer_fr}{$email_notification_footer_fr2}</div>
                </div>

		        <!-- email divider -->
		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>



		        <!-- email footer -->
		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 16px; color: #055959'>
		        	-
		        </div>

			</div>
		</div>
	</div>
</body>
</html>

___HTML;






