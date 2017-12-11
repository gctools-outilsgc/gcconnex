<?php
/*
 * Exposes API endpoints for Message entities
 */

elgg_ws_expose_function(
	"get.message",
	"get_message",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"thread" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a message based on user id and message id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.messages",
	"get_messages",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a user\'s messages based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.messagescount",
	"get_messages_count",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a user\'s unread message count based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.sentmessages",
	"get_sent_messages",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a user\'s sent messages based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.sentmessagescount",
	"get_sent_messages_count",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a user\'s unread sent messages count based on user id',
	'POST',
	true,
	false
);


elgg_ws_expose_function(
	"get.notifications",
	"get_notifications",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a user\'s notification messages based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.notificationscount",
	"get_notifications_count",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a user\'s unread notification message count based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"send.message",
	"send_message",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"touser" => array('type' => 'string', 'required' => true),
		"subject" => array('type' => 'string', 'required' => true),
		"message" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Submits a message based on "from" user id and "to" user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"reply.message",
	"reply_message",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"message" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Submits a reply to a message based on user id and message id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"read.message",
	"read_message",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Marks a message as read based on user id and message id',
	'POST',
	true,
	false
);

function get_message( $user, $guid, $thread, $lang ){
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	if( $thread ){
		$message = elgg_list_entities(array(
		    'type' => 'object',
			'subtype' => 'messages',
			'guid' => $guid
		));
		$the_message = json_decode($message)[0];
		if( !$the_message ) return "Message was not found. Please try a different GUID";
		if( $the_message->subtype !== "messages" ) return "Invalid message. Please try a different GUID";

		$db_prefix = elgg_get_config('dbprefix');
		$without_re = str_replace("RE: ", "", $the_message->title);
		$all_messages = elgg_list_entities(array(
			"types" => "object",
			"subtype" => "messages",
			"limit" => 0,
			// "metadata_name_value_pairs" => array(
			// 	array("name" => "fromId", "value" => $user_entity->guid, "operand" => "<>")
			// ),
			"preload_owners" => true,
			"joins" => array("JOIN {$db_prefix}objects_entity oe ON e.guid = oe.guid"),
			"wheres" => array("oe.title = '".$the_message->title."' OR oe.title = 'RE: ".$the_message->title."' OR oe.title = '".$without_re."'"),
			'order_by' => 'e.time_created ASC'
		));
		$messages = json_decode($all_messages);

		foreach($messages as $key => $message){
			$messageObj = get_entity($message->guid);
			$message->read = intval($messageObj->readYet);

			if( $messageObj->fromId && $messageObj->toId ){
				$message->fromUserDetails = get_user_block($messageObj->fromId, $lang);
				$message->toUserDetails = get_user_block($messageObj->toId, $lang);
			} else {
				unset($messages[$key]);
				continue;
			}

			$message->description = utf8_decode($message->description);
			$message->description = str_replace(array("<html>", "</html>", "<body>", "</body>", "<p>&nbsp;</p>", "<br>", "<br/>", "<br />"), "", $message->description);
		}

		return array_values($messages);
	} else {
		$message = elgg_list_entities(array(
		    'type' => 'object',
			'subtype' => 'messages',
			'guid' => $guid
		));
		$the_message = json_decode($message)[0];
		if( !$the_message ) return "Message was not found. Please try a different GUID";
		if( $the_message->subtype !== "messages" ) return "Invalid message. Please try a different GUID";

		$messageObj = get_entity($the_message->guid);
		$the_message->read = intval($messageObj->readYet);

		$the_message->fromUserDetails = get_user_block($messageObj->fromId, $lang);
		$the_message->toUserDetails = get_user_block($messageObj->toId, $lang);

		$the_message->description = utf8_decode($the_message->description);
		$the_message->description = str_replace(array("<html>", "</html>", "<body>", "</body>", "<p>&nbsp;</p>", "<br>", "<br/>", "<br />"), "", $the_message->description);
	
		return $the_message;
	}
}

function get_messages($user, $limit, $offset, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$messages = elgg_list_entities_from_metadata(array(
		"type" => "object",
		"subtype" => "messages",
		'metadata_name_value_pair' => array(
			array('name' => 'toId', 'value' => $user_entity->guid,  'operand' => '='),
			array('name' => 'fromId', 'value' => 1,  'operand' => '!=')
		),
		"limit" => $limit,
		"offset" => $offset
	));
	$messages = json_decode($messages);

	foreach ($messages as $the_message) {
		$messageObj = get_entity($the_message->guid);
		$the_message->read = intval($messageObj->readYet);

		$the_message->fromUserDetails = get_user_block($messageObj->fromId, $lang);
		$the_message->toUserDetails = get_user_block($messageObj->toId, $lang);

		$the_message->description = utf8_decode($the_message->description);
		$the_message->description = str_replace(array("<html>", "</html>", "<body>", "</body>", "<p>&nbsp;</p>", "<br>", "<br/>", "<br />"), "", $the_message->description);
	}

	return $messages;
}

function get_messages_count($user, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$messages = elgg_list_entities_from_metadata(array(
		"type" => "object",
		"subtype" => "messages",
		'metadata_name_value_pair' => array(
			array('name' => 'toId', 'value' => $user_entity->guid,  'operand' => '='),
			array('name' => 'fromId', 'value' => 1,  'operand' => '!=')
		)
	));
	$messages = json_decode($messages);

	$unread_count = 0;

	foreach ($messages as $the_message) {
		if ($the_message->read) {
			$unread_count++;
		}
	}

	return $unread_count;
}

function get_sent_messages($user, $limit, $offset, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$messages = elgg_list_entities_from_metadata(array(
		"type" => "object",
		"subtype" => "messages",
		"metadata_name" => "fromId",
		"metadata_value" => $user_entity->guid,
		"owner_guid" => $user_entity->guid,
		"limit" => $limit,
		"offset" => $offset
	));
	$messages = json_decode($messages);

	foreach ($messages as $the_message) {
		$messageObj = get_entity($the_message->guid);
		$the_message->read = intval($messageObj->readYet);

		$the_message->fromUserDetails = get_user_block($messageObj->fromId, $lang);
		$the_message->toUserDetails = get_user_block($messageObj->toId, $lang);

		$the_message->description = utf8_decode($the_message->description);
		$the_message->description = str_replace(array("<html>", "</html>", "<body>", "</body>", "<p>&nbsp;</p>", "<br>", "<br/>", "<br />"), "", $the_message->description);
	}

	return $messages;
}

function get_sent_messages_count($user, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$messages = elgg_list_entities_from_metadata(array(
		"type" => "object",
		"subtype" => "messages",
		"metadata_name" => "fromId",
		"metadata_value" => $user_entity->guid,
		"owner_guid" => $user_entity->guid
	));
	$messages = json_decode($messages);

	$unread_count = 0;

	foreach ($messages as $the_message) {
		if ($the_message->read) {
			$unread_count++;
		}
	}

	return $unread_count;
}

function get_notifications($user, $limit, $offset, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$messages = elgg_list_entities_from_metadata(array(
		"type" => "object",
		"subtype" => "messages",
		'metadata_name_value_pair' => array(
			array('name' => 'toId', 'value' => $user_entity->guid,  'operand' => '='),
			array('name' => 'fromId', 'value' => 1,  'operand' => '=')
		),
		"limit" => $limit,
		"offset" => $offset
	));
	$messages = json_decode($messages);

	foreach ($messages as $the_message) {
		$messageObj = get_entity($the_message->guid);
		$the_message->read = intval($messageObj->readYet);

		$the_message->fromUserDetails = get_user_block($messageObj->fromId, $lang);
		$the_message->toUserDetails = get_user_block($messageObj->toId, $lang);

		$the_message->description = utf8_decode($the_message->description);
		$the_message->description = str_replace(array("<html>", "</html>", "<body>", "</body>", "<p>&nbsp;</p>", "<br>", "<br/>", "<br />"), "", $the_message->description);
	}

	return $messages;
}

function get_notifications_count($user, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$messages = elgg_list_entities_from_metadata(array(
		"type" => "object",
		"subtype" => "messages",
		'metadata_name_value_pair' => array(
			array('name' => 'toId', 'value' => $user_entity->guid,  'operand' => '='),
			array('name' => 'fromId', 'value' => 1,  'operand' => '=')
		)
	));
	$messages = json_decode($messages);

	$unread_count = 0;

	foreach ($messages as $the_message) {
		if ($the_message->read) {
			$unread_count++;
		}
	}

	return $unread_count;
}

function send_message($user, $touser, $subject, $message, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "\"From\" User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid \"from\" user. Please try a different GUID, username, or email address";
	}

	$to_user_entity = is_numeric($touser) ? get_user($touser) : (strpos($touser, '@') !== false ? get_user_by_email($touser)[0] : get_user_by_username($touser));
	if (!$to_user_entity) {
		return "\"To\" User was not found. Please try a different GUID, username, or email address";
	}
	if (!$to_user_entity instanceof ElggUser) {
		return "Invalid \"to\" user. Please try a different GUID, username, or email address";
	}

	if (trim($subject) == "") {
		return "A subject must be provided to send a message";
	}
	if (trim($message) == "") {
		return "A message must be provided to send a message";
	}

	$result = messages_send($subject, $message, $to_user_entity->guid, $user_entity->guid);

	if (!$result) {
		return elgg_echo("messages:error");
	}

	return elgg_echo("messages:posted");
}

function reply_message($user, $message, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user));
 	if (!$user_entity) {
 		return "User was not found. Please try a different GUID, username, or email address";
 	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}
	
	$messages = elgg_list_entities(array(
	    'type' => 'object',
		'subtype' => 'messages',
		'guid' => $guid
	));
	$the_message = json_decode($messages)[0];
	if (!$the_message) {
		return "Message was not found. Please try a different GUID";
	}
	if ($the_message->subtype !== "messages") {
		return "Invalid message. Please try a different GUID";
	}

	$messageObj = get_entity($the_message->guid);

	$to_user_entity = get_user($messageObj->fromId);
 	if (!$to_user_entity) {
 		return "User was not found. Please try a different GUID, username, or email address";
 	}
	if (!$to_user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (trim($message) == "") {
		return "A message must be provided to send a message";
	}

	$result = messages_send($messageObj->title, $message, $to_user_entity->guid, $user_entity->guid, $guid);
	
	if (!$result) {
		return elgg_echo("messages:error");
	}

	return elgg_echo("messages:posted");
}

function read_message($user, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user));
 	if (!$user_entity) {
 		return "User was not found. Please try a different GUID, username, or email address";
 	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}
	
	$messages = elgg_list_entities(array(
	    'type' => 'object',
		'subtype' => 'messages',
		'guid' => $guid
	));
	$the_message = json_decode($messages)[0];
	if (!$the_message) {
		return "Message was not found. Please try a different GUID";
	}
	if ($the_message->subtype !== "messages") {
		return "Invalid message. Please try a different GUID";
	}

	$messageObj = get_entity($the_message->guid);
	$messageObj->readYet = true;
	$result = $messageObj->save();

	return $result;
}
