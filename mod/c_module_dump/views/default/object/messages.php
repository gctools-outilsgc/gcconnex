<?php

// cyu - 01-20-2015: overwriting the site inbox (enhancement) user link will direct user to profiles instead

$full = elgg_extract('full_view', $vars, false);
$message = elgg_extract('entity', $vars, false);

if (!$message) {
	return true;
}

if ($message->toId == elgg_get_page_owner_guid()) {
	// received
	$user = get_entity($message->fromId);
	
	if ($user) {

		// cyu - 01-20-2015: will link to user profile instead
		$icon = elgg_view_entity_icon($user, 'tiny');

		// cyu - 01-20-2015: check if this is a user
		if ($user instanceof ElggUser)
		{
			$user_link = elgg_view('output/url', array(
				'href' => "profile/$user->username",
				'text' => $user->name,
				'is_trusted' => true,
			));

		// cyu - 01-20-2015: check if this is a group
		} elseif ($user instanceof ElggGroup) {

			$user_link = elgg_view('output/url', array(
				'href' => "groups/profile/$user->guid/$user->name",
				'text' => $user->name,
				'is_trusted' => true,
			));

		// cyu - 01-20-2015: i assume that if it is not a user or group, then it is site
		} else {
			$user_link = elgg_view('output/url', array(
				'href' => "/",
				'text' => $user->name,
				'is_trusted' => true,
			));
		}


	} else {
		$icon = '';
		$user_link = elgg_echo('messages:deleted_sender');
	}

	if ($message->readYet) {
		$class = 'message read';
	} else {
		$class = 'message unread';
	}

} else {
	// sent
	$user = get_entity($message->toId);

	if ($user) {
		$icon = elgg_view_entity_icon($user, 'tiny');
		$user_link = elgg_view('output/url', array(
			'href' => "messages/compose?send_to=$user->guid",
			'text' => elgg_echo('messages:to_user', array($user->name)),
			'is_trusted' => true,
		));
	} else {
		$icon = '';
		$user_link = elgg_echo('messages:deleted_sender');
	}

	$class = 'message read';
}

$timestamp = elgg_view_friendly_time($message->time_created);

$subject_info = '';
if (!$full) {
	$subject_info .= "<input type='checkbox' name=\"message_id[]\" value=\"{$message->guid}\" />";
}
$subject_info .= elgg_view('output/url', array(
	'href' => $message->getURL(),
	'text' => $message->title,
	'is_trusted' => true,
));

$delete_link = elgg_view("output/confirmlink", array(
						'href' => "action/messages/delete?guid=" . $message->getGUID(),
						'text' => "<span class=\"elgg-icon elgg-icon-delete float-alt\"></span>",
						'confirm' => elgg_echo('deleteconfirm'),
						'encode_text' => false,
					));

$body = <<<HTML
<div class="messages-owner">$user_link</div>
<div class="messages-subject">$subject_info</div>
<div class="messages-timestamp">$timestamp</div>
<div class="messages-delete">$delete_link</div>
HTML;

if ($full) {
	echo elgg_view_image_block($icon, $body, array('class' => $class));
	echo elgg_view('output/longtext', array('value' => $message->description));
} else {
	echo elgg_view_image_block($icon, $body, array('class' => $class));
}