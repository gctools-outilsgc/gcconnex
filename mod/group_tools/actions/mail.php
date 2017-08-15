<?php
/**
 * Mail all the members of a group
 */

$group_guid = (int) get_input('group_guid', 0);
$user_guids = (array) get_input('user_guids');
$subject = get_input('title');
$body = get_input('description');

array_walk($user_guids, 'sanitise_int');

if (empty($group_guid) || empty($body) || empty($user_guids)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

elgg_entity_gatekeeper($group_guid, 'group');
$group = get_entity($group_guid);

if (!group_tools_group_mail_enabled($group) && !group_tools_group_mail_members_enabled($group)) {
	register_error(elgg_echo('actionunauthorized'));
	forward($group->getURL());
}

$group_mail = new GroupMail();
$group_mail->container_guid = $group_guid;

$group_mail->title = $subject;
$group_mail->description = $body;

$group_mail->setRecipients($user_guids);

$group_mail->enqueue();

system_message(elgg_echo('group_tools:action:mail:success'));
forward($group->getURL());
