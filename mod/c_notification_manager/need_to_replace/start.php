<?php

// initialize the plugin
elgg_register_event_handler('init', 'system', 'c_notification_manager_init');

function c_notification_manager_init()
{	
	unregister_notification_handler('email', 'email_notify_handler');
	register_notification_handler('email', 'c_email_notify_handler');
	register_plugin_hook('cron', 'minute', 'object_notification_cron');
	$action_path = elgg_get_plugins_path() . 'c_notification_manager/actions/c_notification_manager';
	elgg_register_action('c_notification_manager/flush_logging', "$action_path/flush_logging.php");
	elgg_register_action('c_notification_manager/purge_all_notifications', "$action_path/purge_all_notifications.php");
	elgg_register_action('c_notification_manager/purge_all_invalid_notifications', "$action_path/purge_all_invalid_notifications.php");
}

function c_email_notify_handler(ElggEntity $from, ElggUser $to, $subject, $message, array $params = NULL) 
{
	$notify_time = new DateTime();

	$log = fopen(elgg_get_plugins_path(). "/c_notification_manager/cronjob_logging.txt", 'a');
	fwrite($log,  '[' . date_format($notify_time, 'Y-m-d H:i:s') . '] email notifier invoked'. "\r\n" );
	fclose($log);

	global $CONFIG;


	if (!$from) {
		$msg = elgg_echo('NotificationException:MissingParameter', array('from'));
		throw new NotificationException($msg);
	}
	if (!$to) {
		$msg = elgg_echo('NotificationException:MissingParameter', array('to'));
		throw new NotificationException($msg);
	}
	if ($to->email == "") {
		$msg = elgg_echo('NotificationException:NoEmailAddress', array($to->guid));
		throw new NotificationException($msg);
	}

	// To
	$to = $to->email;

	// From
	$site = elgg_get_site_entity();
	// If there's an email address, use it - but only if its not from a user.
	if (!($from instanceof ElggUser) && $from->email) {
		$from = $from->email;
	} else if ($site && $site->email) {
		// Use email address of current site if we cannot use sender's email
		$from = $site->email;
	} else {
		// If all else fails, use the domain of the site.
		$from = 'noreply@' . get_site_domain($CONFIG->site_guid);
	}

	$session_guid=elgg_get_logged_in_user_guid();
	$object = $from;

    if (strstr($message, 'uservalidationbyemail') || strstr($message, 'resetpassword') || strstr($_SERVER["HTTP_REFERER"], 'resetpassword')) {
            elgg_log('cyu - sending out validation email...', 'NOTICE');
            elgg_log('cyu - [to:'.$to.'][from:'.$from.'][subject:'.$subject.'][message:'.$message.']', 'NOTICE');
            $check_success = elgg_send_email($from, $to, $subject, $message);
            //elgg_log('cyu - sent?'.$check_success, 'NOTICE');
            return $check_success;
    }


	elgg_log('cyu - queue --> [to:'.$to.'][from:'.$from.'][subject:'.$subject.'][message:'.$message.']', 'NOTICE');

	$c_obj = new ElggObject();
	$c_obj->subtype = 'gc_notification';
	$c_obj->title = $subject;
	$c_obj->description = $message;
	$c_obj->save();
	$c_obj->objet = $to.'|'.$from;
	$c_obj->type = 'object';
	$c_obj->event = 'create';
	$c_obj->submitter_guid = $session_guid;
	$c_obj->processed = false;
	//$c_obj->message = $subject.'|'.$message;
	
 	return true;
}

function object_notification_cron($hook, $entity_type, $returnvalue, $params)
{
	//elgg_log('cyu - object_notification invoked', 'NOTICE');
	/*++++++++++++++++++++++++++++++++++++++++ AUTHENTICATION START ++++++++++++++++++++++++++++++++++++++++*/
	$c_username = elgg_get_plugin_setting('c_user', 'c_notification_manager');
	$c_password = elgg_get_plugin_setting('c_pass', 'c_notification_manager');

	$username = $c_username;
	$password = $c_password;

	if ($user = authenticate($username,$password))
		$result = login($user,true);

	if ($result != 1)
	{
		//elgg_log('cyu - authentication failed, please provide valid account', 'NOTICE');
		return;
	}
	/*+++++++++++++++++++++++++++++++++++++++++ AUTHENTICATION END +++++++++++++++++++++++++++++++++++++++++*/

	// retrieving entity object from the database
	$resultset = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'gc_notification'));

	$notify_time = new DateTime();

	if (count($resultset) > 0)
	{
		foreach($resultset as $result)
		{
			//elgg_log('cyu - preparing to send out notifications', 'NOTICE');
			$information = explode('|', $result->message);
			$addresses = explode('|', $result->objet);
			//elgg_log('cyu - ++++++++++++START+++++++++++++++++++++++', 'NOTICE');
			//elgg_log('cyu - to:'.$addresses[0], 'NOTICE');
			//elgg_log('cyu - from:'.$addresses[1], 'NOTICE');
			//elgg_log('cyu - subject:'.$result->title, 'NOTICE');
			//elgg_log('cyu - body:'.$result->description, 'NOTICE');
			//elgg_log('cyu - +++++++++++++END++++++++++++++++++++++++', 'NOTICE');

			/* ++++++++++++++++++++++++++++ LOGGING PURPOSES +++++++++++++++++++++++++++++++++++++++ */
			$filename = 'cronjob_logging.txt';
			if (!file_exists($filename)) {
				$log = fopen(elgg_get_plugins_path()  . "/c_notification_manager/cronjob_logging.txt", 'a');
				fwrite($log,  '[' . date_format($notify_time, 'Y-m-d H:i:s') . '] preparing to send...'.$addresses[0]. "\r\n" );
				fclose($log);
			}

			$to_user = $addresses[0];
			$from_user = $addresses[1];
			$subject = $result->title;
			$body = $result->description;

			elgg_log('cyu - [to:'.$to_user.'][from:'.$from_user.'][subject:'.$result->title.'][message:'.$result->description.']', 'NOTICE');

			elgg_send_email($from_user, $to_user, $result->title, $result->description);

			$log = fopen(elgg_get_plugins_path()  . "/c_notification_manager/cronjob_logging.txt", 'a');
			fwrite($log,  '[' . date_format($notify_time, 'Y-m-d H:i:s') . '] email sent to...'.$addresses[0]. "\r\n" );
			fclose($log);

			//elgg_log('cyu - notification is sent', 'NOTICE');

			$result->delete();
		}
	}
	return 'GCconnex has processed notifications to users successfully';
}

function user_isValid($username, $password)
{
	$authenticate_user = elgg_authenticate($username,$password);
	$user = get_user_by_username($username);
	if (!$authenticate_user)
		return $authenticate_user;
	else 
		return $user;
}

function user_isAdmin(ElggUser $user)
{
	return $user->isAdmin();
}