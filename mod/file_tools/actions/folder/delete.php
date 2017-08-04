<?php

$folder_guid = (int) get_input('guid');
if (empty($folder_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$folder = get_entity($folder_guid);
if (!elgg_instanceof($folder, 'object', FILE_TOOLS_SUBTYPE) || !$folder->canDelete()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

if ($folder->delete()) {
	system_message(elgg_echo('file_tools:actions:delete:success'));
} else {
	register_error(elgg_echo('file_tools:actions:delete:error:delete'));
}

forward(REFERER);
