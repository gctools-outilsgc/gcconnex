<?php

/**
* Group Tools
*
* Save the domains for domain based joining of a group
* 
* @author ColdTrick IT Solutions
*/	

$group_guid = (int) get_input('group_guid');
$domains = get_input('domains');

if (empty($group_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

elgg_entity_gatekeeper($group_guid, 'group');
$group = get_entity($group_guid);
if (!$group->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

if (!empty($domains)) {
	$domains = string_to_tag_array($domains);
	$domains = '|' . implode('|', $domains) . '|';
	
	$group->setPrivateSetting('domain_based', $domains);
} else {
	$group->removePrivateSetting('domain_based');
}

system_message(elgg_echo('group_tools:action:domain_based:success'));
forward($group->getURL());
