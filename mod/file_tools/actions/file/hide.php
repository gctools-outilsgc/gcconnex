<?php

$action = get_input('hide');
$file_guid = (int) get_input('guid');

if (empty($file_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$file = get_entity($file_guid);

if (!($file instanceof \ElggFile)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

if (!$file->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

if ($action === 'show') {
	$file->show_in_widget = time();
} elseif ($action === 'hide') {
	unset($file->show_in_widget);
}

if (stristr($_SERVER['HTTP_REFERER'], 'file')) {
	
	$folders = elgg_get_entities_from_relationship([
		'type' => 'object',
		'subtype' => FILE_TOOLS_SUBTYPE,
		'container_guid' => $file->getOwnerGUID(),
		'limit' => 1,
		'relationship' => FILE_TOOLS_RELATIONSHIP,
		'relationship_guid' => $file->getGUID(),
		'inverse_relationship' => true,
	]);
	
	if (!empty($folders)) {
		$folder = $folders[0];
		
		forward($folder->getURL());
	}
}

forward(REFERER);
