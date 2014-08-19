<?php

	$container_guid = (int) get_input("container_guid", 0);
	$parent_guid = get_input("parent_guid");
	
	set_time_limit(0);
	
	$forward_url = REFERER;
	
	if (!empty($container_guid) && get_uploaded_file("zip_file")) {
		$extension_array = explode(".", $_FILES["zip_file"]["name"]);	
		
		if(strtolower(end($extension_array)) == "zip") {
			$file = $_FILES["zip_file"];
			
			// disable notifications of new objects
			elgg_unregister_event_handler("create", "object", "object_notifications");
			
			if(file_tools_unzip($file, $container_guid, $parent_guid)) {
				system_message(elgg_echo("file:saved"));
				
				$container = get_entity($container_guid);
				if(elgg_instanceof($container, "group")){
					$forward_url = "file/group/" . $container->getGUID() . "/all#" . $parent_guid;
				} else {
					$forward_url = "file/owner/" . $container->username . "#" . $parent_guid;
				}
			} else {
				register_error(elgg_echo("file:uploadfailed"));
			}
			
			// reenable notifications of new objects
			elgg_register_event_handler("create", "object", "object_notifications");
		} else {
			register_error(elgg_echo("file:uploadfailed"));
		}
	} else {
		register_error(elgg_echo("file:cannotload"));
	}
	
	forward($forward_url);