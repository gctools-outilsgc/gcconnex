<?php
	action_gatekeeper();
	$mygroup_guid = get_input('mygroup');
	$who_guid = get_input('who');
	$mygroup = get_entity($mygroup_guid);
	$who = get_entity($who_guid);
	if ($mygroup instanceof ElggGroup && ($mygroup->owner_guid == elgg_get_logged_in_user_guid() || elgg_is_admin_logged_in())) {
		
		// Owner is now a simple operator
		
		if (!check_entity_relationship($mygroup->owner_guid, 'operator', $mygroup_guid)) {
			add_entity_relationship($mygroup->owner_guid, 'operator', $mygroup_guid);
		}
		
		// We also change icons owner
		
		$old_filehandler = new ElggFile();
		$old_filehandler->owner_guid = $group->owner_guid;
		$old_filehandler->setFilename('groups');
		$old_path = $old_filehandler->getFilenameOnFilestore();
		
		$new_filehandler = new ElggFile();
		$new_filehandler->owner_guid = $who_guid;
		$new_filehandler->setFilename('groups');
		$new_path = $new_filehandler->getFilenameOnFilestore();
		
		foreach(array('', 'tiny', 'small', 'medium', 'large') as $size) {
			rename("$old_path/{$mygroup_guid}{$size}.jpg", "$new_path/{$mygroup_guid}{$size}.jpg");
		}
		
		// Finally, we change the owner
		
		$mygroup->owner_guid = $who_guid;
		$mygroup->save();
		
		system_message(elgg_echo('group_operators:owner_changed', array($who->name)));
	} else {
		register_error(elgg_echo('group_operators:change_owner:error'));
	}
	forward(REFERER);
