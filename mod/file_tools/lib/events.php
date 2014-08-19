<?php

	function file_tools_object_handler($event, $type, $object) {
		
		if(!empty($object) && elgg_instanceof($object, "object", "file")) {
			$folder_guid = (int) get_input("folder_guid", 0);

			if(!empty($folder_guid)) {
				if($folder = get_entity($folder_guid)) {
					if(!elgg_instanceof($folder, "object", FILE_TOOLS_SUBTYPE)) {
						unset($folder_guid);
					}
				} else {
					unset($folder_guid);
				}
			}

			// remove old relationships
			remove_entity_relationships($object->getGUID(), FILE_TOOLS_RELATIONSHIP, true);
				
			if(!empty($folder_guid)) {
				add_entity_relationship($folder_guid, FILE_TOOLS_RELATIONSHIP, $object->getGUID());
			}
		}
	}
	
	function file_tools_object_handler_delete($event, $type, $object) {
		static $delete_files;
		
		if(!empty($object) && elgg_instanceof($object, "object", FILE_TOOLS_SUBTYPE)) {
			// find subfolders
			$options = array(
				"type" => "object",
				"subtype" => FILE_TOOLS_SUBTYPE,
				"container_guid" => $object->getContainerGUID(),
				"limit" => false,
				"metadata_name_value_pairs" => array(
					"name" => "parent_guid",
					"value" => $object->getGUID()
				),
				"wheres" => array("(e.guid <> " . $object->getGUID() . ")") // prevent deadloops
			);

			if($subfolders = elgg_get_entities_from_metadata($options)) {
				// delete subfolders
				foreach($subfolders as $subfolder) {
					$subfolder->delete();
				}
			}

			// fill the static, to delete files in a folder
			if(!isset($delete_files)){
				$delete_files = false;
				
				if(get_input("files") == "yes"){
					$delete_files = true;
				}
			}
			
			// should we remove files?
			if($delete_files) {
				// find file in this folder
				$options = array(
					"type" => "object",
					"subtype" => "file",
					"container_guid" => $object->getContainerGUID(),
					"limit" => false,
					"relationship" => FILE_TOOLS_RELATIONSHIP,
					"relationship_guid" => $object->getGUID()
				);
					
				if($files = elgg_get_entities_from_relationship($options)) {
					// delete files in folder
					foreach($files as $file) {
						$file->delete();
					}
				}
			}
		}
	}
	
	function file_tools_upgrade_handler(){
		$upgrades_path = dirname(dirname(__FILE__)) . "/upgrades/";
		
		// find all upgrade files
		$upgrade_files = elgg_get_upgrade_files($upgrades_path);
		// get processed upgrade file, so we can add our own files when done
		$processed_upgrades = elgg_get_processed_upgrades();
		
		// get unprocessed upgrade files
		if($unprocessed_upgrades = elgg_get_unprocessed_upgrades($upgrade_files, $processed_upgrades)){
			
			foreach($unprocessed_upgrades as $upgrade_file){
				// make sure we don't try to run someone elses upgrade files
				if(in_array($upgrade_file, $upgrade_files) && file_exists($upgrades_path . $upgrade_file)){
					// run upgrade
					include($upgrades_path . $upgrade_file);
					// make sure we don't do it again
					$processed_upgrades[] = $upgrade_file;
				}
			}
			
			// store processed upgrade files
			elgg_set_processed_upgrades($processed_upgrades);
		}
	}
	