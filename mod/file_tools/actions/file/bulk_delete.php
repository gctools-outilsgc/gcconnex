<?php

$file_guids = (array) get_input('file_guids', []);
$folder_guids = (array) get_input('folder_guids', []);

if (empty($file_guids) && empty($folder_guids)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

// remove all files
if (!empty($file_guids)) {
	$file_count = 0;
	
	$files = elgg_get_entities([
		'type' => 'object',
		'subtype' => 'file',
		'guids' => $file_guids,
		'limit' => false,
	]);
	
	foreach ($files as $file) {
		if (!$file->canDelete()) {
			continue;
		}
		
		if ($file->delete()) {
			$file_count++;
		}
	}
	
	if (!empty($file_count)) {
		system_message(elgg_echo('file_tools:action:bulk_delete:success:files', [$file_count]));
	} else {
		register_error(elgg_echo('file_tools:action:bulk_delete:error:files'));
	}
}

// remove folders
if (!empty($folder_guids)) {
	$folder_count = 0;
	
	$folders = elgg_get_entities([
		'type' => 'object',
		'subtype' => FILE_TOOLS_SUBTYPE,
		'guids' => $folder_guids,
		'limit' => false,
	]);
	
	foreach ($folders as $folder) {
		if ($folder->canDelete()) {
			continue;
		}
		
		if ($folder->delete()) {
			$folder_count++;
		}
	}
	
	if (!empty($folder_count)) {
		system_message(elgg_echo('file_tools:action:bulk_delete:success:folders', [$folder_count]));
	} else {
		register_error(elgg_echo('file_tools:action:bulk_delete:error:folders'));
	}
}

forward(REFERER);
