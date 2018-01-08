
<?php

$site = elgg_get_site_entity();

$cp_topic_title = $vars['cp_topic_title'];
$cp_msg_title = $vars['cp_msg_title'];
$cp_topic_description = $vars['cp_topic_description'];
$cp_topic_description_discussion = $vars['cp_topic_description_discussion'];
$cp_topic_description_discussion2 = $vars['cp_topic_description_discussion2'];

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
	$description_info_en .= '<h3 style ="font-family:sans-serif;">This event has been updated</h3>';
	$description_info_fr .= '<h3 style ="font-family:sans-serif;">Cet événement a été mis à jour.</h3>';
}else {
	$description_info_en .= '<h3 style ="font-family:sans-serif;">New event in your calendar</h3>';
	$description_info_fr .= '<h3 style ="font-family:sans-serif;">Nouvel événement dans votre calendrier</h3>';
}


foreach ($event_infos as $info_key => $info_val) {
	if (($info_val != '') && (strcmp('link',$info_key) !== 0)) {//remove the double link in the email
		$description_info_en .= elgg_echo("cp_notify:body_event:event_{$info_key}", array($info_val), 'en').'<br/>';
		$description_info_fr .= elgg_echo("cp_notify:body_event:event_{$info_key}", array($info_val), 'fr').'<br/>';
	}

}

$description_info_en .= 
				"<v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' xmlns:w='urn:schemas-microsoft-com:office:word' href='{$info_val}' style='height:40px;v-text-anchor:middle;width:125px;' arcsize='10%' strokecolor='#1e3650' fillcolor='#047177'>
					<w:anchorlock/>
					<center style='color:#ffffff; font-family:sans-serif;font-size:13px;font-weight:bold;'>".elgg_echo('cp_notify:body_event:event_add_to_outlook', array(), 'en')."</center>
				</v:roundrect><br/>";

			$description_info_fr .= /*'<b>'.elgg_echo('cp_notify:body_event:event_add_to_outlook', array(), 'fr').'</b> : '.*/
				"<v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' xmlns:w='urn:schemas-microsoft-com:office:word' href='{$info_val}' style='height:40px;v-text-anchor:middle;width:125px;' arcsize='10%' strokecolor='#1e3650' fillcolor='#047177'>
					<w:anchorlock/>
					<center style='color:#ffffff; font-family:sans-serif;font-size:13px;font-weight:bold;'>".elgg_echo('cp_notify:body_event:event_add_to_outlook', array(), 'fr')."</center>
				</v:roundrect><br/>";

switch ($msg_type) {

	case 'cp_wire_image':
		$wire_entity = $vars['wire_entity'];
		$wire_image = thewire_image_get_attachments($wire_entity->getGUID());
		if ($wire_image){//if image in the wire notification
			$cp_notify_msg_title_en = elgg_echo('cp_notifications:mail_body:subtype:thewireImage', array($vars['author']->name), 'en');
			$cp_notify_msg_title_fr = elgg_echo('cp_notifications:mail_body:subtype:thewireImage', array($vars['author']->name), 'fr');
			
			$cp_notify_msg_description_en = "<p><a href='{$vars['wire_entity']->getURL()}'>{$wire_entity->description}</a></p>";
			$cp_notify_msg_description_fr = "<p><a href='{$vars['wire_entity']->getURL()}'>{$wire_entity->description}</a></p>";
	
			$cp_notify_msg_description_en .= "<a href='{$vars['wire_entity']->getURL()}'><img  width=\"320\" src='".elgg_get_site_url().'thewire_image/download/'.$wire_image->getGUID().'/'.$wire_image->original_filename."'/> </a>";
			$cp_notify_msg_description_fr .= "<a href='{$vars['wire_entity']->getURL()}'><img  width=\"320\" src='".elgg_get_site_url().'thewire_image/download/'.$wire_image->getGUID().'/'.$wire_image->original_filename."'/> </a>";
		}else{//if no image in the wire notification
			$cp_notify_msg_title_en = elgg_echo('cp_notifications:mail_body:subtype:thewire', array($vars['author']->name, 'Wire'), 'en');
			$cp_notify_msg_title_fr = elgg_echo('cp_notifications:mail_body:subtype:thewire', array($vars['author']->name, 'Fil'), 'fr');

			$cp_notify_msg_description_en = "<p><a href='{$vars['wire_entity']->getURL()}'>{$wire_entity->description}</a></p>";
			$cp_notify_msg_description_fr = "<p><a href='{$vars['wire_entity']->getURL()}'>{$wire_entity->description}</a></p>";
		}
		
		break;

	case 'cp_content_edit': // blog vs page (edits)
		$cp_notify_msg_title_fr = (strcmp($vars['cp_en_entity'],'blog') === 0) ? elgg_echo('cp_notify:body_edit:title:m',array($vars['cp_fr_entity']),'fr') : elgg_echo('cp_notify:body_edit:title:f',array($vars['cp_fr_entity']),'fr');
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_edit:title',array($vars['cp_en_entity']),'en');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_edit:description',array($vars['cp_content']->getURL().'?utm_source=notification&utm_medium=email'),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_edit:description',array($vars['cp_content']->getURL().'?utm_source=notification&utm_medium=email'),'fr');

		break;


	case 'cp_wire_mention':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_wire_mention:title',array($vars['cp_mention_by']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_wire_mention:title',array($vars['cp_mention_by']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_wire_mention:description',array($vars['cp_mention_by'],$vars['cp_wire_mention_url'].'?utm_source=notification&utm_medium=email'),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_wire_mention:description',array($vars['cp_mention_by'],$vars['cp_wire_mention_url'].'?utm_source=notification&utm_medium=email'),'fr');

		break;


	case 'cp_friend_approve':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_friend_approve:title',array($vars['cp_approver']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_friend_approve:title',array($vars['cp_approver']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_friend_approve:description',array($vars['cp_approver']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_friend_approve:description',array($vars['cp_approver']),'fr');

		break;


	case 'cp_likes_type': // likes

		if ($vars['cp_subtype'] === 'thewire') {
			$content_title_en = gc_explode_translation($vars['cp_description'], 'en');
			$content_title_fr = gc_explode_translation($vars['cp_description'], 'fr');

			$trimmedURL = strtok($vars['cp_content_url'], "?");
			$wire_id = explode("/thewire/view/", $trimmedURL)[1];

		} else {
			$content_title_en = gc_explode_translation($vars['cp_comment_from'], 'en');
			$content_title_fr = gc_explode_translation($vars['cp_comment_from'], 'fr');

			$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes:title',array($vars['cp_liked_by'], $content_title_en),'en');
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes:title',array($vars['cp_liked_by'], $content_title_fr),'fr');
		}

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes:description',array($vars['cp_content_url'].'?utm_source=notification&utm_medium=email'),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes:description',array($vars['cp_content_url'].'?utm_source=notification&utm_medium=email'),'fr');

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


		$cp_comment_txt = strip_tags($vars['cp_comment']->description);

		// GCCON-209: missing description (refer to requirements)
		$cp_notify_msg_description_en = $cp_comment_txt;
		$cp_notify_msg_description_fr = $cp_comment_txt;
		if (strlen($cp_comment_txt) > 200) {
			$cp_comment_txt = substr($cp_comment_txt, 0, 200);
			$cp_notify_msg_description_en = substr($cp_comment_txt, 0, strrpos($cp_comment_txt, ' ')).'... '.elgg_echo('cp_notify:readmore',array($vars['cp_comment']->getURL().'?utm_source=notification&utm_medium=email'),'en');
			$cp_notify_msg_description_fr = substr($cp_comment_txt, 0, strrpos($cp_comment_txt, ' ')).'... '.elgg_echo('cp_notify:readmore',array($vars['cp_comment']->getURL().'?utm_source=notification&utm_medium=email'),'fr');
		}


		$topic_title_en = gc_explode_translation($vars['cp_topic']->title, 'en');
		$topic_title_fr = gc_explode_translation($vars['cp_topic']->title, 'fr');

		if ($vars['cp_topic']->getSubtype() === 'groupforumtopic') {
			$cp_notify_msg_title_en = elgg_echo('cp_notify:body_comments:title_discussion', array($vars['cp_user_comment']->getURL().'?utm_source=notification&utm_medium=email', $vars['cp_user_comment']->username, $vars['cp_topic_type'], $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email', $topic_title_en),'en');
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_comments:title_discussion', array($vars['cp_user_comment']->getURL().'?utm_source=notification&utm_medium=email', $vars['cp_user_comment']->username, $vars['cp_topic_type'], $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email', $topic_title_fr),'fr');

			$cp_notify_msg_description_en = $vars['cp_comment']->description."<br/>".elgg_echo('cp_notify:body_comments:description_discussion',array($vars['cp_comment']->getURL().'?utm_source=notification&utm_medium=email'),'en');
			$cp_notify_msg_description_fr = $vars['cp_comment']->description."<br/>".elgg_echo('cp_notify:body_comments:description_discussion',array($vars['cp_comment']->getURL().'?utm_source=notification&utm_medium=email'),'fr');
		} else {
			$cp_notify_msg_title_en = elgg_echo('cp_notify:body_comments:title', array($vars['cp_user_comment']->getURL().'?utm_source=notification&utm_medium=email', $vars['cp_user_comment']->username, $vars['cp_topic_type'], $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email', $topic_title_en),'en');

			if (array_key_exists($vars['cp_topic_type'], $entity_f))
				$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_comments:title_f', array($vars['cp_user_comment']->getURL().'?utm_source=notification&utm_medium=email', $vars['cp_user_comment']->username, $vars['cp_topic_type'], $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email', $topic_title_fr),'fr');
			else
				$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_comments:title_m', array($vars['cp_user_comment']->getURL().'?utm_source=notification&utm_medium=email', $vars['cp_user_comment']->username, $vars['cp_topic_type'], $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email', $topic_title_fr),'fr');
		}

		break;

	case 'multiple_file':

		$user = elgg_get_logged_in_user_entity();

		/// Files uploaded within a group context
		if ($vars['cp_topic'] instanceof ElggGroup) {
			$files = $vars['files_uploaded'];

			$files_count = count($files);
			$file_entity = get_entity($files[0]);
			$group_name_en = gc_explode_translation($file_entity->getContainerEntity()->name,'en');
			$group_name_fr = gc_explode_translation($file_entity->getContainerEntity()->name,'fr');
			$files_author_link = "<a href='{$file_entity->getOwnerEntity()->getURL()}?utm_source=notification&utm_medium=email'>{$file_entity->getOwnerEntity()->name}</a>";
			$group_link_en = "<a href='{$file_entity->getContainerEntity()->getURL()}?utm_source=notification&utm_medium=email'>{$group_name_en}</a>";
			$group_link_fr = "<a href='{$file_entity->getContainerEntity()->getURL()}?utm_source=notification&utm_medium=email'>{$group_name_fr}</a>";

			$singular_or_plural = (count($files) > 1) ? 'plural' : 'singular';
			$display_files_en = elgg_echo("cp_notifications:mail_body:subtype:file_upload:group:{$singular_or_plural}", array($files_author_link, $files_count, $group_link_en), 'en');
			$display_files_fr = elgg_echo("cp_notifications:mail_body:subtype:file_upload:group:{$singular_or_plural}", array($files_author_link, $files_count, $group_link_fr), 'fr');

			$display_files .= "<p><ol>";
			foreach ($files as $file_num => $file) {
				$file_entity = get_entity($file);
				$display_files .= "<li><a href='{$file_entity->getURL()}?utm_source=notification&utm_medium=email'>{$file_entity->title}</a></li>";
			}
			$display_files .= "</ol></p>";

			$cp_notify_msg_description_en = $display_files_en.$display_files;
			$cp_notify_msg_description_fr = $display_files_fr.$display_files;

		} else {
			/// Files uploaded within a user's context

			$files = $vars['files_uploaded'];
			$files_count = count($files);
			$file_entity = get_entity($files[0]);
			$files_author_link = "<a href='{$file_entity->getOwnerEntity()->getURL()}?utm_source=notification&utm_medium=email'>{$file_entity->getOwnerEntity()->name}</a>";

			$singular_or_plural = (count($files) > 1) ? 'plural' : 'singular';
			$display_files_en = elgg_echo("cp_notifications:mail_body:subtype:file_upload:{$singular_or_plural}", array($files_author_link, $files_count), 'en');
			$display_files_fr = elgg_echo("cp_notifications:mail_body:subtype:file_upload:{$singular_or_plural}", array($files_author_link, $files_count), 'fr');

			$display_files .= "<p><ol>";
			foreach ($files as $file_num => $file) {
				$file_entity = get_entity($file);
				$display_files .= "<li><a href='{$file_entity->getURL()}?utm_source=notification&utm_medium=email'>{$file_entity->title}</a></li>";
			}
			$display_files .= "</ol></p>";

			$cp_notify_msg_description_en = $display_files_en.$display_files;
			$cp_notify_msg_description_fr = $display_files_fr.$display_files;
		}

		break;

	case 'zipped_file':
		$user = elgg_get_logged_in_user_entity();

		/// files uploaded into a group context
		if ($vars['cp_topic'] instanceof ElggGroup) {

			$files = $vars['files_uploaded'];
			$files_count = count($files);
			$file_entity = get_entity($files[0]);
			$group_name_en = gc_explode_translation($file_entity->getContainerEntity()->name,'en');
			$group_name_fr = gc_explode_translation($file_entity->getContainerEntity()->name,'fr');
			$files_author_link = "<a href='{$file_entity->getOwnerEntity()->getURL()}?utm_source=notification&utm_medium=email'>{$file_entity->getOwnerEntity()->name}</a>";
			$group_link_en = "<a href='{$file_entity->getContainerEntity()->getURL()}?utm_source=notification&utm_medium=email'>{$group_name_en}</a>";
			$group_link_fr = "<a href='{$file_entity->getContainerEntity()->getURL()}?utm_source=notification&utm_medium=email'>{$group_name_fr}</a>";

			$singular_or_plural = (count($files) > 1) ? 'plural' : 'singular';
			$display_files_en = elgg_echo("cp_notifications:mail_body:subtype:file_upload:group:{$singular_or_plural}", array($files_author_link, $files_count, $group_link_en), 'en');
			$display_files_fr = elgg_echo("cp_notifications:mail_body:subtype:file_upload:group:{$singular_or_plural}", array($files_author_link, $files_count, $group_link_fr), 'fr');

			$display_files .= "<p><ol>";
			foreach ($files as $file_num => $file) {
				$file_entity = get_entity($file);
				$display_files .= "<li><a href='{$file_entity->getURL()}?utm_source=notification&utm_medium=email'>{$file_entity->title}</a></li>";
			}
			$display_files .= "</ol></p>";

			$cp_notify_msg_description_en = $display_files_en.$display_files;
			$cp_notify_msg_description_fr = $display_files_fr.$display_files;

		} else {
			/// files uploaded into user's context

			$files = $vars['files_uploaded'];
			$files_count = count($files);
			$file_entity = get_entity($files[0]);
			$files_author_link = "<a href='{$file_entity->getOwnerEntity()->getURL()}?utm_source=notification&utm_medium=email'>{$file_entity->getOwnerEntity()->name}</a>";

			$singular_or_plural = (count($files) > 1) ? 'plural' : 'singular';
			$display_files_en = elgg_echo("cp_notifications:mail_body:subtype:file_upload:{$singular_or_plural}", array($files_author_link, $files_count), 'en');
			$display_files_fr = elgg_echo("cp_notifications:mail_body:subtype:file_upload:{$singular_or_plural}", array($files_author_link, $files_count), 'fr');

			$display_files .= "<p><ol>";
			foreach ($files as $file_num => $file) {
				$file_entity = get_entity($file);
				$display_files .= "<li><a href='{$file_entity->getURL()}?utm_source=notification&utm_medium=email'>{$file_entity->title}</a></li>";
			}
			$display_files .= "</ol></p>";

			$cp_notify_msg_description_en = $display_files_en.$display_files;
			$cp_notify_msg_description_fr = $display_files_fr.$display_files;
		}

		break;
	case 'new_mission':
	case 'cp_new_type': // new blogs or other entities

		$entity_m = array(
			'blog' => 'blogue',
			'bookmarks' => 'signet',
			'poll' => 'sondage',
			'event_calendar' => 'nouvel événement',
			'file' => 'fichier',
			'album' => 'album d\'image',
			'wire' => 'fil'
		);
		$entity_f = array(
			'idea' => 'idée',
			'page' => 'page',
			'page_top' => 'page',
			'task_top' => 'task',
			'task' => 'task',
			'groupforumtopic' => 'discussion',
			'question' => 'question',
			'image' => 'image',
		);

		$entity_answer = array(
			'answer' => 'réponse',
		);

		// cyu - updated as per required (06-15-2016)
		$topic_author = get_entity($vars['cp_topic']->owner_guid);

		$vars['cp_topic']->title2 = gc_explode_translation($vars['cp_topic']->title,'fr');


		if ($vars['cp_topic']->getSubtype() === 'answer') {

			$question_guid = $vars['cp_topic']->getContainerGUID();
			$answer_entity = get_entity($question_guid);
			$title_answer = gc_explode_translation($answer_entity->title,'en');
			$title_answer2 = gc_explode_translation($answer_entity->title,'fr');

			$cp_notify_msg_title_en = elgg_echo('cp_notify:body_new_content:title2',array($topic_author->getURL().'?utm_source=notification&utm_medium=email', $topic_author->username, cp_translate_subtype($vars['cp_topic']->getSubtype()), $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email', $title_answer),'en');
		} else
			$cp_notify_msg_title_en = elgg_echo('cp_notify:body_new_content:title',array($topic_author->getURL().'?utm_source=notification&utm_medium=email', $topic_author->username, cp_translate_subtype($vars['cp_topic']->getSubtype()), $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email', gc_explode_translation($vars['cp_topic']->title,'en')),'en');


		if (array_key_exists($vars['cp_topic']->getSubtype(),$entity_f))
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_new_content:title_f',array($topic_author->getURL(), $topic_author->username, $entity_f[$vars['cp_topic']->getSubtype()], $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email', $vars['cp_topic']->title2),'fr');

		else if (array_key_exists($vars['cp_topic']->getSubtype(),$entity_m))
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_new_content:title_m',array($topic_author->getURL(), $topic_author->username, $entity_m[$vars['cp_topic']->getSubtype()], $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email', $vars['cp_topic']->title2),'fr');

		else if (array_key_exists($vars['cp_topic']->getSubtype(),$entity_answer))
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_new_content:title_answer',array($topic_author->getURL(), $topic_author->username, $entity_answer[$vars['cp_topic']->getSubtype()], $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email', $title_answer2),'fr');
		
		else
			$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_new_content:title_m2',array($topic_author->getURL(), $topic_author->username, $entity_m2[$vars['cp_topic']->getSubtype()], $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email', $vars['cp_topic']->title2),'fr');


		if ($vars['cp_topic']->description1) {
             $cp_topic_description = strip_tags($vars['cp_topic']->description1);
        }


		$cp_topic_description_en = $cp_topic_description;
		$cp_topic_description_fr = $cp_topic_description;

		$cp_topic_description_discussion_en = gc_explode_translation($cp_topic_description_discussion,'en');
		$cp_topic_description_discussion_fr = gc_explode_translation($cp_topic_description_discussion,'fr');


		if (strlen($cp_topic_description) > 200) {
			$cp_topic_description = substr($cp_topic_description, 0, 200);
			$cp_topic_description_en = substr($cp_topic_description, 0, strrpos($cp_topic_description, ' ')).'... '.elgg_echo('cp_notify:readmore',array($vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email'),'en');
			$cp_topic_description_fr = substr($cp_topic_description, 0, strrpos($cp_topic_description, ' ')).'... '.elgg_echo('cp_notify:readmore',array($vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email'),'fr');
		}
		if ($vars['cp_topic']->getSubtype() === 'groupforumtopic' /*|| $vars['cp_topic']->getContainerEntity() instanceof ElggGroup*/) {
			$cp_notify_msg_description_en = elgg_echo('cp_notify:body_new_content:description_discussion',array("<i>{$cp_topic_description_discussion_en}</i><br/>", $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email'),'en');
			$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_new_content:description_discussion',array("<i>{$cp_topic_description_discussion_fr}</i><br/>", $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email'),'fr');
		} else if (!$cp_topic_description) {
			$cp_notify_msg_description_en = elgg_echo('cp_notify:body_new_content:no_description_discussion',array($vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email'),'en');
			$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_new_content:no_description_discussion',array($vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email'),'fr');
		} else {
			$cp_notify_msg_description_en = elgg_echo('cp_notify:body_new_content:description',array("<i>{$cp_topic_description_en}</i><br/>", $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email'),'en');
			$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_new_content:description',array("<i>{$cp_topic_description_fr}</i><br/>", $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email'),'fr');
		}


		if( $vars['cp_topic']->getSubtype() === 'thewire' ){
			if ( elgg_is_active_plugin('thewire_images') )
				elgg_load_library('thewire_image');

			$cp_notify_msg_title_en = elgg_echo('cp_notifications:mail_body:subtype:thewire',array($topic_author->getURL().'?utm_source=notification&utm_medium=email', $topic_author->username, $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email', cp_translate_subtype($vars['cp_topic']->getSubtype())),'en');
			$cp_notify_msg_title_fr = elgg_echo('cp_notifications:mail_body:subtype:thewire',array($topic_author->getURL().'?utm_source=notification&utm_medium=email', $topic_author->username, $vars['cp_topic']->getURL().'?utm_source=notification&utm_medium=email', $entity_m[cp_translate_subtype($vars['cp_topic']->getSubtype())]),'fr');
			$cp_notify_msg_description_en = $vars['cp_topic']->description;
			$cp_notify_msg_description_fr = $vars['cp_topic']->description;

			if ( elgg_is_active_plugin('thewire_images') )
				$attachment = thewire_image_get_attachments($vars['cp_topic']->getGUID());
			if ($attachment) {
				$cp_notify_msg_title_en .= elgg_echo('cp_notifications:mail_body:wire_has_image', '', 'en');
				$cp_notify_msg_title_fr .= elgg_echo('cp_notifications:mail_body:wire_has_image', '', 'fr');
			}

		}

		break;


	case 'cp_mention_type': // mentions
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_mention:title',array($vars['cp_author'],gc_explode_translation($vars['cp_content']->getContainerEntity()->title,'en')),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_mention:title',array($vars['cp_author'],gc_explode_translation($vars['cp_content']->getContainerEntity()->title,'fr')),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_mention:description', array($vars['cp_content_desc'],$vars['cp_link'].'?utm_source=notification&utm_medium=email'),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_mention:description', array($vars['cp_content_desc'],$vars['cp_link'].'?utm_source=notification&utm_medium=email'),'fr');

		break;


	case 'cp_site_msg_type': // new messages
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_site_msg:title',array($vars['cp_sender'],$cp_msg_title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_site_msg:title',array($vars['cp_sender'],$cp_msg_title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_site_msg:description',array($cp_msg_content,$cp_msg_url.'?utm_source=notification&utm_medium=email'),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_site_msg:description',array($cp_msg_content,$cp_msg_url.'?utm_source=notification&utm_medium=email'),'fr');

		break;


	case 'cp_closed_grp_req_type':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_request:title', array($vars['cp_group_req_user']->name, gc_explode_translation($vars['cp_group_req_group']->name, 'en')),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_request:title', array($vars['cp_group_req_user']->name, gc_explode_translation($vars['cp_group_req_group']->name, 'fr')),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_request:description', array(gc_explode_translation($vars['cp_group_req_group']->name, 'en'), $vars['cp_group_req_group']->getURL().'?utm_source=notification&utm_medium=email'),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_request:description', array(gc_explode_translation($vars['cp_group_req_group']->name, 'fr'), $vars['cp_group_req_group']->getURL().'?utm_source=notification&utm_medium=email'),'fr');

		break;


	case 'cp_helpdesk_req_type': // helpdesk - has its own mailing system....
		break;


	case 'cp_group_add': // adding user to group
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_add:title',array(gc_explode_translation($vars['cp_group']['name'],'en')),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_add:title',array(gc_explode_translation($vars['cp_group']['name'],'fr')),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_add:description',array(gc_explode_translation($vars['cp_group']['name'],'en'),$vars['cp_group']->getURL().'?utm_source=notification&utm_medium=email'),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_add:description',array(gc_explode_translation($vars['cp_group']['name'],'fr'),$vars['cp_group']->getURL().'?utm_source=notification&utm_medium=email'),'fr');

		break;


	case 'cp_group_invite':	// inviting user to group
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_invite:title',array($vars['cp_email_invited_by']['name'],gc_explode_translation($vars['cp_group_invite']['name'],'en')),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_invite:title',array($vars['cp_email_invited_by']['name'],gc_explode_translation($vars['cp_group_invite']['name'],'fr')),'fr');

		$view_invitation = "{$vars['cp_invitation_url']}?utm_source=notification&utm_medium=email";

		$article_link = (strpos($site->getURL(), 'gcconnex') !== false) ? "https://gcconnex.gctools-outilsgc.ca/en/support/solutions/articles/2100030466-how-do-i-join-a-group-" : "https://gccollab.gctools-outilsgc.ca/en/support/solutions/articles/2100028400-how-do-i-find-and-join-a-group-";
		$help_link = (strpos($site->getURL(), 'gcconnex') !== false) ? "https://gcconnex.gc.ca/contactform/?utm_source=notification&utm_medium=email" : "https://gccollab.ca/help/knowledgebase/?utm_source=notification&utm_medium=email";
		$cp_notify_msg_description_en = elgg_echo('cp_notification:group_invite', array($vars['cp_invitation_msg'], $view_invitation, $article_link, $help_link), 'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notification:group_invite', array($vars['cp_invitation_msg'], $view_invitation, $article_link, $help_link), 'fr');

		break;


	case 'cp_group_invite_email':	// inviting non user to group

		$group_name = $vars['cp_group_invite']->name;
		$group_name_en = gc_explode_translation($group_name, 'en');
		$group_name_fr = gc_explode_translation($group_name, 'fr');


		$help_url_link_en = "http://www.gcpedia.gc.ca/wiki/GCconnex_User_Help/Content_Management_and_Collaboration/How_Do_I_Access_and_Join_a_Group%3F?utm_source=notification&utm_medium=email";
		$help_url_link_fr = "http://www.gcpedia.gc.ca/wiki/GCconnex_-_Aide_%C3%A0_l%27utilisateur/Pour_commencer/Comment_puis-je_acc%C3%A9der_%C3%A0_un_groupe_et_m%E2%80%99y_joindre%3F?utm_source=notification&utm_medium=email";

		$invitation_link = "{$vars['cp_invitation_non_user_url']}?utm_source=notification&utm_medium=email";
		$registration_link = "{$site->getURL()}register";
		$article_link = (strpos($site->getURL(), 'gcconnex') !== false) ? "https://gcconnex.gctools-outilsgc.ca/en/support/solutions/articles/2100030466-how-do-i-join-a-group-" : "https://gccollab.gctools-outilsgc.ca/en/support/solutions/articles/2100028400-how-do-i-find-and-join-a-group-";
		$help_link = (strpos($site->getURL(), 'gcconnex') !== false) ? "https://gcconnex.gc.ca/contactform/?utm_source=notification&utm_medium=email" : "https://gccollab.ca/help/knowledgebase/?utm_source=notification&utm_medium=email";
		$login_link = "{$site->getURL()}login";

		$cp_notify_msg_description_en = elgg_echo('cp_notification:group_invite_email', array($vars['cp_invitation_msg'], $site->name, $invitation_link, $site->name, $registration_link, $site->name, $vars['cp_invitation_code'], $site->name, $login_link, $article_link, $help_link), 'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notification:group_invite_email', array($vars['cp_invitation_msg'], $site->name, $invitation_link, $site->name, $registration_link, $site->name, $vars['cp_invitation_code'], $site->name, $login_link, $article_link, $help_link), 'fr');

		break;


	case 'cp_group_mail': // sending out group mail to all members
		$group_name_en = gc_explode_translation($vars['cp_group']['name'], 'en');
		$group_name_fr = gc_explode_translation($vars['cp_group']['name'], 'fr');
		
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_mail:title', array($vars['cp_group_subject'], $group_name_en),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_mail:title', array($vars['cp_group_subject'], $group_name_fr),'fr');

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

		// since this url sends out validation link, the second portion (GA link) should be appended with the ambersand character
		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_validate_user:description',array($vars['cp_validate_user']['email'],$vars['cp_validate_url'].'&utm_source=notification&utm_medium=email'),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_validate_user:description',array($vars['cp_validate_user']['email'],$vars['cp_validate_url'].'&utm_source=notification&utm_medium=email'),'fr');
		break;

	case 'cp_like_group': // like a group
		$group_name_en = gc_explode_translation($vars['cp_group'], 'en');
		$group_name_fr = gc_explode_translation($vars['cp_group'], 'fr');

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes_group:title', array($vars['cp_liked_by'], $group_name_en), 'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes_group:title', array($vars['cp_liked_by'], $group_name_fr), 'fr');

		$group_text_en = "<a href='{$vars['cp_group_link']}?utm_source=notification&utm_medium=email'>{$group_name_en}</a>";
		$group_text_fr = "<a href='{$vars['cp_group_link']}?utm_source=notification&utm_medium=email'>{$group_name_fr}</a>";

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes_group:description', array($group_text_en), 'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes_group:description', array($group_text_fr), 'fr');
		break;


	case 'cp_likes_comments':

		$content_title_en = gc_explode_translation($vars['cp_comment_from'], 'en');
		$content_title_fr = gc_explode_translation($vars['cp_comment_from'], 'fr');

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes_comment:title',array($vars['cp_liked_by'], "<a href='{$vars['content_url']}?utm_source=notification&utm_medium=email'>{$content_title_en}</a>"),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes_comment:title',array($vars['cp_liked_by'], "<a href='{$vars['content_url']}?utm_source=notification&utm_medium=email'>{$content_title_fr}</a>"),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes_comment:description',array($content_title_en, $vars['cp_liked_by']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes_comment:description',array($content_title_fr, $vars['cp_liked_by']),'fr');

		break;


	case 'cp_likes_topic_replies': // discussion replies

		$content_title_en = gc_explode_translation($vars['cp_comment_from'], 'en');
		$content_title_fr = gc_explode_translation($vars['cp_comment_from'], 'fr');

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes_discussion_reply:title',array($vars['cp_liked_by'], "<a href='{$vars['content_url']}?utm_source=notification&utm_medium=email'>$content_title_en</a>"),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes_discussion_reply:title',array($vars['cp_liked_by'], "<a href='{$vars['content_url']}?utm_source=notification&utm_medium=email'>$content_title_fr</a>"),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes_discussion_reply:description',array($content_title_en, $vars['cp_liked_by']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes_discussion_reply:description',array($content_title_fr, $vars['cp_liked_by']),'fr');

		break;


		/// QUESTION: can we like user updates? ie avatar change, friend approvals?
	case 'cp_likes_user_update':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_likes_user_update:title',array($vars['cp_liked_by']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_likes_user_update:title',array($vars['cp_liked_by']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_likes_user_update:description',array($vars['cp_liked_by']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_likes_user_update:description',array($vars['cp_liked_by']),'fr');

		break;


	case 'cp_hjtopic':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_hjtopic:title',array($vars['cp_hjtopic_title']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_hjtopic:title',array($vars['cp_hjtopic_title']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_hjtopic:description',array($vars['cp_hjtopic_description'],$vars['cp_hjtopic_url'].'?utm_source=notification&utm_medium=email'),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_hjtopic:description',array($vars['cp_hjtopic_description'],$vars['cp_hjtopic_url'].'?utm_source=notification&utm_medium=email'),'fr');

		break;


	case 'cp_hjpost':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_hjpost:title',array($vars['cp_hjpost_title']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_hjpost:title',array($vars['cp_hjpost_title']),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_hjpost:description',array($vars['cp_hjpost_description'],$vars['cp_hjpost_url'].'?utm_source=notification&utm_medium=email'),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_hjpost:description',array($vars['cp_hjpost_description'],$vars['cp_hjpost_url'].'?utm_source=notification&utm_medium=email'),'fr');

		break;


	case 'cp_useradd': // username password
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_add_new_user:title',array(),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_add_new_user:title',array(),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_add_new_user:description',array($vars['cp_username'],$vars['cp_password']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_add_new_user:description',array($vars['cp_username'],$vars['cp_password']),'fr');

		break;


	case 'cp_friend_invite': // link
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_invite_new_user:title',array($vars['cp_from_user']),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_invite_new_user:title',array($vars['cp_from_user']),'fr');
        //Nick - adding the msg to the
		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_invite_new_user:description',array($vars['cp_join_url'].'?utm_source=notification&utm_medium=email'),'en') . ' <br> ' . $vars['cp_msg'];
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_invite_new_user:description',array($vars['cp_join_url'].'?utm_source=notification&utm_medium=email'),'fr'). ' <br> ' . $vars['cp_msg'];

		break;


	case 'cp_event': //send event without ics

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_event:title',array($cp_topic_author->name,$cp_topic_title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_event:title',array($cp_topic_author->name,$cp_topic_title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_event:description',array($description_info_en),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_event:description',array($description_info_fr),'fr');

		break;

	case 'cp_event_request':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_event_request:title',array(/*$vars['cp_event_request_user'],$vars['cp_event_object']->title*/),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_event_request:title',array(/*$vars['cp_event_request_user'],$vars['cp_event_object']->title*/),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_event_request:description',array($vars['cp_event_request_user'],$vars['cp_event_object']->title,$vars['cp_event_request_url']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_event_request:description',array($vars['cp_event_request_user'],$vars['cp_event_object']->title,$vars['cp_event_request_url']),'fr');

		$footer2_required = false;
		break;

	case 'cp_event_ics': // sent event with ics
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_event:title',array($cp_topic_author->name,$cp_topic_title),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_event:title',array($cp_topic_author->name,$cp_topic_title),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_event:description',array($description_info_en),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_event:description',array($description_info_fr),'fr');

		break;


	case 'cp_grp_admin_transfer':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_group_admin_transfer:title',array(gc_explode_translation($vars['cp_group_name'],'en')),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_group_admin_transfer:title',array(gc_explode_translation($vars['cp_group_name'],'fr')),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_group_admin_transfer:description',array($vars['cp_appointer'],gc_explode_translation($vars['cp_group_name'],'en'),$vars['cp_group_url'].'?utm_source=notification&utm_medium=email'),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_group_admin_transfer:description',array($vars['cp_appointer'],gc_explode_translation($vars['cp_group_name'],'fr'),$vars['cp_group_url'].'?utm_source=notification&utm_medium=email'),'fr');

		break;


	case 'cp_add_grp_operator':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_add_grp_operator:title',array(gc_explode_translation($vars['cp_group_name'],'en')),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_add_grp_operator:title',array(gc_explode_translation($vars['cp_group_name'],'fr')),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_add_grp_operator:description',array($vars['cp_who_made_operator'],gc_explode_translation($vars['cp_group_name'],'en'),$vars['cp_group_url'].'?utm_source=notification&utm_medium=email'),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_add_grp_operator:description',array($vars['cp_who_made_operator'],gc_explode_translation($vars['cp_group_name'],'fr'),$vars['cp_group_url'].'?utm_source=notification&utm_medium=email'),'fr');

		break;


	case 'cp_messageboard':
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_messageboard:title',array(),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_messageboard:title',array(),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_messageboard:description',array($vars['cp_writer_name'],$vars['cp_message_content'],$vars['cp_owner_profile']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_messageboard:description',array($vars['cp_writer_name'],$vars['cp_message_content'],$vars['cp_owner_profile']),'fr');

		break;


	case 'cp_wire_share':

		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_wireshare:title', array($vars['cp_shared_by']->name),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_wireshare:title', array($vars['cp_shared_by']->name),'fr');
		$reshare_content = $vars['cp_content_reshare'];
		$wire_entity = $vars['cp_content'];
		$wire_image = thewire_image_get_attachments($wire_entity->getGUID());

		if (!$vars['cp_content_reshare']->title) {

			/// sharing a wire to the wire
			$username = "<a href='{$vars['cp_shared_by']->getURL()}?utm_source=notification&utm_medium=email'>{$vars['cp_shared_by']->name}</a>";
			$wire_msg = $vars['cp_content']->description;
			$source_en = "<a href='{$reshare_content->getURL()}?utm_source=notification&utm_medium=email'>".gc_explode_translation($vars['cp_content_reshare']->description, 'en')."source</a>";
			$source_fr = "<a href='{$reshare_content->getURL()}?utm_source=notification&utm_medium=email'>".gc_explode_translation($vars['cp_content_reshare']->description, 'fr')."source</a>";

			if ($wire_image){
				$cp_notify_msg_description_en .= "<p><img  width=\"320\" src='".elgg_get_site_url().'thewire_image/download/'.$wire_image->getGUID().'/'.$wire_image->original_filename."'/> </p>";
				$cp_notify_msg_description_fr .= "<p><img  width=\"320\" src='".elgg_get_site_url().'thewire_image/download/'.$wire_image->getGUID().'/'.$wire_image->original_filename."'/> </p>";
			}
			
			$cp_notify_msg_description_en .= elgg_echo('cp_notify:body:contentshare:description', array($username, $wire_msg, $source_en, 'en'));
			$cp_notify_msg_description_fr .= elgg_echo('cp_notify:body:contentshare:description', array($username, $wire_msg, $source_fr,  'fr'));

		} else {

			/// sharing a content to the wire
			$username = "<a href='{$vars['cp_shared_by']->getURL()}?utm_source=notification&utm_medium=email'>{$vars['cp_shared_by']->name}</a>";
			$wire_msg = $vars['cp_content']->description;
			$source_en = "<a href='{$reshare_content->getURL()}?utm_source=notification&utm_medium=email'>".gc_explode_translation($vars['cp_content_reshare']->title, 'en')."</a>";
			$source_fr = "<a href='{$reshare_content->getURL()}?utm_source=notification&utm_medium=email'>".gc_explode_translation($vars['cp_content_reshare']->title, 'fr')."</a>";
			$wire_link = "{$vars['cp_wire_url']}?utm_source=notification&utm_medium=email";

			if ($wire_image){
				$cp_notify_msg_description_en .= "<p><img  width=\"320\" src='".elgg_get_site_url().'thewire_image/download/'.$wire_image->getGUID().'/'.$wire_image->original_filename."'/> </p>";
				$cp_notify_msg_description_fr .= "<p><img  width=\"320\" src='".elgg_get_site_url().'thewire_image/download/'.$wire_image->getGUID().'/'.$wire_image->original_filename."'/> </p>";
			}

			$cp_notify_msg_description_en = elgg_echo('cp_notify:body:contentshare:description', array($username, $wire_msg, $source_en, $wire_link,$wire_link,'en'));
			$cp_notify_msg_description_fr = elgg_echo('cp_notify:body:contentshare:description', array($username, $wire_msg, $source_fr, $wire_link,$wire_link,'fr'));
		}
		break;


	case 'cp_welcome_message': // new messages
		$cp_notify_msg_title_en = elgg_echo('cp_notify:body_welcome_msg:title',array(gc_explode_translation($vars['cp_sender'],'en')),'en');
		$cp_notify_msg_title_fr = elgg_echo('cp_notify:body_welcome_msg:title',array(gc_explode_translation($vars['cp_sender'],'fr')),'fr');

		$cp_notify_msg_description_en = elgg_echo('cp_notify:body_welcome_msg:description',array($vars['cp_msg_content_en']),'en');
		$cp_notify_msg_description_fr = elgg_echo('cp_notify:body_welcome_msg:description',array($vars['cp_msg_content_fr']),'fr');

		break;

	default:
		break;
}


// if this was a message sent from a user, this is not system generated
if ($msg_type !== 'cp_site_msg_type' && $msg_type !== 'cp_group_mail') {	
	$email_notification_header = elgg_echo('cp_notification:email_header',array(),'en') . ' | ' . elgg_echo('cp_notification:email_header',array(),'fr');
}



$email_notif_footer_msg_fr1 = elgg_echo('cp_notify:contactHelpDesk', array(),'fr');
$email_notif_footer_msg_fr2 = elgg_echo('cp_notify:visitTutorials', array(),'fr');
$email_notif_footer_msg_en1 = elgg_echo('cp_notify:contactHelpDesk', array(),'en');
$email_notif_footer_msg_en2 = elgg_echo('cp_notify:visitTutorials', array(),'en');



if (!$vars['user_name']->username) {
	$username_link = $vars['user_name'];
} else {
	$username_link = $vars['user_name']->username;
}

/// group inviting users to join does not need a "to subscribe ..."
if ($email_notification_footer_non_user_en || $email_notification_footer_non_user_fr){
	$email_notification_footer_en2 = $email_notification_footer_non_user_en;
	$email_notification_footer_fr2 = $email_notification_footer_non_user_fr;

} else if ($msg_type === 'cp_group_invite' || $msg_type === 'cp_group_invite_email') {
	$email_notification_footer_en2 = '';
	$email_notification_footer_fr2 = '';

} else {

	$email_notification_footer_en2 = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/notifications/{$username_link}".'?utm_source=notification&utm_medium=email'),'en');
	$email_notification_footer_fr2 = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/notifications/{$username_link}".'?utm_source=notification&utm_medium=email'),'fr');
}


$french_follows = elgg_echo('cp_notify:french_follows',array());


// not all notification will need the 2nd footer ("...Please edit your notifications in your account's settings...")
if ($footer2_required) {
	$email_notification_footer_en2 = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/notifications/{$vars['user_name']}"),'en');
	$email_notification_footer_fr2 = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/notifications/{$vars['user_name']}"),'fr');
}


$french_follows = elgg_echo('cp_notify:french_follows',array());


echo <<<___HTML
<html>
<body>
	<!-- beginning of email template -->
	<div width='100%' bgcolor='#fcfcfc'>
		<div>
			<div>

		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #055959'>
		        	{$email_notification_header}
		        </div>

		     	<div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#047177;'>
		        	<span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'>GCconnex</span>
		        </div>

		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>

		     	<div width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>

	        		<span style='font-size:12px; font-weight: normal;'>{$french_follows}</span><br/>

		        </div>



		        <div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px; '>

		        	<h4 style='padding: 0px 0px 5px 0px; font-family:sans-serif';>
		        		<strong> {$cp_notify_msg_title_en} </strong>
		        	</h4>
		        	{$wire_post_message}
		        	{$cp_notify_msg_description_en}

		        </div>
                <div style='margin-top:15px; padding: 5px; color: #6d6d6d;'>
                    <div>{$email_notification_footer_en}{$email_notification_footer_en2}</div>
                </div>


                <p><center>***************************************</center></p>

		       	<div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px;'>

		       		<h4 style='padding: 0px 0px 5px 0px; font-family:sans-serif;'>
		       			<strong> {$cp_notify_msg_title_fr} </strong>
		       		</h4>

		       		{$wire_post_message}
		       		{$cp_notify_msg_description_fr}

		        </div>
                    <div style='margin-top:15px; padding: 5px; color: #6d6d6d;'>
                   <div>{$email_notification_footer_fr}{$email_notification_footer_fr2}</div>
                </div>

		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>

		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 16px; color: #055959'> </div>

			</div>
		</div>
	</div>
</body>
</html>

___HTML;
