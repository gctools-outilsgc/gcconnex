<?php

	$file_guids = get_input("file_guids");
	$folder_guids = get_input("folder_guids");
	
	if(!empty($file_guids) || !empty($folder_guids)){
		// remove all files
		if(!empty($file_guids)){
			$file_count = 0;
			
			foreach($file_guids as $guid){
				if(($file = get_entity($guid)) && elgg_instanceof($file, "object", "file")){
					if($file->canEdit()){
						if($file->delete()){
							$file_count++;
						}
					}
				}
			}
			
			if(!empty($file_count)){
				system_message(elgg_echo("file_tools:action:bulk_delete:success:files", array($file_count)));
			} else {
				register_error(elgg_echo("file_tools:action:bulk_delete:error:files"));
			}
		}
		
		// remove folders
		if(!empty($folder_guids)){
			$folder_count = 0;
			
			foreach($folder_guids as $guid){
				if(($folder = get_entity($guid)) && elgg_instanceof($folder, "object", FILE_TOOLS_SUBTYPE)){
					if($folder->canEdit()){
						if($folder->delete()){
							$folder_count++;
						}
					}
				}
			}
			
			if(!empty($folder_count)){
				system_message(elgg_echo("file_tools:action:bulk_delete:success:folders", array($folder_count)));
			} else {
				register_error(elgg_echo("file_tools:action:bulk_delete:error:folders"));
			}
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:MissingParameter"));
	}
	
	forward(REFERER);