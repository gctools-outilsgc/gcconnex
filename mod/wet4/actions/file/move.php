<?php
$files 		= (string) get_input("file_guid", 0);
$folder_guid 	= (int) get_input("folder_guid", 0);
$fileGUID = explode(',', $files);
$removeFinal = array_pop($fileGUID);
foreach($fileGUID as $file_guid){
    //check if file guid is there
    if (!empty($file_guid)) {
        //get entity
        if ($file = get_entity($file_guid)) {
            $container_entity = $file->getContainerEntity();
            if (($file->canEdit() || (elgg_instanceof($container_entity, "group") && $container_entity->isMember()))) {
                if (elgg_instanceof($file, "object", "file")) {
                    // check if a given guid is a folder
                    if (!empty($folder_guid)) {
                        if (!($folder = get_entity($folder_guid)) || !elgg_instanceof($folder, "object", FILE_TOOLS_SUBTYPE)) {
                            unset($folder_guid);
                        }
                    }
                    // remove old relationships
                    remove_entity_relationships($file->getGUID(), FILE_TOOLS_RELATIONSHIP, true);
                    if (!empty($folder_guid)) {
                        add_entity_relationship($folder_guid, FILE_TOOLS_RELATIONSHIP, $file_guid);
                    }
                    system_message(elgg_echo("file_tools:action:move:success:file"));
                } elseif (elgg_instanceof($file, "object", FILE_TOOLS_SUBTYPE)) {
                    $file->parent_guid = $folder_guid;
                    system_message(elgg_echo("file_tools:action:move:success:folder"));
                }
            } else {
                register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
            }
        } else {
            register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
        }
    } else {
        register_error(elgg_echo("InvalidParameterException:MissingParameter"));
    }
    if($folder_guid == 'root'){
        remove_entity_relationships($file_guid, FILE_TOOLS_RELATIONSHIP, true);
    }
}
forward(REFERER);