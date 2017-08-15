<?php

/**
* Group Tools
*
* Enable or disable group notifications for all members
* 
* @author ColdTrick IT Solutions
*/	

$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethods();

$toggle = get_input('toggle');
$guid = (int) get_input('guid');

if (empty($guid) || empty($toggle)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

elgg_entity_gatekeeper($guid, 'group');
$group = get_entity($guid);

// get group members
$members = $group->getMembers(['count' => true]);
if (empty($members)) {
	forward($group->getURL());
}

$options = [
	'type' => 'user',
	'relationship' => 'member',
	'relationship_guid' => $group->getGUID(),
	'inverse_relationship' => true,
	'limit' => false,
];
$members = new ElggBatch('elgg_get_entities_from_relationship', $options);

switch ($toggle) {
	case 'enable':
		// fix notifications settings for site amd email
		$auto_notification_handlers = [
			'site',
			'email',
		];
		
		// enable notification for everyone
		foreach ($members as $member) {
			foreach ($NOTIFICATION_HANDLERS as $method => $dummy) {
				if (in_array($method, $auto_notification_handlers)) {
					elgg_add_subscription($member->getGUID(), $method, $group->getGUID());
				}
			}
		}
		
		system_message(elgg_echo('group_tools:action:notifications:success:enable'));
		break;
	case 'disable':
		// disable notification for everyone
		foreach ($members as $member) {
			foreach ($NOTIFICATION_HANDLERS as $method => $dummy) {
				elgg_remove_subscription($member->getGUID(), $method, $group->getGUID());
			}
		}
		
		system_message(elgg_echo('group_tools:action:notifications:success:disable'));
		break;
	default:
		register_error(elgg_echo('group_tools:action:notifications:error:toggle'));
		break;
}

forward($group->getURL());
