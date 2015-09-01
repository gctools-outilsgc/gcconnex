<?php

/**
 * An action to process temporary file uploads.
 * Creates new entities and disables them
 *
 * @uses $_FILES['file_temp'] Looks for file_temp uploads
 */
$guids = hj_framework_process_file_upload('file_temp');

if ($guids) {
	foreach ($guids as $name => $guid) {
		$response[$name] = $guid;
		$entity = get_entity($guid);
		if ($entity) {
			$entity->disable('temp_file_upload');
		}
	}
}

if (elgg_is_xhr()) {
	print json_encode($response);
}

forward('', 'action');