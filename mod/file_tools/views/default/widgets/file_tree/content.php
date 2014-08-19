<?php 

	$widget = elgg_extract("entity", $vars);
	
	if($folder_guids = $widget->folder_guids){
		$show_content = $widget->show_content;
		
		if(!is_array($folder_guids)){
			$folder_guids = array($folder_guids);
		}
		
		$folder_guids = array_map("sanitise_int", $folder_guids);
		
		$folders = "";
		foreach($folder_guids as $guid){
			if(($folder = get_entity($guid)) && ($folder->getSubtype() == FILE_TOOLS_SUBTYPE)){
				if(!empty($show_content)){
					// list the files
					$folders .= elgg_view_entity($folder, array("full_view" => false));
					
					// list the content
					if(!($sub_folders = file_tools_get_sub_folders($folder))){
						$sub_folders = array();
					}
					
					$files_options = array(
						"type" => "object",
						"subtype" => "file",
						"limit" => false,
						"container_guid" => $widget->getOwnerGUID(),
						"relationship" => FILE_TOOLS_RELATIONSHIP,
						"relationship_guid" => $folder->getGUID(),
						"inverse_relationship" => false,
					);
					$files = elgg_get_entities_from_relationship($files_options);
					
					$entities = array_merge($sub_folders, $files);
					
					$folders .= "<div class='mlm'>";
					$folders .= elgg_view_entity_list($entities, array("full_view" => false, "pagination" => false));
					$folders .= "</div>";
				} else {
					$folders .= elgg_view_entity($folder);
				}
			}
		}
		
		if(!empty($folders)){
			$owner = $widget->getOwnerEntity();
			if(elgg_instanceof($owner, "user")){
				$more_url = $vars["url"] . "file/owner/" . $owner->username;
			} else {
				$more_url = $vars["url"] . "file/group/" . $owner->getGUID() . "/all";
			}
			
			echo $folders;
			
			echo "<div class='widget_more_wrapper'>";
			echo elgg_view("output/url", array("href" => $more_url, "text" => elgg_echo("widgets:file_tree:more")));
			echo "</div>";
		} else {
			echo elgg_echo("notfound");
		}
	} else {
		echo elgg_echo("widgets:file_tree:no_folders");
	}
