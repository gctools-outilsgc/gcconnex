<?php

elgg_register_event_handler('init','system','cp_notifications_init');
 

function cp_notifications_init() {

	elgg_register_library('elgg:gc_notification:functions', elgg_get_plugins_path() . 'cp_notifications/lib/functions.php');
	elgg_register_css('cp_notifications-css','mod/cp_notifications/css/notifications-table.css');

	// hide the irrelavent view module from the group
	elgg_unextend_view("groups/edit", "group_tools/forms/notifications");

	elgg_register_plugin_hook_handler('register', 'menu:entity', 'notify_entity_menu_setup', 400);
	// since most of the notifications are built within the action file itself, the trigger_plugin_hook was added to respected plugins
	elgg_register_plugin_hook_handler('cp_overwrite_notification', 'all', 'cp_overwrite_notification_hook');
	elgg_register_plugin_hook_handler('cron', 'daily', 'cp_digest_daily_cron_handler');
	elgg_register_plugin_hook_handler('cron', 'weekly', 'cp_digest_weekly_cron_handler', 100);
	// hooks and events: intercepts and blocks emails and notifications to be sent out
	elgg_register_plugin_hook_handler('email', 'system', 'cpn_email_handler_hook');


	$action_base = elgg_get_plugins_path() . 'cp_notifications/actions/cp_notifications';
	elgg_register_action('cp_notify/subscribe', "$action_base/subscribe.php");
	elgg_register_action('cp_notify/unsubscribe', "$action_base/unsubscribe.php");
	elgg_register_action('user/requestnewpassword', "$action_base/request_new_password.php", 'public');
	elgg_register_action('cp_notifications/set_personal_subscription', "$action_base/set_personal_subscription.php");
	elgg_register_action('cp_notifications/reset_personal_subscription', "$action_base/reset_personal_subscription.php");
    elgg_register_action('cp_notifications/subscribe_users_to_group_content',"$action_base/subscribe_users_to_group_content.php");
    elgg_register_action('cp_notifications/undo_subscribe_users_to_group_content',"$action_base/undo_subscribe_users_to_group_content.php");
    elgg_register_action('cp_notifications/usersettings/save', elgg_get_plugins_path() . 'cp_notifications/actions/usersettings/save.php');
	elgg_register_action('cp_notifications/user_autosubscription',"{$action_base}/user_autosubscription.php");
	elgg_register_action('cp_notifications/fix_inconsistent_subscription_script',"{$action_base}/fix_inconsistent_subscription_script.php");
  
  	elgg_register_action('cp_notifications/fix_forums_subscription',"$actions_base/fix_forums_subscription.php");
  
	elgg_register_action('useradd',"$action_base/useradd.php",'admin'); // actions/useradd.php (core file)

	// this plugin must now be placed after "group_tools" plugin
	elgg_register_action('group_tools/mail', "{$action_base}/group_mail.php"); 


	// Ajax action files
	elgg_register_action('cp_notify/retrieve_group_contents', elgg_get_plugins_path().'cp_notifications/actions/ajax_usersettings/retrieve_group_contents.php'); 
	elgg_register_action('cp_notify/retrieve_personal_content', elgg_get_plugins_path().'cp_notifications/actions/ajax_usersettings/retrieve_personal_content.php'); 
	elgg_register_action('cp_notify/retrieve_pt_users', elgg_get_plugins_path().'cp_notifications/actions/ajax_usersettings/retrieve_pt_users.php'); 
	elgg_register_action('cp_notify/retrieve_messages', elgg_get_plugins_path().'cp_notifications/actions/ajax_usersettings/retrieve_messages.php'); 
	elgg_register_action('cp_notify/retrieve_user_info', elgg_get_plugins_path().'cp_notifications/actions/ajax_settings/retrieve_user_info.php'); 

	// send notifications when the action is sent out
	elgg_register_event_handler('create','object','cp_create_notification',900);
	elgg_register_event_handler('single_file_upload', 'object', 'cp_create_notification');
	elgg_register_event_handler('single_zip_file_upload', 'object', 'cp_create_notification');
	elgg_register_event_handler('multi_file_upload', 'object', 'cp_create_notification');

	elgg_register_event_handler('create','annotation','cp_create_annotation_notification');
	elgg_register_event_handler('create', 'membership_request', 'cp_membership_request');

	// we need to check if the mention plugin is installed and activated because it does notifications differently...
	if (elgg_is_active_plugin('mentions')) {
		elgg_unregister_event_handler('create', 'object','mentions_notification_handler');
		elgg_unregister_event_handler('update', 'annotation','mentions_notification_handler');
	}

    elgg_extend_view("js/elgg", "js/notification"); 
    elgg_extend_view("js/elgg", "js/popup");
    elgg_extend_view("js/elgg","js/wet4/language_ajax");

    // remove core notification settings portion of the main settings page
    elgg_unextend_view('forms/account/settings', 'core/settings/account/notifications');


	/// "minor save" for contents within groups (basically put the option for all the forms, then filter via URL)
	$group_entity = elgg_get_page_owner_entity();
	$current_user = elgg_get_logged_in_user_entity();


	if (elgg_is_active_plugin('group_operators'))
		elgg_load_library('elgg:group_operators');

	if ($group_entity instanceof ElggGroup) {

	// TODO: check to make sure that get_group_operators() is available

	if (elgg_is_logged_in() && (in_array($current_user, get_group_operators($group_entity)) || elgg_is_admin_user($current_user->getGUID()))) {


			$url = str_replace(elgg_get_site_url(),"", $_SERVER['REQUEST_URI']);
			if (strpos($url,'edit') == false) {

				$plugin_list = elgg_get_plugins('active', 1);
				foreach ($plugin_list as $plugin_form)
				{
					$filepath = elgg_get_plugins_path().$plugin_form['title'].'/views/default/forms/'.$plugin_form['title'];
					if (file_exists($filepath))
					{
						$dir = scandir($filepath);
						foreach ($dir as $form_file)
						{
							if ((strpos($form_file,'save') !== false || strpos($form_file, 'upload') !== false) && (!strstr($form_file, '.old')))
							{
								$remove_php = explode('.',$form_file);
								elgg_extend_view('forms/'.$plugin_form['title'].'/'.$remove_php[0], 'forms/minor_save', 500);
							}
						}
					}
				}
				
				elgg_extend_view('forms/photos/image/save', 'forms/minor_save', 500);
				elgg_extend_view('forms/photos/album/save', 'forms/minor_save', 500);
				elgg_extend_view('forms/discussion/save', 'forms/minor_save', 500);
			}
		}
	}

	$subtype_array = array('blog', 'bookmarks', 'discussion');
	foreach ($subtype_array as $subtype) 
		elgg_register_plugin_hook_handler('action', $subtype.'/save', 'minor_save_hook_handler', 300);
	
	$subtype_array = array('file/upload', 'ideas/saveidea', 'photos/album/save');
	foreach ($subtype_array as $subtype) 
		elgg_register_plugin_hook_handler('action', $subtype, 'minor_save_hook_handler', 300);	

}


/**
 * catches the minor save, determines whether to cancel or process the event handlers
 *
 * @param string $hook    The name of the plugin hook
 * @param string $type    The type of the plugin hook
 * @param mixed  $value   The current value of the plugin hook
 * @param mixed  $params  Data passed from the trigger
 *
 * @return mixed if not null, this will be the new value of the plugin hook
 */
function minor_save_hook_handler($hook, $type, $value, $params) {


    if (strcmp(get_input('minor_save'), 'yes') === 0) {

	    elgg_unregister_event_handler('create','object','cp_create_notification', 900);
		elgg_unregister_event_handler('single_file_upload', 'object', 'cp_create_notification');
		elgg_unregister_event_handler('single_zip_file_upload', 'object', 'cp_create_notification');
		elgg_unregister_event_handler('multi_file_upload', 'object', 'cp_create_notification');
		elgg_unregister_event_handler('create','annotation','cp_create_annotation_notification');

	}

    return true;
}

function count_email_types( $type ){
	try {
		$m = new Memcached();
		$m->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
		$m->addServer('localhost', 11211);

		$n = $m->increment("email:$type", 1, 1);
	} catch(Exception $err){
		error_log("could not increment email counter for $type");
	}
}

/**
 *
 * This contains all the notifications that are required to be triggered from the original action files. Filepaths
 * are documented beside each case (and in the readme.md file)
 *
 * @param string $hook    The name of the plugin hook
 * @param string $type    The type of the plugin hook
 * @param mixed  $value   The current value of the plugin hook
 * @param mixed  $params  Data passed from the trigger
 */
function cp_overwrite_notification_hook($hook, $type, $value, $params) {

	elgg_load_library('elgg:gc_notification:functions');
	$cp_msg_type = trim($params['cp_msg_type']);
	$to_recipients = array();
	$email_only = false;
	$add_to_sent = false;
	$embed_image = NULL;
	$sender_guid = elgg_get_site_entity()->guid;

	count_email_types($cp_msg_type);
	switch ($cp_msg_type) {
		/// EMAIL NOTIFICATIONS ONLY (password reset, registration, etc)
		case 'cp_friend_invite': // invitefriends/actions/invite.php
			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_from_user' => $params['cp_from']->name,
				'cp_to_user' => $params['cp_to'],
				'cp_join_url' => $params['cp_join_url'],
				'cp_msg' => $params['cp_email_msg'],
				'_user_e-mail' => $params['cp_to'],
			);
			$subject = elgg_echo('cp_notify:subject:invite_new_user',array(),'en') . ' | ' . elgg_echo('cp_notify:subject:invite_new_user',array(),'fr');
			$template = elgg_view('cp_notifications/email_template', $message);
			$site_template = elgg_view('cp_notifications/site_template', $message);
			$user_obj = get_user_by_email($params['cp_to']);
			$info_notif = 'cp_friend_invite';
			$result = (elgg_is_active_plugin('phpmailer')) ? phpmailer_send($params['cp_to'], $params['cp_to'], $subject, $template, NULL,true) : mail($params['cp_to'],$subject,$template,cp_get_headers());
			return true;


		case 'cp_forgot_password':	// send email notifications only - /wet4/users/action/password
			cp_send_new_password_request($params['cp_password_requester']);
			return true;

		case 'cp_group_invite_email':
		case 'cp_group_invite':	// group_tools/lib/functions.php (returns user's email, so return after mail is sent out)

			$group_name = $params['cp_invite_to_group']['name'];
			if (elgg_is_active_plugin('wet4')) {
				$group_name_en =  htmlspecialchars(filter_tags(htmlspecialchars_decode(gc_explode_translation($group_name, 'en'))));
				$group_name_fr = htmlspecialchars(filter_tags(htmlspecialchars_decode(gc_explode_translation($group_name, 'fr'))));
			}

			$subject = elgg_echo('cp_notify:subject:group_invite_email',array($params['cp_inviter']['name'], $group_name_en),'en') . ' | ' . elgg_echo('cp_notify:subject:group_invite_email',array($params['cp_inviter']['name'], $group_name_fr),'fr');
			$subject = htmlspecialchars_decode($subject, ENT_QUOTES);

			$user_email = $params['cp_invitee'];


			$message = array(
				'cp_email_invited' => $params['cp_invitee'],
				'cp_email_invited_by' => $params['cp_inviter'],
				'cp_group_invite' => $params['cp_invite_to_group'],
				'cp_invitation_non_user_url' => $params['cp_invitation_nonuser_url'],
				'cp_invitation_url' => $params['cp_invitation_url'],
				'cp_invitation_code' => $params['cp_invitation_code'],
				'cp_invitation_msg' => $params['cp_invite_msg'],
				'cp_msg_type' => $cp_msg_type,
				'_user_e-mail' => $params['cp_invitee'],
				'group_link' => $params['group_link'],
				'cp_user_profile' => $params['cp_user_profile'],
			);
			$template = elgg_view('cp_notifications/email_template', $message);

			// invitation through email, user might not exist
			if ($cp_msg_type === 'cp_group_invite') {
				$site_template = elgg_view('cp_notifications/site_template', $message);
				if ($params['cp_invitee'] instanceof ElggUser)
					$send_to_user = get_user_by_email($params['cp_invitee']);
				else 
					$send_to_user = $params['cp_invitee'];
			} 
			$result = (elgg_is_active_plugin('phpmailer')) ? phpmailer_send( $params['cp_invitee']->email, $params['cp_invitee']->name, $subject, $template, NULL, true ) : mail($send_to_user->email, $subject, $template, cp_get_headers());
			return true;

		case 'cp_useradd': // cp_notifications/actions/useradd.php
			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_user_name' => $params['cp_user_name'],
				'cp_site_name' => $params['cp_site_name'],
				'cp_site_url' => $params['cp_site_url'],
				'cp_username' => $params['cp_username'],
				'cp_password' => $params['cp_password'],
			);
			$to_recipients[] = $params['cp_user'];
			$info_notif = 'cp_useradd';
			
			$subject = elgg_echo('cp_notify:subject:add_new_user',array(),'en') . ' | ' . elgg_echo('cp_notify:subject:add_new_user',array(),'fr');
			$email_only = true;
			break;

		case 'cp_validate_user': // uservalidationbyemail/lib/functions.php
			$message = array(
				'cp_validate_user' => $params['cp_validate_user'],
				'cp_validate_url' => $params['cp_validate_url'],
				'cp_msg_type' => $cp_msg_type
			);
			$subject = elgg_echo('cp_notify:subject:validate_user',array($params['cp_validate_user']['email']),'en') . ' | ' . elgg_echo('cp_notify:subject:validate_user',array($params['cp_validate_user']['email']),'fr');
			$to_recipients[] = get_user($params['cp_validate_user']['guid']);
			$info_notif = 'cp_validate_user';
			$email_only = true;
			break;

		case 'cp_site_msg_type':	// messages/actions/messages/send.php
			$add_to_sent = true;
			$sender_guid = $params['cp_from']['guid'];
			$to_recipients[] = get_user($params['cp_to']['guid']);
			$info_notif = 'cp_site_msg_type';			
			$subject = $params['cp_topic_title'];
			$message = array(
				'cp_msg_title' => $params['cp_topic_title'],
				'cp_msg_content' => $params['cp_topic_description'],
				'cp_sender' => $params['cp_from']['name'],
				'cp_msg_url' => $params['cp_topic_url'],
				'cp_msg_type' => 'cp_site_msg_type',
			);
			break;

		/// NORMAL NOTIFICATIONS that will send out both email and site notification

		case 'cp_wire_image':

			/// the function thewire_image_get_attachments will return an entity
			$embed_image = $params['wire_imagedata_loc'];
			$author = elgg_get_logged_in_user_entity();
			$message = array(
				'cp_msg_type' => $params['cp_msg_type'],
				'wire_entity' => $params['wire_entity'],
				'imagedata_location' => $params['wire_imagedata_loc'],
				'author' => $author,
			);


			$subject = elgg_echo('cp_notifications:mail_body:subtype:thewireSubj', array($author->name, 'Wire'), 'en').' | ';
			$subject .= elgg_echo('cp_notifications:mail_body:subtype:thewireSubj',array($author->name, 'Fil'),'fr');
			$content_entity = $params['wire_entity'];

			$query = "SELECT * FROM elggentity_relationships WHERE relationship = 'cp_subscribed_to_email' AND guid_two = {$author->getGUID()}";
			$users = get_data($query);

			foreach ($users as $user) {
				$to_recipients[$user->guid_one] = get_entity($user->guid_one);
			}
			$info_notif = 'cp_wire_image';			
			
			break;

		case 'cp_wire_share': // thewire_tools/actions/add.php


			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_shared_by' => $params['cp_shared_by'],
				'cp_content_reshare' => $params['cp_content_reshared'],
				'cp_content' => $params['cp_content'],
				'cp_recipient' => $params['cp_recipient'],
				'cp_wire_url' => $params['cp_wire_url'],
				
				'imagedata_location' => $params['wire_imagedata_loc'],
			);

			$parent_item = $params['cp_content']->getContainerEntity();

			$subject = elgg_echo('cp_notify:wireshare:subject',array($params['cp_shared_by']->name),'en').' | ';
			$subject .= elgg_echo('cp_notify:wireshare:subject',array($params['cp_shared_by']->name),'fr');

			$to_recipients[] = $params['cp_recipient'];
			$info_notif = 'cp_wire_share';						
			$content_entity = $params['cp_content_reshared'];
			$author = $params['cp_shared_by'];
			$content_url = $params['cp_content_reshared']->getURL();
			break;


		case 'cp_messageboard': // messageboard/actions/add.php
			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_message_content' => $params['cp_message_content'],
				'cp_writer_name' => $params['cp_writer']->name,
				'cp_owner_profile' => $params['cp_recipient']->getURL(),
			);
			$subject = elgg_echo('cp_notify:messageboard:subject',array(),'en') . ' | ' . elgg_echo('cp_notify:messageboard:subject',array(),'fr');
			$to_recipients[] = $params['cp_recipient'];
			$info_notif = 'cp_messageboard';			
			$content_entity = $params['cp_message_content'];
			$author = $params['cp_writer'];
			break;

		case 'cp_add_grp_operator': // group_operators/actions/group_operators/add.php (adds group operator)
			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_to_operator' => $params['cp_to_operator'],
				'cp_who_made_operator' => $params['cp_who_made_operator'],
				'cp_group_name' => $params['cp_group_name'],
				'cp_who_made_operator' => $params['cp_who_made_operator'],
				'cp_group_url' => $params['cp_group_url'],
			);
			$subject = elgg_echo('cp_notify:subject:add_grp_operator',array(htmlspecialchars(filter_tags(htmlspecialchars_decode(gc_explode_translation($params['cp_group_name'], 'en'))))),'en') . ' | ' . elgg_echo('cp_notify:subject:add_grp_operator',array(htmlspecialchars(filter_tags(htmlspecialchars_decode(gc_explode_translation($params['cp_group_name'], 'fr'))))),'fr');
			$to_recipients[] = $params['cp_to_user'];
			$info_notif = 'cp_add_grp_operator';						
			break;


		case 'cp_grp_admin_transfer': // group_tools/lib/functions.php (this is transfer of group owner through group edit)
			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_group_name' => $params['cp_group_name'],
				'cp_group_url' => $params['cp_group_url'],
				'cp_appointer' => $params['cp_appointer']
			);
			$subject = elgg_echo('cp_notify:subject:group_admin_transfer',array(htmlspecialchars(filter_tags(htmlspecialchars_decode(gc_explode_translation($params['cp_group_name'],'en'))))),'en') . ' | ' . elgg_echo('cp_notify:subject:group_admin_transfer',array(htmlspecialchars(filter_tags(htmlspecialchars_decode(gc_explode_translation($params['cp_group_name'],'fr'))))),'fr');
			$to_recipients[] = $params['cp_new_owner_user'];
			$info_notif = 'cp_grp_admin_transfer';									
			break;


		case 'cp_wire_mention': // thewire_tools/lib/events.php (TODO: share option in notifications setting)

			$message = array(
				'cp_mention_by' => $params['cp_mention_by'],
				'cp_view_mention' => $params['cp_view_your_mention'],
				'cp_msg_type' => $cp_msg_type,
				'cp_wire_mention_url' => $params['cp_wire_mention_url'],
			);

			$subject = elgg_echo('cp_notify:subject:wire_mention',array($params['cp_mention_by']),'en') . ' | ' . elgg_echo('cp_notify:subject:wire_mention',array($params['cp_mention_by']),'fr');
			$to_recipients[] = $params['cp_send_to'];
			$info_notif = 'cp_wire_mention';									
			$content_entity = $params['cp_wire_entity'];
			$author = $content_entity->getOwnerEntity();
			break;


		case 'cp_friend_approve': // friend_request/actions/approve
			$subject = elgg_echo('cp_notify:subject:approve_friend',array($params['cp_approver']),'en') . ' | ' . elgg_echo('cp_notify:subject:approve_friend',array($params['cp_approver']),'fr');
			$message = array(
				'cp_approver' => $params['cp_approver'],
				'cp_approver_profile' => $params['cp_approver_profile'],
				'cp_msg_type' => $cp_msg_type,

				);
			$to_recipients[] = get_user($params['cp_request_guid']);
			$info_notif = 'cp_friend_approve';									
			$content_entity = $params['object'];
			$author = $params['object'];
			break;


		case 'cp_group_add':	// group_tools/lib/functions.php OR groups/actions/groups/membership/add.php ????
			$to_recipients[] = $params['cp_user_added'];
			$info_notif = 'cp_group_add';												
			$subject = elgg_echo('cp_notify:subject:group_add_user',array(gc_explode_translation($params['cp_group']['name'],'en')),'en') . ' | ' . elgg_echo('cp_notify:subject:group_add_user',array(gc_explode_translation($params['cp_group']['name'],'fr')),'fr');
			$message = array(
				'cp_user_added' => $params['cp_user_added'],
				'cp_group' => $params['cp_group'],
				'cp_message' => $params['cp_added_msg'],
				'cp_msg_type' => $cp_msg_type
			);
			break;


		case 'cp_group_invite': // group_tools/lib/functions.php

			$subject = elgg_echo('cp_notify:subject:group_invite_user',array($params['cp_inviter']['name'],gc_explode_translation($params['cp_invite_to_group']['name'],'en')),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:group_invite_user',array($params['cp_inviter']['name'],gc_explode_translation($params['cp_invite_to_group']['name'],'fr')),'fr');

			$message = array(
				'cp_group_invite_from' => $params['cp_invitee'], // user we're inviting
				'cp_group_invite_to' => $params['cp_inviter'], // user inviting others
				'cp_group' => $params['cp_invite_to_group'],
				'cp_invitation_url' => $params['cp_invitation_url'],
				'cp_invitation_msg' => $params['cp_invite_msg'],
				'cp_msg_type' => $cp_msg_type
			);
			$to_recipients[] = get_user($params['cp_invitee']['guid']);
			$info_notif = 'cp_group_invite';												
			$content_entity = $params['cp_invite_to_group'];
			$author = $params['cp_inviter'];
			break;


		case 'cp_group_mail': // group_tools/actions/mail.php
		
			$message = array(
				'cp_group' => $params['cp_group'],
				'cp_group_subject' => $params['cp_group_subject'],
				'cp_group_message' => $params['cp_group_message'],
				'cp_msg_type' => $cp_msg_type
			);
			$subject = elgg_echo('cp_notify:subject:group_mail',array($params['cp_group_subject'],gc_explode_translation($params['cp_group']['name'],'en')),'en'). ' | ' . elgg_echo('cp_notify:subject:group_mail',array($params['cp_group_subject'],gc_explode_translation($params['cp_group']['name'],'fr')),'fr');
			
			foreach ($params['cp_group_mail_users'] as $to_user) {
				$to_recipients[$to_user] = get_user($to_user);
			}
			$info_notif = 'cp_group_mail';															
			break;


		case 'cp_friend_request': // friend_request/lib/events.php
			$message = array(
				'cp_friend_request_from' => $params['cp_friend_requester'],
				'cp_friend_request_to' => $params['cp_friend_receiver'],
				'cp_friend_invitation_url' => $params['cp_friend_invite_url'],
				'cp_msg_type' => $cp_msg_type
			);
			$subject = elgg_echo('cp_notify:subject:friend_request',array($params['cp_friend_requester']['name']),'en') . ' | ' . elgg_echo('cp_notify:subject:friend_request',array($params['cp_friend_requester']['name']),'fr');
			$to_recipients[] = get_user($params['cp_friend_receiver']['guid']);
			$info_notif = 'cp_friend_request';												

			$content_entity = $params['cp_relationship'];
			$author = $params['cp_friend_requester'];

			break;


		case 'cp_hjpost': // gcforums/actions/gcforums/create.php
			$message = array(
				'cp_hjpost_author' => $params['cp_topic_author'],
				'cp_hjpost_title' => $params['cp_topic_title'],
				'cp_hjpost_description' => $params['cp_topic_description'],
				'cp_hjpost_url' => $params['cp_topic_url'],
				'cp_msg_type' => $cp_msg_type
				);
			$t_user = $params['cp_subscribers'];
			$subject = elgg_echo('cp_notify:subject:hjpost',array($params['cp_topic_author'],$params['cp_topic_title']),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:hjpost',array($params['cp_topic_author'],$params['cp_topic_title']),'fr');
			foreach ($t_user as $s_uer)
				$to_recipients[] = get_user($s_uer);

			$info_notif = 'cp_hjpost';												
			$content_entity = $params['cp_post'];
			$content_url = $params['cp_topic_url'];
			$author = $params['cp_post']->getOwnerEntity();

			break;


		case 'cp_hjtopic': // gcforums/actions/gcforums/create.php
			$message = array(
				'cp_hjtopic_author' => $params['cp_topic_author'],
				'cp_hjtopic_title' => $params['cp_topic_title'],
				'cp_hjtopic_description' => $params['cp_topic_description'],
				'cp_hjtopic_url' => $params['cp_topic_url'],
				'cp_msg_type' => $cp_msg_type
				);
			$t_user = $params['cp_subscribers'];
			$subject = elgg_echo('cp_notify:subject:hjtopic',array($params['cp_topic_author'],$params['cp_topic_title']),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:hjtopic',array($params['cp_topic_author'],$params['cp_topic_title']),'fr');
			foreach ($t_user as $s_uer)
				$to_recipients[] = get_user($s_uer);

			$info_notif = 'cp_hjtopic';															
			$content_url = $params['cp_topic_url'];
			$content_entity = $params['cp_topic'];
			$author = $params['cp_topic']->getOwnerEntity();
			break;

		case 'cp_event_request': // event_calendar/actions/event_calendar/request_personal_calendar.php
			$message = array(
				'cp_event_request_user' => $params['cp_event_request_user'],
				'cp_event_request_url' => $params['cp_event_request_url'],
				'cp_event_object' => $params['cp_event_obj'],
				'type_event' => $params['type_event'], // create, request, cancel
				'cp_msg_type' => $cp_msg_type
			);
			$subject = elgg_echo('cp_notify:event_request:subject',array($params['cp_event_request_user'], $params['cp_event_obj']->title),'en');
			$subject .= ' | '.elgg_echo('cp_notify:event_request:subject',array($params['cp_event_request_user'], $params['cp_event_obj']->title),'fr');
			$to_recipients[] = $params['cp_event_owner'];
			$info_notif = 'cp_event_request';															
			
			break;

		case 'cp_event_ics': // .../mod/event_calendar/actions/event_calendar/add_ics.php
			$message = array(
				'cp_event_send_to_user' => $params['cp_event_send_to_user'],
				//'cp_event_invite_url' => $params['cp_event_invite_url'],
				'startdate' => $params['startdate'],
				'enddate' => $params['enddate'],
				'cp_event' => $params['cp_event'],
				'cp_msg_type' => $cp_msg_type,
			);

			$event = $params['cp_event'];
			$startdate = $params['startdate'];
			$enddate = $params['enddate'];
			
			// Add to my Outlook calendar | Ajoutez a mon calendrier d'Outlook
		    $subject = $event->title.' - '.elgg_get_logged_in_user_entity()->username; 

		   	$event = 'event';
			$to_recipients[] = $params['cp_event_send_to_user'];
			$info_notif = 'cp_event_ics';															
			   
			break;

			case 'cp_welcome_message':	// messages/actions/messages/send.php
			$add_to_sent = true;
			$sender_guid = $params['cp_from']['guid'];
			$to_recipients[] = get_user($params['cp_to']['guid']);
			$info_notif = 'cp_welcome_message';																		
			$subject = $params['cp_topic_title'];
			$message = array(
				'cp_msg_title' => $params['cp_topic_title'],
				'cp_msg_content' => $params['cp_topic_description'],
				'cp_msg_content_fr' => $params['cp_topic_description_fr'],
				'cp_msg_content_en' => $params['cp_topic_description_en'],

				'cp_sender' => $params['cp_from']['name'],
				'cp_msg_url' => $params['cp_topic_url'],
				'cp_msg_type' => 'cp_welcome_message',
			);
			break;

		default:
			break;
	}


	if (empty($subject))
		return false;

	$subject = htmlspecialchars_decode($subject,ENT_QUOTES);

	if (is_array($to_recipients)) {
		foreach ($to_recipients as $to_recipient) {

			// username for link in footer (both email notification and site notification
			$message['user_name'] = $to_recipient->username;
			if ($cp_msg_type != 'cp_event_ics') {
				$template = elgg_view('cp_notifications/email_template', $message);
				$site_template = elgg_view('cp_notifications/site_template', $message);
			}

			$newsletter_appropriate = array('cp_wire_share','cp_wire_image','cp_messageboard','cp_wire_mention','cp_hjpost','cp_hjtopic', 'cp_friend_request', 'cp_friend_approve');
			if (strcmp(elgg_get_plugin_user_setting('cpn_set_digest', $to_recipient->guid, 'cp_notifications'),'set_digest_yes') == 0 && in_array($cp_msg_type, $newsletter_appropriate)) {
				$result = create_digest($author, $cp_msg_type, $content_entity, $to_recipient, $content_url);
				continue;

			} else {
				
					$result = (elgg_is_active_plugin('phpmailer')) ? phpmailer_send( $to_recipient->email, $to_recipient->name, $subject, $template, NULL, true, NULL, NULL, $embed_image ) : mail($to_recipient->email, $subject, $template, cp_get_headers($event));
				}

			if (!$email_only)
				messages_send($subject, $site_template, $to_recipient->guid, $sender_guid, 0, true, $add_to_sent);
		}
	}

	// register the error, if either of the arrays are not populated
	if (!is_array($to_recipients)) {
		notification_logging('error: in cp_create_notification(), $to_recipients is not array'.$info_notif);
	}
}


/**
 * returns the headers for ical
 *
 * @param string 		$type_event
 * @param ElggObject 	$event
 * @param string 		$start_date
 * @param string 		$end_date
 */
function cp_ical_headers($event_type, $event, $start_date, $end_date) {

	$end_date = date("Ymd\THis", strtotime($end_date));
	$start_date = date("Ymd\THis", strtotime($startdate));
	$current_date = date("Ymd\TGis");

	$ical = "
	BEGIN:VCALENDAR \r\n
    PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN \r\n
    VERSION:2.0 \r\n
    METHOD: {$type_event} \r\n
    BEGIN:VTIMEZONE \r\n
    TZID:Eastern Time \r\n
    BEGIN:STANDARD \r\n
    DTSTART:20091101T020000 \r\n
    RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11 \r\n
    TZOFFSETFROM:-0400 \r\n
    TZOFFSETTO:-0500 \r\n
    TZNAME:EST \r\n
    END:STANDARD \r\n
    BEGIN:DAYLIGHT \r\n
    DTSTART:20090301T020000 \r\n
    RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3 \r\n
    TZOFFSETFROM:-0500 \r\n
    TZOFFSETTO:-0400 \r\n
    TZNAME:EDST \r\n
    END:DAYLIGHT \r\n
    END:VTIMEZONE \r\n
    BEGIN:VEVENT \r\n
    LAST-MODIFIED: {$current_date} \r\n
    UID: {$event->guid} \r\n
    DTSTAMP:  \r\n
    DTSTART;TZID='Eastern Time': {$start_date} \r\n
    DTEND;TZID='Eastern Time': {$end_date} \r\n
    TRANSP:OPAQUE \r\n
    SEQUENCE:1 \r\n
	SUMMARY: {$event->title} \r\n
	LOCATION: {$event->venue} \r\n
    CLASS:PUBLIC \r\n
    PRIORITY:5 \r\n
    BEGIN:VALARM \r\n
    TRIGGER:-PT15M \r\n
    ACTION:DISPLAY \r\n
    DESCRIPTION:Reminder \r\n
    END:VALARM \r\n
    END:VEVENT \r\n
    END:VCALENDAR \r\n";

	return $ical;
}




/**
 * cp_create_annotation_notification is an event handler, invokes everytime a user likes something, edit something, etc
 *
 * This contains the likes and the comments that get posted. we also filter out the
 * following : blog revision, discussion replies (?), tasks, poll votes, folder creation
 *
 * @param string $event		the name of the event
 * @param string $type		the type of the object
 * @param mixed $object		the object/entity of the event
 */
function cp_create_annotation_notification($event, $type, $object) {

	elgg_load_library('elgg:gc_notification:functions');
	$entity = get_entity($object->entity_guid);

	if ($entity->entity_minor_edit)	return;

	$dbprefix = elgg_get_config('dbprefix');
	$site = elgg_get_site_entity();
	$object_subtype = $object->getSubtype();
	$liked_content = get_entity($object->entity_guid);
	$type_of_like = $liked_content->getSubtype();
	if (!$type_of_like) $type_of_like = $liked_content->getType();

	$action_type = "content_revision";
	$author = $liked_by;

	/// EDITS TO BLOGS AND PAGES, THEY ARE CONSIDERED ANNOTATION DUE TO REVISIONS AND MULTIPLE COPIES OF SAME CONTENT
	if (strcmp($object_subtype, 'likes') != 0) {

		$content = get_entity($object->entity_guid);
		$get_error_info='if object subtype likes 0';
		// auto save -drafts or -published blogs, we don't send out notifications
		if (strcmp($object_subtype,'blog_auto_save') == 0 && (strcmp($entity->status,'draft') == 0 || strcmp($entity->status, 'published') == 0)){
			$get_error_info='draft/autosave';
			return;
		} 


		// if we are publishing, or revising blogs then send out notification
		if (strcmp($object_subtype,'blog_revision') == 0 && strcmp($entity->status,'published') == 0) {
			$current_user = get_user($entity->getOwnerGUID());
			$subject = elgg_echo('cp_notify:subject:edit_content',array('The blog',gc_explode_translation($entity->title,'en'), $current_user->username),'en') . ' | ' . elgg_echo('cp_notify:subject:edit_content:m',array('Le blogue',gc_explode_translation($entity->title,'fr'), $current_user->username),'fr');
			$subject = htmlspecialchars_decode($subject,ENT_QUOTES);

			add_entity_relationship($entity->getOwnerGUID(), 'cp_subscribed_to_email', $entity->getGUID());
			add_entity_relationship($entity->getOwnerGUID(), 'cp_subscribed_to_site_mail', $entity->getGUID());

			$message = array(
				'cp_content' => $entity,
				'cp_user' => $current_user->username,
				'cp_msg_type' => 'cp_content_edit',
				'cp_fr_entity' => 'Ce blogue',
				'cp_en_entity' => 'blog',
			);

			if($entity->getContainerEntity() instanceof ElggGroup){
				$author_id = $object->getOwnerGUID();
				$content_id = $entity->getContainerGUID();
			}else{
				$author_id = $current_user->guid;
			}

			$author = $current_user;
			$content_entity = $entity;
			$get_error_info = 'blog revision or published';

			$watchers = get_subscribers($dbprefix, $author_id, $content_id);
			foreach ($watchers as $watcher) {
				$message['user_name'] = $watcher->username;

				$template = elgg_view('cp_notifications/email_template', $message);

				$recipient_user = get_user($watcher->guid);

				if (has_access_to_entity($entity, $recipient_user) && $entity->access_id != 0) {
					if (strcmp(elgg_get_plugin_user_setting('cpn_set_digest', $watcher->guid,'cp_notifications'), 'set_digest_yes') == 0)
						create_digest($author, $action_type, $content_entity, get_entity($watcher->guid));
					else{
						(elgg_is_active_plugin('phpmailer')) ? phpmailer_send($watcher->email, $watcher->name, $subject, $template, NULL, true) : mail($watcher->email, $subject, $template, cp_get_headers());
						count_email_types($message['cp_en_entity']);
					}
				
					if (check_entity_relationship($watcher->guid, 'cp_subscribed_to_site_mail', $entity->getContainerGUID()))
						messages_send($subject, $template, $watcher->guid, $site->guid, 0, true, false);
				}
			}
			return true;
		}


		// checks for condition if the content being modified is a page or task
		if (strcmp($object_subtype,'page') == 0 || strcmp($object_subtype,'page_top') == 0 || strcmp($object_subtype,'task') == 0 || strcmp($object_subtype,'task_top') == 0) {
			$current_user = get_user($object->owner_guid);
			$subject = elgg_echo('cp_notify:subject:edit_content',array('The page', gc_explode_translation($entity->title,'en'), $current_user->username),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:edit_content:f',array('La page', gc_explode_translation($entity->title,'fr'), $current_user->username),'fr');

			$subject = htmlspecialchars_decode($subject,ENT_QUOTES);

			$message = array(
				'cp_content' => $entity,
				'cp_user' => $current_user->username,
				'cp_msg_type' => 'cp_content_edit',
				'cp_fr_entity' => 'Cette page',
				'cp_en_entity' => 'page',
			);

			$author = $current_user;
			$content_entity = $entity;
			$get_error_info = 'page, page top';			

			$watchers = get_subscribers($dbprefix, $current_user->guid, $entity->guid);

			foreach ($watchers as $watcher) {
				$message['user_name'] = $watcher->username;
				$template = elgg_view('cp_notifications/email_template', $message);
				$recipient_user = get_user($watcher->guid);

				if (has_access_to_entity($entity, $recipient_user) /*&& $object->access_id != 0*/) {

					if (strcmp(elgg_get_plugin_user_setting('cpn_set_digest', $watcher->guid,'cp_notifications'),'set_digest_yes') == 0) {

						create_digest($author, $action_type, $content_entity, get_entity($watcher->guid));
					}
					else {
						(elgg_is_active_plugin('phpmailer')) ? phpmailer_send( $watcher->email, $watcher->name, $subject, $template, NULL, true ) : mail($watcher->email, $subject, $template, cp_get_headers());
						count_email_types($message['cp_en_entity']);
					}


					if (check_entity_relationship($watcher->guid, 'cp_subscribed_to_site_mail', $entity->getContainerGUID())) {
						$site_template = elgg_view('cp_notifications/site_template', $message);
						messages_send($subject, $site_template, $watcher->guid, $site->guid, 0, true, false);
					}
				}
			}
			return true;
		}
		
	} else {

		/// LIKES TO COMMENTS AND DISCUSSION REPLIES
    	$content_entity = get_entity($object->entity_guid); 			// get the comment object
		$comment_author = get_user($content_entity->owner_guid); 		// get the user who made the comment
		$content = get_entity($content_entity->getContainerGUID());		// get the location of comment
		$content_title = $content->title; 									// get title of content
		$liked_by = get_user($object->owner_guid); 							// get user who liked comment

		$action_type = "post_likes";

		$to_recipients = array();
		$to_recipients_site = array();
		$get_error_info = '';

	    switch ($type_of_like) {
	    	case 'group':
	    		$group_name_en = htmlspecialchars(filter_tags(htmlspecialchars_decode(gc_explode_translation($content_entity->name, 'en'))));
	    		$group_name_fr = htmlspecialchars(filter_tags(htmlspecialchars_decode(gc_explode_translation($content_entity->name, 'fr'))));

	    		$subject = elgg_echo(elgg_echo('cp_notify:subject:likes_group', array($liked_by->name, $group_name_en), 'en'));
	    		$subject .= elgg_echo(elgg_echo('cp_notify:subject:likes_group', array($liked_by->name, $group_name_fr), 'fr'));

	    		$message = array(
	    			'cp_liked_by' => $liked_by->name,
	    			'cp_group' => $content_entity->name,
	    			'cp_group_link' => $content_entity->getURL(),
	    			'cp_msg_type' => 'cp_like_group'
	    		);

	    		$group_owner = $content_entity->getOwnerEntity();
	    		$action_type = 'like_group';

	    		if (strcmp(elgg_get_plugin_user_setting('cpn_likes_email', $group_owner->getGUID(),'cp_notifications'),'likes_email') == 0)
					$to_recipients[$group_owner->getGUID()] = $group_owner;
					$get_error_info = 'group';

    			if (strcmp(elgg_get_plugin_user_setting('cpn_likes_site', $group_owner->getGUID(),'cp_notifications'),'likes_site') == 0)
					$to_recipients_site[$group_owner->getGUID()] = $group_owner;
					$get_error_info = 'group';

	    		break;

	    	case 'comment':

	    		$content_title_en = gc_explode_translation($content_title, 'en');
	    		$content_title_fr = gc_explode_translation($content_title, 'fr');

	    		$subject = elgg_echo('cp_notify:subject:likes_comment', array($liked_by->name, $content_title_en),'en');
	    		$subject .= ' | '.elgg_echo('cp_notify:subject:likes_comment',array($liked_by->name, $content_title_fr),'fr');

	    		$message = array(
	    			'cp_liked_by' => $liked_by->name,
	    			'cp_comment_from' => $content_title,
	    			'content_url' => $content->getURL(),
					'cp_msg_type' => 'cp_likes_comments',
				);

	    		$author = $liked_by;
	    		$action_type = "like_comment";

	    		if (strcmp(elgg_get_plugin_user_setting('cpn_likes_email', $comment_author->getGUID(),'cp_notifications'),'likes_email') == 0)
					$to_recipients[$comment_author->getGUID()] = $comment_author;
					$get_error_info = 'comment';

    			if (strcmp(elgg_get_plugin_user_setting('cpn_likes_site', $comment_author->getGUID(),'cp_notifications'),'likes_site') == 0)
					$to_recipients_site[$comment_author->getGUID()] = $comment_author;
					$get_error_info = 'comment';
	    		break;

	    	case 'discussion_reply':

	    		$content_title_en = gc_explode_translation($content_title, 'en');
	    		$content_title_fr = gc_explode_translation($content_title, 'fr');

	    		$subject = elgg_echo('cp_notify:subject:likes_discussion',array($liked_by->name, $content_title_en),'en');
	    		$subject .= ' | '.elgg_echo('cp_notify:subject:likes_discussion',array($liked_by->name, $content_title_fr),'fr');

				$message = array(
					'cp_liked_by' => $liked_by->name,
					'cp_comment_from' => $content_title,
					'content_url' => $content->getURL(),
					'cp_msg_type' => 'cp_likes_topic_replies',
				);
				$author = $liked_by;
				$action_type = "like_reply";

	    		if (strcmp(elgg_get_plugin_user_setting('cpn_likes_email', $comment_author->getGUID(),'cp_notifications'),'likes_email') == 0)
					$to_recipients[$comment_author->getGUID()] = $comment_author;
					$get_error_info = 'discussion_reply';
    			if (strcmp(elgg_get_plugin_user_setting('cpn_likes_site', $comment_author->getGUID(),'cp_notifications'),'likes_site') == 0)
					$to_recipients_site[$comment_author->getGUID()] = $comment_author;
					$get_error_info = 'discussion_reply';
	    		break;


	    	default:
	    		$type_of_like = 'user_update';
		    	if ($liked_content instanceof ElggUser) {

					// cyu - there doesn't seem to be any differentiation between updated avatar and colleague connection
		    		$liked_by = get_user($object->owner_guid); // get user who liked comment


		    		$subject = elgg_echo('cp_notify:subject:likes_user_update',array($liked_by->name),'en') . ' | ' . elgg_echo('cp_notify:subject:likes_user_update',array($liked_by->name),'fr');
		    		$message = array(
						'cp_msg_type' => 'cp_likes_user_update',
						'cp_liked_by' => $liked_by->name
					);
					$to_recipients[$liked_content->guid] = $liked_content;
					$get_error_info = 'user_update_if_liked_content';


		    	} else {

		    		$type_of_like = 'content';
		    		$liked_by = get_user($object->owner_guid); // get user who liked content
		    		$content = get_entity($object->entity_guid);

		    		$content_entity = $content;
		    		$author = $liked_by;

		    		$content_title_en = gc_explode_translation($content->title, 'en');
		    		$content_title_fr = gc_explode_translation($content->title, 'fr');

		    		// cyu - patching issue #323 (liking wire post)
		    		if ($content->getSubtype() === 'thewire') {
		    			$subject = elgg_echo('cp_notify:subject:likes_wire',array($liked_by->name, $content_title_en),'en') . ' | ' . elgg_echo('cp_notify:subject:likes_wire',array($liked_by->name, $content_title_fr), 'fr');
		    			$content_subtype = 'thewire';

		    		} else {
		    			$subject = elgg_echo('cp_notify:subject:likes',array($liked_by->name, $content_title_en),'en') . ' | ' . elgg_echo('cp_notify:subject:likes',array($liked_by->name, $content_title_fr), 'fr');
		    			$content_subtype = '';
		    		}

		    		$message = array(
		    			'cp_subtype' => $content_subtype,
						'cp_msg_type' => 'cp_likes_type',
						'cp_liked_by' => $liked_by->name,
						'cp_comment_from' => $content->title,
						'cp_description' => $content->description,
						'cp_content_url' => $content->getURL(),
					);

		    		if (strcmp(elgg_get_plugin_user_setting('cpn_likes_email', $content->getOwnerGUID(),'cp_notifications'), 'likes_email') == 0)
						$to_recipients[$content->getOwnerGUID()] = $content->getOwnerEntity();
						$get_error_info = 'content';

	    			if (strcmp(elgg_get_plugin_user_setting('cpn_likes_site', $content->getOwnerGUID(),'cp_notifications'), 'likes_site') == 0)
						$to_recipients_site[$content->getOwnerGUID()] = $content->getOwnerEntity();
						$get_error_info = 'content';
		    	}
	    		break;

		} // end switch statement
	}

	$subject = htmlspecialchars_decode($subject,ENT_QUOTES);

	if (is_array($to_recipients)) {
		// send notification out via email
		foreach ($to_recipients as $to_recipient_id => $to_recipient) {
		
			$message['user_name'] = get_user($to_recipient->guid)->username;

			$recipient_user = get_user($to_recipient->guid);

			if($recipient_user->gcdeactivate)
				continue;

			if ($liked_by->guid == $entity->getOwnerGUID() && $to_recipient->guid == $liked_by->guid)
				continue;

			if ($object->access_id == 1 || $object->access_id == 2 || $content_entity->getType() === 'group' || $action_type === 'post_likes') {

				if (strcmp(elgg_get_plugin_user_setting('cpn_set_digest', $to_recipient->guid,'cp_notifications'),'set_digest_yes') == 0)
					create_digest($author, $action_type, $content_entity, $to_recipient);

				else {
					$template = elgg_view('cp_notifications/email_template', $message);

					if (elgg_is_active_plugin('phpmailer')) {
						phpmailer_send( $to_recipient->email, $to_recipient->name, $subject, $template, NULL, true );
						count_email_types($message['cp_msg_type']);
					}
					else
						mail($to_recipient->email, $subject, $template, cp_get_headers());
				}
			}
		}
	}

	if (is_array($to_recipients_site)) {
		// send notification out via site
		foreach ($to_recipients_site as $to_recipient_id => $to_recipient) {
			$site_template = elgg_view('cp_notifications/site_template', $message);
			$recipient_user = get_user($to_recipient->guid);

			if (($object->access_id == 1 || $object->access_id == 2 || $content_entity->getType() === 'group' || $action_type === 'post_likes')  && 
				(strcmp(elgg_get_plugin_user_setting('cpn_set_digest', $to_recipient->guid,'cp_notifications'),'set_digest_yes') !== 0)) {

				messages_send($subject, $site_template, $to_recipient->guid, $site->guid, 0, true, false);
			}

		}
	}

	// register the error, if either of the arrays are not populated
	if (!is_array($to_recipients) || !is_array($to_recipients_site)) {
		$error_message = "error: in cp_create_notification(), \$to_recipients or \$to_recipients_site is not array"."\r\n"."Owner_entity = ".($content->getOwnerEntity()?print_r($content->getOwnerEntity(),true) : 'N/A');
		if ($comment_author) {
			$error_message .= 'Comment author= '. print_r($comment_author, true);
		}
		if ($group_owner) {
			$error_message .= 'Group owner= ' . print_r($group_owner, true);
		}
		$error_message .= 'State: '.$get_error_info; //from which state the error is from
		notification_logging($error_message);
	}

} // end of function



/**
 * function cp_create_notification is an event handler, invokes everytime a new entity is created
 * This contains the notifications for new content posted on GCconnex
 *
 * @param string $event		the name of the event
 * @param string $type		the type of object (eg "user", "group", ...)
 * @param mixed $object		the object/entity of the event
 */
function cp_create_notification($event, $type, $object) {

	$do_not_subscribe_list = array('mission-posted', 'file', 'tidypics_batch', 'hjforum', 'hjforumcategory','hjforumtopic', 'messages', 'hjforumpost', 'site_notification', 'poll_choice','blog_revision','widget','folder','c_photo', 'cp_digest','MySkill', 'education', 'experience', 'poll_choice3');

	// since we implemented the multi file upload, each file uploaded will invoke this hook once to many times (we don't allow subtype file to go through, but check the event)
	if ($object instanceof ElggObject && $event !== 'single_file_upload') {

		if (in_array($object->getSubtype(), $do_not_subscribe_list)) 
			return true;		
	} else {

		if ('single_zip_file_upload' !== $event && 'multi_file_upload' !== $event && 'single_file_upload' !== $event)
			return true;
	}

	elgg_load_library('elgg:gc_notification:functions');
	$dbprefix = elgg_get_config('dbprefix');
	$no_notification = false;
	$site = elgg_get_site_entity();
	$to_recipients = array();
	$subject = "";

	$switch_case = $event;
	if ($object instanceof ElggObject)
		$switch_case = $object->getSubtype();	

	switch ($switch_case) {


		/// invoked when zipped file upload function is used (files_tools/lib/functions.php)
		case 'single_zip_file_upload':

			$entity = get_entity($object['forward_guid']);
			if (elgg_instanceof('group', $entity)) {
				$file_forward_url = elgg_get_site_entity()->getURL()."file/group/{$object['forward_guid']}/all";
			} elseif (elgg_instanceof('user', $entity)) {
				$file_forward_url = elgg_get_site_entity()->getURL()."file/owner/{$entity->username}";
			} else {
				$file_forward_url = $entity->getURL();
			}

			$to_recipients = get_subscribers($dbprefix, elgg_get_logged_in_user_guid(), $entity->getGUID());
			$to_recipients_site = get_site_subscribers($dbprefix, elgg_get_logged_in_user_guid(), $entity->getGUID());

			$subject = elgg_echo('cp_notify_usr:subject:new_content2', array(elgg_get_logged_in_user_entity()->username, 'file'), 'en');
			$subject .= ' | '.elgg_echo('cp_notify_usr:subject:new_content2', array(elgg_get_logged_in_user_entity()->username, 'fichier', false), 'fr');

			$author = elgg_get_logged_in_user_entity();
			$message = array(
				'cp_topic' => $entity,
				'cp_msg_type' => 'zipped_file',
				'files_uploaded' => $object['files_uploaded'],
				'cp_topic_description_discussion' => 'Please view the files here',
				'cp_topic_description_discussion2' => 'SVP voir les fichiers ici',
			);

			
			$content_entity = $object['files_uploaded'];
			$object = get_entity($object['files_uploaded'][0]);
			$author = elgg_get_logged_in_user_entity();
			break;

		/// invoked when multiple file upload function is used
		case 'multi_file_upload':

			$entity = get_entity($object['forward_guid']);
			if (elgg_instanceof('group', $entity)) {
				$file_forward_url = elgg_get_site_entity()->getURL()."file/group/{$object['forward_guid']}/all";
			} elseif (elgg_instanceof('user', $entity)) {
				$file_forward_url = elgg_get_site_entity()->getURL()."file/owner/{$entity->username}";
			} else {
				$file_forward_url = $entity->getURL();
			}

			$author = elgg_get_logged_in_user_entity();
			$to_recipients = get_subscribers($dbprefix, elgg_get_logged_in_user_guid(), $entity->getGUID());
			$to_recipients_site = get_site_subscribers($dbprefix, elgg_get_logged_in_user_guid(), $entity->getGUID());

			$subject = elgg_echo('cp_notify_usr:subject:new_content2', array(elgg_get_logged_in_user_entity()->username, 'file'), 'en');
			$subject .= ' | '.elgg_echo('cp_notify_usr:subject:new_content2', array(elgg_get_logged_in_user_entity()->username, 'fichier', false), 'fr');
	
			$message = array(
				'cp_topic' => $entity,
				'cp_msg_type' => 'multiple_file',
				'files_information' => $entity,
				'files_uploaded' => $object['files_uploaded'], 
				'cp_msg_type' => 'multiple_file',
				'cp_topic_description_discussion' => 'Please view the files here',
				'cp_topic_description_discussion2' => 'SVP voir les fichiers ici',
			);

			
			$content_entity = $object['files_uploaded'];
			$object = get_entity($object['files_uploaded'][0]);
			$author = elgg_get_logged_in_user_entity();
			break;

		case 'discussion_reply':
		case 'comment':

			// if mentions plugin is enabled... check to see if there were any mentions
			$cp_mentioned_users = (elgg_is_active_plugin('mentions') && $object->getSubtype() !== 'messages') ? cp_scan_mentions($object) : "";

			// send mentioned users a notification
			if (sizeof($cp_mentioned_users) > 0 && is_array($cp_mentioned_users)) {
				for ($i = 0; $i < sizeof($cp_mentioned_users); $i++) {
					$cp_mentioned_user = $cp_mentioned_users[$i];
					$mentioned_user = get_user_by_username(substr($cp_mentioned_user, 1));

					if (!$mentioned_user || $mentioned_user->gcdeactivate)
						break;

					$subject = elgg_echo('cp_notify:subject:mention',array($object->getOwnerEntity()->name), 'en') .' | ' . elgg_echo('cp_notify:subject:mention',array($object->getOwnerEntity()->name), 'fr');
					$message = array(
						'cp_msg_type' => 'cp_mention_type',
						'cp_author' => $object->getOwnerEntity()->name,
						'cp_content_desc' => $object->description,
						'cp_link' => $object->getURL(),
						'cp_content' => $object,
					);
					$template = elgg_view('cp_notifications/email_template', $message);
					$user_setting = elgg_get_plugin_user_setting('cpn_mentions_email', $mentioned_user->guid, 'cp_notifications');

					if (strcmp($user_setting, 'mentions_email') == 0) {
						$user_setting = elgg_get_plugin_user_setting('cpn_set_digest', $mentioned_user->guid, 'cp_notifications');

						// send digest
						if (strcmp($user_setting, "set_digest_yes") == 0) {
							create_digest($object->getOwnerEntity(), "cp_mention", $object, $mentioned_user);

						// send email and site notification
						} else {

							if (elgg_is_active_plugin('phpmailer'))
								phpmailer_send( $mentioned_user->email, $mentioned_user->name, $subject, $template, NULL, true );
							else
								mail($mentioned_user->email,$subject,$template,cp_get_headers());
						}
					}

					$user_setting = elgg_get_plugin_user_setting('cpn_mentions_site', $mentioned_user->guid, 'cp_notifications');
					$site_template = elgg_view('cp_notifications/site_template', $message);
					if (strcmp($user_setting, 'mentions_site') == 0)
						messages_send($subject, $site_template, $mentioned_user->guid, $site->guid, 0, true, false);
				}
			}

			// retrieve all necessary information for notification
			$container_entity = $object->getContainerEntity();

			$user_comment = get_user($object->owner_guid);
			$topic_container = $container_entity->getContainerEntity();

			// comment or reply in a group
			if ($topic_container instanceof ElggGroup) {
				if (strcmp($object->getSubtype(), 'discussion_reply') == 0) {
					$subject = elgg_echo('cp_notify:subject:comments_discussion',array(gc_explode_translation($topic_container->name,'en')),'en');
					$subject .= ' | '.elgg_echo('cp_notify:subject:comments_discussion',array(gc_explode_translation($topic_container->name,'fr')),'fr');
				} else {
					$subject = elgg_echo('cp_notify:subject:comments',array(gc_explode_translation($topic_container->name,'en')),'en');
					$subject .= ' | '.elgg_echo('cp_notify:subject:comments',array(gc_explode_translation($topic_container->name,'fr')),'fr');
				}

			// comment or reply in a user
			} else {
				$entity_residence = 'usr';
				$subject = elgg_echo('cp_notify:subject:comments_user', array($topic_container->name), 'en');
				$subject .= ' | '.elgg_echo('cp_notify:subject:comments_user', array($topic_container->name), 'fr');
			}


			$message = array(
				'cp_container' => $entity_residence,
				'cp_user_comment' => $user_comment,
				'cp_topic' => $container_entity,
				'cp_topic_type' => cp_translate_subtype($container_entity->getSubtype()),
				'cp_comment' => $object,
				'cp_msg_type' => 'cp_reply_type',
			);

			// digest information purposes
			$content_entity = $container_entity;
			$author = $user_comment;

			$container = get_entity($container_entity->container_guid);

			// the user creating the content is automatically subscribed to it
			if (elgg_instanceof($container, 'group')) {
	 			if($container->isMember($user_comment)){
					add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_email', $container_entity->getGUID());
					add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_site_mail', $container_entity->getGUID());
				}
			} else {
				add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_email', $container_entity->getGUID());
				add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_site_mail', $container_entity->getGUID());
			}


			$to_recipients = get_subscribers($dbprefix, $object->getOwnerGUID(), $object->getContainerGUID());
			$to_recipients_site = get_subscribers($dbprefix, $object->getOwnerGUID(), $object->getContainerGUID());
			break;

		// micromissions / opportunities
		case 'mission':

			$job_type = $object->job_type;		// only need to get this once
			$role_type = $object->role_type;
			$job_type_ids = getMissionTypeMetastringid($job_type, $role_type);
			$opt_in_id = elgg_get_metastring_id('gcconnex_profile:opt:yes');

			// get users who want to be notified about new opportunities by site message and have opted in to this type of oppotrunity
			$op_siteusers = get_data("SELECT ps.id, ps.entity_guid as entity_guid FROM {$dbprefix}private_settings ps JOIN {$dbprefix}metadata md ON ps.entity_guid = md.entity_guid WHERE ps.name = 'plugin:user_setting:cp_notifications:cpn_opportunities_site' AND ps.value = 'opportunities_site' AND md.name_id = {$job_type_ids} AND md.value_id = {$opt_in_id}");

			foreach ($op_siteusers as $result) {
				$userid = $result->entity_guid;
				$user_obj = get_user($userid);
				$to_recipients_site[$userid] = $user_obj;
			}

			// get users who want to be notified about new opportunities by email and have opted in to this type of oppotrunity
			$op_emailusers = get_data("SELECT ps.id, ps.entity_guid as entity_guid FROM {$dbprefix}private_settings ps JOIN {$dbprefix}metadata md ON ps.entity_guid = md.entity_guid WHERE ps.name = 'plugin:user_setting:cp_notifications:cpn_opportunities_email' AND ps.value = 'opportunities_email' AND md.name_id = {$job_type_ids} AND md.value_id = {$opt_in_id}");

			foreach ($op_emailusers as $result) {
				$userid = $result->entity_guid;
				$user_obj = get_user($userid);
				$to_recipients[$userid] = $user_obj;
			}

			$message = array(
				'cp_topic' => $object,
				'cp_msg_type' => 'new_mission',
			);

			// digest information purposes
			$content_entity = $object;
			$author = $object->getOwnerEntity();

			$subject = elgg_echo('cp_new_mission:subject',array(),'en') . ' | ' . elgg_echo('cp_new_mission:subject',array(),'fr');

			// the user creating the content is automatically subscribed to it
			add_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_email', $object->getGUID());
			add_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_site_mail', $object->getGUID());
			break; 

		case 'single_file_upload':

		default:

			// cyu - there is an issue with regards to auto-saving drafts
			if (strcmp($object->getSubtype(),'blog') == 0) {
			$get_error_info='draft blog';
				
				if (strcmp($object->status,'draft') == 0 || strcmp($object->status,'unsaved_draft') == 0) return;
			}

			// the user creating the content is automatically subscribed to it (with exception that is not a widget, forum, etc..)
			$cp_whitelist = array('blog', 'bookmarks', 'poll', 'groupforumtopic', 'image', 'idea', 'page', 'page_top', 'thewire', 'task_top', 'question', 'answer', 'cp_wire_image','event_calendar');
			if (in_array($object->getSubtype(), $cp_whitelist)) {

				if ($object->getSubtype() == 'answer') {// subcribed to the question
					add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_email', $object->getContainerGUID());
					add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_site_mail', $object->getContainerGUID());
				}
				add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_email', $object->getGUID());
				add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_site_mail', $object->getGUID());
            }

			$user = get_user($object->owner_guid);
			$group = $object->getContainerEntity();

			$group_name = htmlspecialchars(filter_tags(htmlspecialchars_decode(gc_explode_translation($group->name,'en'))));
			$group_name2 = htmlspecialchars(filter_tags(htmlspecialchars_decode(gc_explode_translation($group->name,'fr'))));

			// fem and mas are different (so the subject should be reflected on which subtype is passed)
			$subtypes_gender_subject = array(

				'blog' => elgg_echo('cp_notify:subject:new_content_mas',array("blogue",$group_name2),'fr'),
				'bookmarks' => elgg_echo('cp_notify:subject:new_content_mas',array("signet",$group_name2),'fr'),
				'file' => elgg_echo('cp_notify:subject:new_content_mas',array("fichier",$group_name2),'fr'),
				'poll' => elgg_echo('cp_notify:subject:new_content_mas',array("sondage",$group_name2),'fr'),
				'event_calendar' => elgg_echo('cp_notify:subject:new_content_mas',array("nouvel événement",$group_name2),'fr'),
				'album' => elgg_echo('cp_notify:subject:new_content_mas',array("album d'image",$group_name2),'fr'),
				'groupforumtopic' => elgg_echo('cp_notify:subject:new_content_fem',array("discussion",$group_name2),'fr'),
				'image' => elgg_echo('cp_notify:subject:new_content_fem',array("image",$group_name2),'fr'),
				'idea' => elgg_echo('cp_notify:subject:new_content_fem',array("idée",$group_name2),'fr'),
				'page' => elgg_echo('cp_notify:subject:new_content_fem',array("page",$group_name2),'fr'),
				'page_top' => elgg_echo('cp_notify:subject:new_content_fem',array("page",$group_name2),'fr'),
				'task_top' => elgg_echo('cp_notify:subject:new_content_fem',array("task",$group_name2),'fr'),
				'task' => elgg_echo('cp_notify:subject:new_content_fem',array("task",$group_name2),'fr'),
        		'question' => elgg_echo('cp_notify:subject:new_content_fem',array("question",$group_name2),'fr'),
        		'etherpad' => elgg_echo('cp_notify:subject:new_content_fem',array(elgg_echo('etherpad:single'),$group_name2),'fr')
			);

			// if there is something missing, we can use a fallback string
			$subj_gender = ($subtypes_gender_subject[$object->getSubtype()] == '') ? elgg_echo('cp_notify:subject:new_content_mas',array($user->name,$object->getSubtype(),$object->title),'fr') : $subtypes_gender_subject[$object->getSubtype()];

			// subscribed to content within a group
			if ($object->getContainerEntity() instanceof ElggGroup) {
				$subject = elgg_echo('cp_notify:subject:new_content',array(cp_translate_subtype($object->getSubtype()),$group_name),'en');
				$subject .= ' | '.$subj_gender;

				$guidone = $object->getContainerGUID();
				$author_id = $object->getOwnerGUID();
				$content_id = $object->getContainerGUID();

			// subscribed to users or friends
			} else {

				if (trim($object->title) === '') {

					/// check if poll_choice is found in the subtype
					if (strpos($object->getSubtype(), "poll_choice") !== false)
						return true;

					$subject = elgg_echo('cp_notify_usr:subject:new_content2',array($object->getOwnerEntity()->username,cp_translate_subtype($object->getSubtype())),'en');
					$subject .= ' | '.elgg_echo('cp_notify_usr:subject:new_content2',array($object->getOwnerEntity()->username,cp_translate_subtype($object->getSubtype(), false)),'fr');

				} else {

					if (strcmp($object->getSubtype(), 'hjforumpost') != 0 || strcmp($object->getSubtype(), 'hjforumtopic') != 0) {
						if ($object->getSubtype() == 'answer'){
							$question_guid = $object->getContainerGUID();
							$answer_entity = get_entity($question_guid);
					
							$subject = elgg_echo('cp_notify_usr:subject:new_content',array($object->getOwnerEntity()->username, cp_translate_subtype($object->getSubtype()), gc_explode_translation($answer_entity->title,'en')),'en');
							$subject .= ' | '.elgg_echo('cp_notify_usr:subject:new_content_f',array($object->getOwnerEntity()->username, cp_translate_subtype($object->getSubtype(), false), gc_explode_translation($answer_entity->title,'fr')),'fr');
						
						} else if ($object->getSubtype() == 'etherpad'){
							$subject = elgg_echo('cp_notify_usr:subject:new_content',array($object->getOwnerEntity()->username, elgg_echo('etherpad:single'), gc_explode_translation($object->title,'en')),'en');
							$subject .= ' | '.elgg_echo('cp_notify_usr:subject:new_content_f',array($object->getOwnerEntity()->username, elgg_echo('etherpad:single'), gc_explode_translation($object->title,'fr')),'fr');
						} else {
							
							$subject = elgg_echo('cp_notify_usr:subject:new_content',array($object->getOwnerEntity()->username, cp_translate_subtype($object->getSubtype()), gc_explode_translation($object->title,'en')),'en');
							$subject .= ' | '.elgg_echo('cp_notify_usr:subject:new_content',array($object->getOwnerEntity()->username, cp_translate_subtype($object->getSubtype(), false), gc_explode_translation($object->title,'fr')),'fr');
						}
					}
				}

				$guidone = $object->getOwnerGUID();
				$author_id = $object->getOwnerGUID();
				
				// Get guid of the question
				if($object->getSubtype = 'answer') {
						$content_id = $object->getContainerGUID();
				}
			}
	
			// client wants the html tags stripped from the notifications
			$object_description = ($object->description != strip_tags($object->description)) ? "" : $object->description;

			$message = array(
				'cp_topic' => $object,
				'cp_msg_type' => 'cp_new_type',
				'cp_topic_description_discussion' => $object->description,
				'cp_topic_description_discussion2' => $object->description2,
			);

			$content_entity = $object;
			$author = $object->getOwnerEntity();

			$to_recipients = get_subscribers($dbprefix, $author_id, $content_id);
			$to_recipients_site = get_site_subscribers($dbprefix, $author_id, $content_id);
			break;

	} // end of switch statement



	$notification_error_type = "";

	// check for empty subjects or empty content
	if (empty($subject)) return false;
	$subject = htmlspecialchars_decode($subject,ENT_QUOTES);

	/// send the email notification
	if (is_array($to_recipients)) {

		foreach ($to_recipients as $to_recipient) {

			$recipient_user = get_user($to_recipient->guid);
			//Nick - GCdeactivate - don't send notification
			if ($to_recipient->guid == $author->guid || $recipient_user->gcdeactivate)
				continue;

				$user_setting = elgg_get_plugin_user_setting('cpn_set_digest', $to_recipient->guid, 'cp_notifications');
				

				
					if (has_access_to_entity($object, $recipient_user) && $object->access_id != 0) {
				
					if (strcmp($user_setting, "set_digest_yes") == 0) {
						create_digest($author, $switch_case, $content_entity, get_entity($to_recipient->guid));
				
					} else {
				
						$template = elgg_view('cp_notifications/email_template', $message);
				
						if (elgg_is_active_plugin('phpmailer')){
							phpmailer_send( $to_recipient->email, $to_recipient->name, $subject, $template, NULL, true );
							count_email_types($message['cp_msg_type'] . $object->getSubtype());
						}
						else
							mail($to_recipient->email,$subject,$template,cp_get_headers());
					}
				}
			

		}
	}

	/// send site notifications
	if (is_array($to_recipients_site)) {
		
		foreach ($to_recipients_site as $to_recipient) {
			$user_setting = elgg_get_plugin_user_setting('cpn_set_digest', $to_recipient->guid, 'cp_notifications');
			$recipient_user = get_user($to_recipient->guid);

			// check to see if the author is the recipient or recipient has the digest enabled
			if ($to_recipient->guid == $author->guid || strcmp($user_setting, "set_digest_yes") == 0)
				continue;

			if (has_access_to_entity($object, $recipient_user) && $object->access_id != 0) {

				$site_template = elgg_view('cp_notifications/site_template', $message);
				messages_send($subject, $site_template, $to_recipient->guid, $site->guid, 0, true, false);
			}
		}
	}

	// register the error, if either of the arrays are not populated
	if (!is_array($to_recipients) || !is_array($to_recipients_site)) {
		$error_message = "error: in cp_create_notification(), \$to_recipients or \$to_recipients_site is not array"."\r\n"."Author_id = ".($object->owner_guid?$object->owner_guid : 'N/A')."\r\n"."Content_id = ".($object->container_guid?$object->container_guid : 'N/A')."\r\n"."Content_id = ".$object->getContainerGUID();

		notification_logging($error_message);

	}

}


function notification_logging($error_message) {
	// logging mechanism
	if (elgg_is_active_plugin('wet4')) {
		elgg_load_library('GCconnex_logging');
		$errStack = '';
		$errType = 'custom';
		gc_err_logging($error_message, $errStack, 'Notifications',$errType);
	}
}

/**
 * get all the users that are subscribed to a specified entity (content or user id)
 * and return the array of users
 *
 * @param string 			$dbprefix
 * @param integer 			$user_guid
 * @param optional integer 	$entity_guid

 * @param email vs site_mail
 * @return Array <ElggUser>

 */

function get_subscribers($dbprefix, $user_guid, $entity_guid = '') {
	$subscribed_to = ($entity_guid != '') ? $entity_guid : $user_guid;

	$query = "	SELECT DISTINCT u.guid, u.email, u.username, u.name
				FROM {$dbprefix}entity_relationships r LEFT JOIN {$dbprefix}users_entity u ON r.guid_one = u.guid
				WHERE r.guid_one <> {$user_guid} AND r.relationship = 'cp_subscribed_to_email' AND r.guid_two = {$subscribed_to}";

	return get_data($query);
}

function get_site_subscribers($dbprefix, $user_guid, $entity_guid = '') {
	$subscribed_to = ($entity_guid != '') ? $entity_guid : $user_guid;

	$query = " SELECT DISTINCT u.guid, u.email, u.username, u.name
	FROM {$dbprefix}entity_relationships r LEFT JOIN {$dbprefix}users_entity u ON r.guid_one = u.guid
	WHERE r.guid_one <> {$user_guid} AND r.relationship = 'cp_subscribed_to_site_mail' AND r.guid_two = {$subscribed_to}";

	return get_data($query);
}


/**
 * setup crontab either on a daily or weekly basis
 * get users who are subscribed to digest
 * run crontab, retrieve users, send digest, reset timer (update timestamp)
 *
 * @param string $hook    The name of the plugin hook
 * @param string $type    The type of the plugin hook
 * @param mixed  $value   The current value of the plugin hook
 * @param mixed  $params  Data passed from the trigger
 */
function cp_digest_weekly_cron_handler($hook, $entity_type, $return_value, $params) {
	echo "<p>Starting up the cron job for the Notifications (cp_notifications plugin)</p>";
	elgg_load_library('elgg:gc_notification:functions');
	
	initialize_queue('weekly');

	// TODO: write the functions above and rewrite the email handler below
	cp_digest_email_handler($hook, $entity_type, $return_value, $params, 'weekly');
}



/**
 * setup crontab either on a daily or weekly basis
 * get users who are subscribed to digest
 * run crontab, retrieve users, send digest, reset timer (update timestamp)
 *
 * @param string $hook    The name of the plugin hook
 * @param string $entity_type    The type of the plugin hook
 * @param mixed  $return_value   The current value of the plugin hook
 * @param mixed  $params  Data passed from the trigger
 */
function cp_digest_daily_cron_handler($hook, $entity_type, $return_value, $params) {
	echo "<p>Starting up the cron job for the Notifications (cp_notifications plugin)</p>";
	elgg_load_library('elgg:gc_notification:functions');

	initialize_queue('daily');

	cp_digest_email_handler($hook, $entity_type, $return_value, $params, 'daily');
}

/**
 * setup crontab either on a daily or weekly basis
 * get users who are subscribed to digest
 * run crontab, retrieve users, send digest, reset timer (update timestamp)
 *
 * @param string $hook    The name of the plugin hook
 * @param string $entity_type    The type of the plugin hook
 * @param mixed  $return_value   The current value of the plugin hook
 * @param mixed  $params  Data passed from the trigger
 */
function cp_digest_email_handler($hook, $entity_type, $return_value, $params, $cron_freq) {
	$dbprefix = elgg_get_config('dbprefix');

	while( $user_guid = dequeue() ) {
		$user = get_entity($user_guid);
		if($user->gcdeactivate)
			continue;
		$frequency = elgg_get_plugin_user_setting('cpn_set_digest_frequency', $user->guid, 'cp_notifications');

		if ($user instanceof ElggUser && strcmp($frequency,'set_digest_' . $cron_freq) == 0 ) {
			$digest_array = array();

			$query = "SELECT * FROM notification_digest WHERE user_guid = {$user->guid}";
			$digest_items = get_data($query);

			$language_preference = (strcmp(elgg_get_plugin_user_setting('cpn_set_digest_language', $user->guid, 'cp_notifications'),'set_digest_en') == 0) ? 'en' : 'fr';

			foreach ($digest_items as $digest_item) {

				// check to make sure that the string is encoded with base 64 or not (legacy)
				if (isJson($digest_item->notification_entry))
					$notification_entry = $digest_item->notification_entry;
				else
					$notification_entry = base64_decode($digest_item->notification_entry);


				if ($digest_item->entry_type === 'group') 
					$digest_array[$digest_item->entry_type][base64_decode($digest_item->group_name)][$digest_item->action_type][$digest_item->entity_guid] = $notification_entry;
				else
					$digest_array[$digest_item->entry_type][$digest_item->action_type][$digest_item->entity_guid] = $notification_entry;

			}

			$subject = elgg_echo('cp_newsletter:subject:' . $cron_freq,$language_preference);

			// if the array is empty, send the empty template
			if (sizeof($digest_array) > 0 || !empty($digest_array))
				$template = elgg_view('cp_notifications/newsletter_template', array('to' => $user, 'newsletter_content' => $digest_array));
			else
				$template = elgg_view('cp_notifications/newsletter_template_empty', array('to' => $user));


			/// e-mail providers can potentially break html codes because it exceeds a limit (set by the inbox)
			/// REFERENCE: https://stackoverflow.com/questions/12216228/html-email-annoying-line-breaking
			$template = str_replace("<", "\r\n<", $template);

			echo $template . "<br/><br/>";

			if (elgg_is_active_plugin('phpmailer'))
				phpmailer_send($user->email, $user->name, $subject, $template, NULL, true );
			else
				mail($user->email, $subject, $template, cp_get_headers());


			// delete and clean up the notification, already sent so we don't need to keep it anymore
			$query = "DELETE FROM notification_digest WHERE user_guid = {$user->getGUID()}";
			$result = delete_data($query);

			count_email_types("digest_$cron_freq");
		}
	}
}


/**
 * check if user has access then prepare the notification and send (if applicable)
 *
 * @param ElggObject					$entity			entity that has been created
 * @param array(guid, email, username)	$to_user		recipient
 * @param array(various)				$message		message that will be in the notification
 * @param int							$guid_two		author or group id (check if subscribe to friend or group)
 */
function cp_notification_preparation_send($entity, $to_user, $message, $guid_two, $subject) {

	$template = elgg_view('cp_notifications/email_template', $message);

	// TODO: fix up mission
	if (strcmp($entity->getSubtype(),'mission') == 0) {
		// send out emails
		if ($to_user->getGUID() != elgg_get_logged_in_user_guid()) { // prevents notification to be sent to the sender
			if ($to_user instanceof ElggUser) {
				if (elgg_is_active_plugin('phpmailer'))
					phpmailer_send( $to_user->email, $to_user->name, $subject, $template, NULL, true );
				else
					mail($to_user->email,$subject,$template,cp_get_headers());
			}

		} else {
			// check if user has access to the content (DO NOT send if user has no access to this object)

			if (has_access_to_entity($entity, $recipient_user) && $object->access_id != 0) {
				//  GCCON-175: assemble the email content with correct username (for notification page)
				$message['user_name'] = $to_user->username;

				// check if user subscribed to receiving notifications
				if (check_entity_relationship($to_user->guid, 'cp_subscribed_to_email', $guid_two))
				{
					if (elgg_is_active_plugin('phpmailer'))
						phpmailer_send( $to_user->email, $to_user->name, $subject, $template, NULL, true );
					else
						mail($to_user->email,$subject,$template,cp_get_headers());
				}

				// send a site notification
				if (check_entity_relationship($to_user->guid, 'cp_subscribed_to_site_mail', $guid_two)) {
					messages_send($subject, $template, $to_recipient->guid, $site->guid, 0, true, false);
				}
			} // end if (check for access)

		}
	}
}


/**
 * cp_send_new_password_request
 *
 * In order to modify core code, this action had to be overwritten.
 * This is a mirror image of the core function: /engine/classes/Elgg/PasswordService.php
 *
 * Only need to send an e-mail notification out, no need to send a site-mail
 *
 * @param ElggUser 	$user 	user entity
 */
function cp_send_new_password_request($user) {
	if (!$user instanceof ElggUser)
		return false;

	// generate code
	$code = generate_random_cleartext_password();
	$user->setPrivateSetting('passwd_conf_code', $code);
	$user->setPrivateSetting('passwd_conf_time', time());

	$link = elgg_get_site_url()."changepassword?u={$user->guid}&c={$code}";
	$ip_address = _elgg_services()->request->getClientIp();

	// we don't need to check if the plugin (cp_notifications) is enabled here
	$message = array(
		'cp_password_request_user' => $user->username,
		'cp_password_request_ip' => $ip_address,
		'cp_password_request_url' => $link,
		'cp_msg_type' => 'cp_forgot_password',
	);

	$subject = elgg_echo('cp_notify:subject:forgot_password', array(), "en");
	$subject .= ' | '.elgg_echo('cp_notify:subject:forgot_password', array(), "fr");
	$template = elgg_view('cp_notifications/email_template', $message);

	if (elgg_is_active_plugin('phpmailer'))
		phpmailer_send( $user->email, $user->name, $subject, $template );
	else
		mail($user->email,$subject,$template,cp_get_headers());
}


/*
 * cp_membership_request
 *
 * replaced the event (see init()) so we can send out notifications through this plugin instead
 *
 */
function cp_membership_request($event, $type, $object) { 	// MUST always be sending notification
	$request_user = get_user($object->guid_one); 			// user who sends request to join
	$group_request = get_entity($object->guid_two);			// group that is being requested

	$message = array(
		'cp_group_req_user' => $request_user,
		'cp_group_req_group' => $group_request,
		'cp_msg_type' => 'cp_closed_grp_req_type',
	);
	$template = elgg_view('cp_notifications/email_template', $message);
	$subject = elgg_echo('cp_notify:subject:group_request',array($request_user->name, gc_explode_translation($group_request->name,'en')),'en');
	$subject .= ' | '.elgg_echo('cp_notify:subject:group_request',array($request_user->name, gc_explode_translation($group_request->name,'fr')),'fr');

	$to_user = get_user($group_request->owner_guid);
	if (elgg_is_active_plugin('phpmailer')) {
		phpmailer_send( $to_user->email, $to_user->name, $subject, $template, NULL, true );
	} else {
		mail($to_user->email,$subject,$template,cp_get_headers());
	}
	messages_send($subject, $template, $to_user->guid, elgg_get_site_entity()->guid, 0, true, false);
}




/**
 * intercepts all email and stops emails from sending
 *
 * @param string $hook    The name of the plugin hook
 * @param string $type    The type of the plugin hook
 * @param mixed  $value   The current value of the plugin hook
 * @param mixed  $params  Data passed from the trigger
 */
function cpn_email_handler_hook($hook, $type, $notification, $params) {
	return false;
}


/**
 * implements the icons (likes, in this case) within the context of the entity
 * TODO: make the likes button act as AJAX
 *
 * @param string $hook    The name of the plugin hook
 * @param string $type    The type of the plugin hook
 * @param mixed  $value   The current value of the plugin hook
 * @param mixed  $params  Data passed from the trigger
 *
 * @return mixed if not null, this will be the new value of the plugin hook
 */
function notify_entity_menu_setup($hook, $type, $return, $params) {
	$entity = $params['entity'];
	$do_not_subscribe_list = array('comment','discussion_reply','widget');
	if (elgg_in_context('widgets') || in_array($entity->getSubtype(), $do_not_subscribe_list))  return $return;

	// cyu - check for everything to put the bell thingy (xor)
	$allow_subscription = false;
	if ( $entity->getContainerEntity() instanceof ElggGroup ) {
		$allow_subscription = ($entity->getContainerEntity()->isMember(elgg_get_logged_in_user_entity()) == 1 ) ? true : false;

	} else if ($entity instanceof ElggGroup) {
		$allow_subscription =  ($entity->isMember(elgg_get_logged_in_user_entity()) == 1 ) ? true : false;

	} else if ( $entity->getContainerEntity() instanceof ElggUser )
		$allow_subscription = true;

	if ($entity instanceof ElggGroup) {
		$entType = 'group';
		if($entity->title3){
				$entName = gc_explode_translation($entity->title3, get_current_language());
		}else{
				$entName = $entity->name;
		}
	} else {
		if(!in_array($entity->getSubtype(), array('comment', 'discussion_reply', 'thewire'))){
			if($entity->title3){
					$entName = gc_explode_translation($entity->title3, get_current_language());
			}else{
					$entName = $entity->title;
			}
		} else {
			$entName = $entity->getOwnerEntity()->name;
		}
		$entType = $entity->getSubtype();
	}

	if ($allow_subscription && elgg_is_logged_in()) {
	    if ( check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_email', $entity->getGUID()) || check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_site_mail', $entity->getGUID()) ) {


			$bell_status = (elgg_is_active_plugin('wet4')) ? '<i class="icon-unsel fa fa-lg fa-bell"><span class="wb-inv">'.elgg_echo('entity:unsubscribe:link:'.$entType, array($entName)).'</span></i>' : elgg_echo('cp_notify:stop_subscribe');


		    $return[] = ElggMenuItem::factory(array(
			    'name' => 'unset_notify',
			    'href' => elgg_add_action_tokens_to_url("/action/cp_notify/unsubscribe?guid={$entity->guid}"),
			    'text' => $bell_status,
			    'title' => elgg_echo('cp_notify:unsubBell'),
			    'priority' => 1000,
			    'class' => 'bell-subbed',
			    'item_class' => ''
		    ));

	    } else {

		    $bell_status = (elgg_is_active_plugin('wet4')) ? '<i class="icon-unsel fa fa-lg fa-bell-slash-o"><span class="wb-inv">'.elgg_echo('entity:subscribe:link:'.$entType, array($entName)).'</span></i>' : elgg_echo('cp_notify:start_subscribe');


		    $return[] = ElggMenuItem::factory(array(
			    'name' => 'set_notify',
			    'href' => elgg_add_action_tokens_to_url("/action/cp_notify/subscribe?guid={$entity->guid}"),
			    'text' => $bell_status,
			    'title' => elgg_echo('cp_notify:subBell'),
			    'priority' => 1000,
			    'class' => '',
			    'item_class' => ''
		    ));
		}
	}
	return $return;
}

