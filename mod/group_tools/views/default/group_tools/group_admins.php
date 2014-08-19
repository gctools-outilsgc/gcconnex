<?php

	$group = $vars["entity"];
	if ($group) {
		$options = array(
			"relationship" => "group_admin",
			"relationship_guid" => $group->getGUID(),
			"inverse_relationship" => true,
			"type" => "user",
			"limit" => false,
			"list_type" => "gallery",
			"gallery_class" => "elgg-gallery-users",
			"wheres" => array("e.guid <> " . $group->owner_guid)
		);
		
		if($users = elgg_get_entities_from_relationship($options)){
			// add owner to the beginning of the list
			array_unshift($users, $group->getOwnerEntity());
			
			$body = elgg_view_entity_list($users, $options);
			echo elgg_view_module("aside", elgg_echo("group_tools:multiple_admin:group_admins"), $body);
		}
	}