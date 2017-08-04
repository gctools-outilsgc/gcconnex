<?php

$file_guid = (int) get_input('file_guid', 0);
$folder_guid = (int) get_input('folder_guid', 0);

if (empty($file_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$file = get_entity($file_guid);
if (empty($file)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$container_entity = $file->getContainerEntity();
if (!$file->canEdit() && (($container_entity instanceof ElggGroup) && !$container_entity->isMember())) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

if ($file instanceof ElggFile) {
	// check if a given guid is a folder
	if (!empty($folder_guid)) {
		$folder = get_entity($folder_guid);
		if (empty($folder) || !elgg_instanceof($folder, 'object', FILE_TOOLS_SUBTYPE)) {
			unset($folder_guid);
		}
	}
	
	// remove old relationships
	remove_entity_relationships($file->getGUID(), FILE_TOOLS_RELATIONSHIP, true);
	
	if (!empty($folder_guid)) {
		add_entity_relationship($folder_guid, FILE_TOOLS_RELATIONSHIP, $file_guid);
	}
	
	system_message(elgg_echo('file_tools:action:move:success:file'));
	
} elseif (elgg_instanceof($file, 'object', FILE_TOOLS_SUBTYPE)) {
	$file->parent_guid = $folder_guid;
	
	system_message(elgg_echo('file_tools:action:move:success:folder'));
}

forward(REFERER);
