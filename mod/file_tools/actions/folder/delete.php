<?php

	gatekeeper();
	
	$folder_guid = (int) get_input("guid");
	
	if(!empty($folder_guid)) {
		if($folder = get_entity($folder_guid)) {
			if(elgg_instanceof($folder, "object", FILE_TOOLS_SUBTYPE) && $folder->canEdit()) {
				if($folder->delete()) {
					system_message(elgg_echo("file_tools:actions:delete:success"));
				} else {
					register_error(elgg_echo("file_tools:actions:delete:error:delete"));
				}
			} else {
				register_error(elgg_echo("InvalidClassException:NotValidElggStar", array($folder_guid, FILE_TOOLS_SUBTYPE)));
			}
		} else {
			register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:MissingParameter"));
	}
	
	forward(REFERER);