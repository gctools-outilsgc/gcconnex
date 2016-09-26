<?php
/**
 * Messages helper functions
 *
 * @package ElggMessages
 */

/**
 * Prepare the compose form variables
 *
 * @return array
 */
function messages_prepare_form_vars($recipient_guid = 0) {

	$recipient_username = '';
	$recipient = get_entity($recipient_guid);
	if (elgg_instanceof($recipient, 'user')) {
		$recipient_username = $recipient->username;
	}

	// input names => defaults
	$values = array(
		'subject' => '',
		'body' => '',
		'recipient_username' => $recipient_username,
	);

	if (elgg_is_sticky_form('messages')) {
		foreach (array_keys($values) as $field) {
			$values[$field] = elgg_get_sticky_value('messages', $field);
		}
	}

	elgg_clear_sticky_form('messages');

	return $values;
}



/**
 * Provides an array of the latest n messages in the user's inbox
 * @param $user_id the guid of the user who is the recipient of the messages we will be looking for and returning
 * @param $type is this for the regular inbox ('inbox', the default) or the notification one ('notif')
 * @param $n the number of messages to return, default is 5
 *
 * @return array of entity objects
 */
 function latest_messages_preview( $user_guid, $type = 'inbox', $n = 5 ) {
	// prepare for query building
	$strings = array('toId', $user_guid, 'readYet', 0, 'msg', 1, 'fromId');
 	$map = array();
 	foreach ($strings as $string) {
 		$id = elgg_get_metastring_id($string);
 		$map[$string] = $id;
 	}
	
 	 $db_prefix = elgg_get_config('dbprefix');
	 // set up the joins and where for the query
	 $options = array(
 		'joins' => array(
 			"JOIN {$db_prefix}metadata msg_toId on e.guid = msg_toId.entity_guid",
 			"JOIN {$db_prefix}metadata msg_readYet on e.guid = msg_readYet.entity_guid",
 			"JOIN {$db_prefix}metadata msg_msg on e.guid = msg_msg.entity_guid",
 			"LEFT JOIN {$db_prefix}metadata msg_fromId on e.guid = msg_fromId.entity_guid",
 			"LEFT JOIN {$db_prefix}metastrings msvfrom ON msg_fromId.value_id = msvfrom.id",
 			"LEFT JOIN {$db_prefix}entities efrom ON msvfrom.string = efrom.guid",
 		),
 		'wheres' => array(
 			"msg_toId.name_id='{$map['toId']}' AND msg_toId.value_id='{$map[$user_guid]}'",
 			"msg_fromId.name_id='{$map['fromId']}' AND efrom.type = 'user'",
 			"msg_readYet.name_id='{$map['readYet']}' AND msg_readYet.value_id='{$map[0]}'",
 			"msg_msg.name_id='{$map['msg']}' AND msg_msg.value_id='{$map[1]}'",
 		),
 		'owner_guid' => $user_guid,
 		'limit' => $n,
 		'offset' => 0,
 		'count' => false,
 		'distinct' => false,
 	);
	// only the wheres are a little different for notifications
	if ( $type === 'notif' )
		$options['wheres'] = array(
 			"msg_toId.name_id='{$map['toId']}' AND msg_toId.value_id='{$map[$user_guid]}'",
 			"msg_fromId.name_id='{$map['fromId']}' AND efrom.type <> 'user'",
 			"msg_readYet.name_id='{$map['readYet']}' AND msg_readYet.value_id='{$map[0]}'",
 			"msg_msg.name_id='{$map['msg']}' AND msg_msg.value_id='{$map[1]}'",
 		);

	// run the query and retrieve the entities
	 $messages = elgg_get_entities_from_metadata($options);

	 return $messages;
 }
