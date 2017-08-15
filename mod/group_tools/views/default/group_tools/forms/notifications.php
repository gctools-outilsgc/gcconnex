<?php

/**
 * Group Tools
 *
 * Set notification settings of group members
 *
 * @author ColdTrick IT Solutions
 * 
 */

$user = elgg_get_logged_in_user_entity();

if (empty($user) || !$user->isAdmin()) {
	// only site admins can do this
	return;
}

$group = elgg_extract('entity', $vars);
if (!($group instanceof ElggGroup)) {
	return;
}

// count members
$member_count = $group->getMembers(['count' => true]);

// count how manyu members are notified by email
$notification_options = [
	'type' => 'user',
	'count' => true,
	'relationship' => 'notifyemail',
	'relationship_guid' => $group->getGUID(),
	'inverse_relationship' => true,
];

$notification_count = elgg_get_entities_from_relationship($notification_options);

if (elgg_is_active_plugin('site_notifications')) {
	// maybe more members are being notified by site
	$notification_options['relationship'] = 'notifysite';
	
	$site_notification_count = elgg_get_entities_from_relationship($notification_options);
	if (!empty($site_notification_count)) {
		if ($site_notification_count > $notification_count) {
			$notification_count = $site_notification_count;
		}
	}
}

// start building content
$title = elgg_echo('group_tools:notifications:title');

$content = elgg_format_element('div', ['class' => 'mbm'], elgg_echo('group_tools:notifications:description', [$member_count, $notification_count]));

// enable notification for everyone
if ($member_count > $notification_count) {
	$content .= elgg_view('output/url', [
		'href' => "action/group_tools/notifications?toggle=enable&guid={$group->getGUID()}",
		'text' => elgg_echo('group_tools:notifications:enable'),
		'class' => 'elgg-button elgg-button-submit mrm',
		'confirm' => true,
	]);
}

// disable notification
if ($notification_count > 0) {
	$content .= elgg_view('output/url', [
		'href' => "action/group_tools/notifications?toggle=disable&guid={$group->getGUID()}",
		'text' => elgg_echo('group_tools:notifications:disable'),
		'class' => 'elgg-button elgg-button-submit',
		'confirm' => true,
	]);
}

// disclaimer about timing
$content .= elgg_format_element('div', ['class' => 'elgg-quiet mtm'], elgg_echo('group_tools:notifications:disclaimer'));

// echo content
echo elgg_view_module('info', $title, $content);
