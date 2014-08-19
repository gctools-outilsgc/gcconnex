<?php

	$guid = (int) get_input("guid");
	$default_access = (int) get_input("group_default_access");
	
	$forward_url = REFERER;
	
	if(!empty($guid)){
		if(($group = get_entity($guid)) && elgg_instanceof($group, "group")){
			if($group->canEdit()){
				$group->setPrivateSetting("elgg_default_access", $default_access);
				
				$forward_url = $group->getURL();
				system_message(elgg_echo("group_tools:actions:default_access:success"));
			} else {
				register_error(elgg_echo("groups:cantedit"));
			}
		} else {
			register_error(elgg_echo("groups:notfound:details"));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:MissingParameter"));
	}
	
	forward($forward_url);