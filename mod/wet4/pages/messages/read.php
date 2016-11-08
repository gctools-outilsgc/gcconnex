<?php
/**
* Read a message page
*
* @package ElggMessages
*/

elgg_gatekeeper();

$guid = get_input('guid');

elgg_entity_gatekeeper($guid, 'object', 'messages');

$message = get_entity($guid);
$from_user = get_user($message->fromId);
$to_user = get_user($message->toId);

// mark the message as read
$message->readYet = true;

elgg_set_page_owner_guid($message->getOwnerGUID());
$page_owner = elgg_get_page_owner_entity();

$title = htmlspecialchars($message->title, ENT_QUOTES, 'UTF-8');

$inbox = false;
if ($page_owner->getGUID() == $message->toId) {
	$inbox = true;
	elgg_push_breadcrumb(elgg_echo('messages:inbox'), 'messages/inbox/' . $page_owner->username);
} else {
	elgg_push_breadcrumb(elgg_echo('messages:sent'), 'messages/sent/' . $page_owner->username);
}
elgg_push_breadcrumb($title);

$from_user->name = utf8_encode($from_user->name);
$to_user->name = utf8_encode($to_user->name);
$message->title = utf8_encode($message->title);

$content = elgg_view_entity($message, array('full_view' => true));

if ($inbox) {
	$form_params = array(
		'id' => 'messages-reply-form',
		'class' => 'wet-hidden mtl',
		'action' => 'action/messages/send',
	);
	$body_params = array('message' => $message);
	$content .= elgg_view_form('messages/reply', $form_params, $body_params);
	
	if ((elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()) && $from_user) {
		elgg_register_menu_item('title', array(
			'name' => 'reply',
			'href' => '#messages-reply-form',
			'text' => elgg_echo('reply'),
			'link_class' => 'elgg-button elgg-button-action',
			'rel' => 'toggle',
		));
	}
}

$body = elgg_view_layout('one_column', array(
	'content' => utf8_decode($content),
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);