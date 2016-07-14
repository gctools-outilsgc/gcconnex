<?php
/**
 * PHPMailer Plugin
 * 
 * @package PHPMailer
 * @license Lesser General Public License (LGPL)
 * @author Cash Costello
 * @copyright Cash Costello 2008-2011
 */


elgg_register_event_handler('init', 'system', 'phpmailer_init');

/**
 * initialize the phpmailer plugin
 */
function phpmailer_init() {
	/*if (elgg_get_plugin_setting('phpmailer_override', 'phpmailer') != 'disabled') {
		register_notification_handler('email', 'phpmailer_notify_handler');
		elgg_register_plugin_hook_handler('email', 'system', 'phpmailer_mail_override');
	}*/
}

/**
 * Send a notification via email using phpmailer
 *
 * @param ElggEntity $from The from user/site/object
 * @param ElggUser $to To which user?
 * @param string $subject The subject of the message.
 * @param string $message The message body
 * @param array $params Optional parameters (not used)
 * @return bool
 */
function phpmailer_notify_handler(ElggEntity $from, ElggUser $to, $subject, $message, array $params = NULL) {

	if (!$from) {
		throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'from'));
	}

	if (!$to) {
		throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'to'));
	}

	if ($to->email == "") {
		throw new NotificationException(sprintf(elgg_echo('NotificationException:NoEmailAddress'), $to->guid));
	}


	$from_email = phpmailer_extract_from_email($from);

	$site = elgg_get_site_entity();
	$from_name = $site->name;


	return phpmailer_send($from_email, $from_name, $to->email, '', $subject, $message);
}

/**
 * Overrides the default email send method of Elgg
 * @note Will need to add code to handle from and to if using: name <email>
 */
function phpmailer_mail_override($hook, $entity_type, $returnvalue, $params) {
	return phpmailer_send(
			$params["from"],
			$params["from"],
			$params["to"],
			'',
			$params["subject"],
			$params["body"]);
}

/**
 * Determine the best 'from' email address
 *
 * This is a stupid function pulled from original Elgg code
 *
 * @param  ElggEntity The entity sending the message
 * @return string with email address
 */
function phpmailer_extract_from_email($from) {
	$from_email = '';
	$site = elgg_get_site_entity();
	// If there's an email address, use it - but only if its not from a user.
	if ($from->email && !($from instanceof ElggUser)) {
		$from_email = $from->email;
	// Has the current site got a from email address?
	} else if ($site && $site->email) {
		$from_email = $site->email;
	// If we have a url then try and use that.
	} else if (isset($from->url)) {
		$breakdown = parse_url($from->url);
		$from_email = 'noreply@' . $breakdown['host'];
	// If all else fails, use the domain of the site.
	} else {
		$from_email = 'noreply@' . get_site_domain($site->guid);
	}
	
	return $from_email;
}

/**
 * Send an email using phpmailer
 *
 * @param string $from       From address
 * @param string $from_name  From name
 * @param string $to         To address
 * @param string $to_name    To name
 * @param string $subject    The subject of the message.
 * @param string $body       The message body
 * @param array  $bcc        Array of address strings
 * @param bool   $html       Set true for html email, also consider setting
 *                           altbody in $params array
 * @param array  $files      Array of file descriptor arrays, each file array
 *                           consists of full path and name
 * @param array  $params     Additional parameters
 * @return bool
 */
function phpmailer_send($to, $to_name, $subject, $body, array $bcc = NULL, $html = true, array $files = NULL, array $params = NULL) {
	
	
require_once elgg_get_plugins_path() . '/phpmailer/vendors/class.phpmailer.php';

 

$phpmailer = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch

 
  // CONFIGURE SERVER INFORMATION defaults

  $phpmailer->IsSMTP(); // telling the class to use SMTP

  $phpmailer->Host       = elgg_get_plugin_setting('phpmailer_host', 'phpmailer'); // SMTP server

  $phpmailer->Port       = elgg_get_plugin_setting('ep_phpmailer_port', 'phpmailer'); // SMTP server port

  $phpmailer->SMTPAuth   = true;

  $phpmailer->SMTPSecure = "tls";

  $phpmailer->Username = elgg_get_plugin_setting('phpmailer_username', 'phpmailer');

  $phpmailer->Password = elgg_get_plugin_setting('phpmailer_password', 'phpmailer');

  $phpmailer->SetFrom( elgg_get_plugin_setting('phpmailer_from_email', 'phpmailer'), elgg_get_plugin_setting('phpmailer_from_name', 'phpmailer') );

	/*if (!$from) {
		throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'from'));
	}*/

	if (!$to && !$bcc) {
		throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'to'));
	}

	if (!$subject) {
		throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'subject'));
	}

	// set line ending if admin selected \n (if admin did not change setting, null is returned)
	if (elgg_get_plugin_setting('nonstd_mta', 'phpmailer')) {
		$phpmailer->LE = "\n";
	} else {
		$phpmailer->LE = "\r\n";
	}

	////////////////////////////////////
	// Format message
	$phpmailer->SMTPSecure = "tls";
	$phpmailer->SMTPDebug = 0; //Set to 1 for debugging information

	$phpmailer->ClearAllRecipients();
	$phpmailer->ClearAttachments();

	// Set the from name and email
	//$phpmailer->From = $from;
	//$phpmailer->FromName = $from_name;

	// Set destination address
	if (isset($to)) {
		$phpmailer->AddAddress($to, $to_name);
	}

	// set bccs if exists
	if ($bcc && is_array($bcc)) {
		foreach ($bcc as $address)
			$phpmailer->AddBCC($address);
	}

	$phpmailer->Subject = $subject;

	if (!$html) {
		$phpmailer->CharSet = 'utf-8';
		$phpmailer->IsHTML(false);
		if ($params && array_key_exists('altbody', $params)) {
			$phpmailer->AltBody = $params['altbody'];
		}

		$trans_tbl = get_html_translation_table(HTML_ENTITIES);
		$trans_tbl[chr(146)] = '&rsquo;';
		foreach ($trans_tbl as $k => $v) {
			$ttr[$v] = utf8_encode($k);
		}
		$source = strtr($body, $ttr);
		$body = strip_tags($source);

		$phpmailer->Body = $body;
	}
	else {
		//$phpmailer->IsHTML(true);
		$phpmailer->CharSet = 'utf-8';
		$phpmailer->MsgHTML($body);
	}

	$phpmailer->Body = $body;

	if ($files && is_array($files)) {
		foreach ($files as $file) {
			if (isset($file['path'])) {
				$phpmailer->AddAttachment($file['path'], $file['name']);
			}
		}
	}

	$is_smtp   = elgg_get_plugin_setting('phpmailer_smtp', 'phpmailer');
	$smtp_host = elgg_get_plugin_setting('phpmailer_host', 'phpmailer');
	$smtp_auth = elgg_get_plugin_setting('phpmailer_smtp_auth', 'phpmailer');

	$is_ssl    = elgg_get_plugin_setting('ep_phpmailer_ssl', 'phpmailer');
	$ssl_port  = elgg_get_plugin_setting('ep_phpmailer_port', 'phpmailer');
	try{
	if ($is_smtp && isset($smtp_host)) {
		//$phpmailer->IsSMTP();
		//$phpmailer->Host = $smtp_host;
		//$phpmailer->SMTPAuth = false;
		if ($smtp_auth) {
			//$phpmailer->SMTPAuth = true;
			//$phpmailer->Username = elgg_get_plugin_setting('phpmailer_username', 'phpmailer');
			//$phpmailer->Password = elgg_get_plugin_setting('phpmailer_password', 'phpmailer');

			if ($is_ssl) {
				$phpmailer->SMTPSecure = "tls";
				$phpmailer->Port = $ssl_port;
			}
		}
	}
	else {
		// use php's mail
		$phpmailer->IsMail();
	}
	//error_log("Sending email from => " . $phpmailer->FromName );
	$return = $phpmailer->Send();
	//error_log("Sent email from => " . $phpmailer->FromName );
	}catch(phpmailerException $e){
                error_log($e->errorMessage());}
	if (!$return ) {
		error_log('PHPMailer error: ' . $phpmailer->ErrorInfo, 'WARNING');
	}else
		error_log("email sent");
	return $return;
}
