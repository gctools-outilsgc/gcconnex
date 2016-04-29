<?php
/**
 * Elgg Message board: add message action
 *
 * @package ElggMessageBoard
 */

$message_content = get_input('message_content');
$owner_guid = get_input("owner_guid");
$owner = get_entity($owner_guid);

if ($owner && !empty($message_content)) {
	$result = messageboard_add(elgg_get_logged_in_user_entity(), $owner, $message_content, $owner->access_id);

	if ($result) {
		system_message(elgg_echo("messageboard:posted"));

		$options = array(
			'annotations_name' => 'messageboard',
			'guid' => $owner->getGUID(),
			'limit' => $num_display,
			'pagination' => false,
			'reverse_order_by' => true,
			'limit' => 1
		);

		$output = elgg_list_annotations($options);
		echo $output;


		// cyu - if cp notification plugin is active, use that for notifications
		if (elgg_is_active_plugin('cp_notifications')) {
			$message = array(
				'cp_msg_type' => 'cp_messageboard',
				'cp_recipient' => $owner,
				'cp_message_content' => $message_content,
				'cp_writer' => elgg_get_logged_in_user_entity(),
			);
			elgg_trigger_plugin_hook('cp_overwrite_notification','all',$message);
		}


	} else {
		register_error(elgg_echo("messageboard:failure"));
	}

} else {
	register_error(elgg_echo("messageboard:blank"));
}

forward(REFERER);
