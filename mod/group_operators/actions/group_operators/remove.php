<?php
	$mygroup_guid = get_input('mygroup');
	$who_guid = get_input('who');
	$mygroup = get_entity($mygroup_guid);
	$who = get_entity($who_guid);
	if ($mygroup instanceof ElggGroup && $mygroup->canEdit()) {
		if (check_entity_relationship($who_guid, 'operator', $mygroup_guid)) {
			remove_entity_relationship($who_guid, 'operator', $mygroup_guid);
		}
		system_message(elgg_echo('group_operators:removed'));
	} else {
		register_error(elgg_echo('groups:permissions:error'));
	}
	forward(REFERER);
?>
