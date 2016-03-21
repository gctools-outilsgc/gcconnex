<?php

$guid = (int) get_input("guid");
$title = get_input("title");
$owner_guid = (int) get_input("page_owner");
$description = get_input("description");
$parent_guid = (int) get_input("file_tools_parent_guid", 0); // 0 is top_level
$access_id = (int) get_input("access_id", ACCESS_DEFAULT);
$change_children_access = get_input("change_children_access", false);
$change_files_access = get_input("change_files_access", false);

if (!empty($title) && !empty($owner_guid)) {
	if (($owner = get_entity($owner_guid)) && (elgg_instanceof($owner, "user") || elgg_instanceof($owner, "group"))) {
		if (!empty($guid)) {
			// check if editing existing
			if ($folder = get_entity($guid)) {
				if (!elgg_instanceof($folder, "object", FILE_TOOLS_SUBTYPE)) {
					unset($folder);
				}
			}
		} else {
			// create a new folder
			$folder = new ElggObject();
			$folder->subtype = FILE_TOOLS_SUBTYPE;
			$folder->owner_guid = elgg_get_logged_in_user_guid();
			$folder->container_guid = $owner_guid;
			$folder->access_id = $access_id;

			$order = elgg_get_entities_from_metadata(array(
				"type" => "object",
				"subtype" => FILE_TOOLS_SUBTYPE,
				"metadata_name_value_pairs" => array(
					"name" => "parent_guid",
					"value" => $parent_guid
				),
				"count" => true
			));

			$folder->order = $order;

			if (!$folder->save()) {
				unset($folder);
			}
		}
		
		if (!empty($folder)) {
			// check for the correct parent_guid
			if (($parent_guid === 0) || ($parent_guid != $folder->getGUID())) {
				$folder->title = $title;
				$folder->description = $description;
	
				$folder->access_id = $access_id;
	
				if (!empty($change_children_access)) {
					$folder->save();
					file_tools_change_children_access($folder, !empty($change_files_access));
				} elseif (!empty($change_files_access)) {
					$folder->save();
					file_tools_change_files_access($folder);
				}
				
				// check if we have a correct parent_guid
				if ($parent_guid == $folder->getGUID()) {
					// set parent to 0 (main level)
					$parent_guid = 0;
				}
				
				$folder->parent_guid = $parent_guid;
	
				if ($folder->save()) {
					$forward_url = $folder->getURL();
					
					system_message(elgg_echo("file_tools:action:edit:success"));
				} else {
					register_error(elgg_echo("file_tools:action:edit:error:save"));
				}
			} else {
				register_error(elgg_echo("file_tools:action:edit:error:parent_guid"));
			}
		} else {
			register_error(elgg_echo("file_tools:action:edit:error:folder"));
		}
	} else {
		register_error(elgg_echo("file_tools:action:edit:error:owner"));
	}
} else {
	register_error(elgg_echo("file_tools:action:edit:error:input"));
}

if (!empty($forward_url)) {
	forward($forward_url);
}

forward(REFERER);
