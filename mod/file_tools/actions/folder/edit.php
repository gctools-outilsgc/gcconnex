<?php

$guid = (int) get_input('guid');
$title = get_input('title');
$title2 = get_input("title2");
$title3 = gc_implode_translation($title,$title2);
$owner_guid = (int) get_input('page_owner');
$description = get_input('description');
$description2 = get_input("description2");
$description3 = gc_implode_translation($description,$description2);
$parent_guid = (int) get_input('file_tools_parent_guid', 0); // 0 is top_level
$access_id = (int) get_input('access_id');
$change_children_access = get_input('change_children_access', false);
$change_files_access = get_input('change_files_access', false);

if (empty($title) || empty($title2) || empty($owner_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$owner = get_entity($owner_guid);
if (!($owner instanceof ElggUser) && !($owner instanceof ElggGroup)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

if (!empty($guid)) {
	// check if editing existing
	$folder = get_entity($guid);
	if (!elgg_instanceof($folder, 'object', FILE_TOOLS_SUBTYPE)) {
		unset($folder);
	}
} else {
	// create a new folder
	$folder = new ElggObject();
	$folder->subtype = FILE_TOOLS_SUBTYPE;
	$folder->owner_guid = elgg_get_logged_in_user_guid();
	$folder->container_guid = $owner_guid;
	$folder->access_id = $access_id;

	$order = elgg_get_entities_from_metadata([
		'type' => 'object',
		'subtype' => FILE_TOOLS_SUBTYPE,
		'metadata_name_value_pairs' => [
			'name' => 'parent_guid',
			'value' => $parent_guid
		],
		'count' => true
	]);

	$folder->order = $order;

	if (!$folder->save()) {
		unset($folder);
	}
}

if (empty($folder)) {
	register_error(elgg_echo('file_tools:action:edit:error:folder'));
	forward(REFERER);
}

// check for the correct parent_guid
if (!empty($parent_guid) && ($parent_guid === $folder->getGUID())) {
	register_error(elgg_echo('file_tools:action:edit:error:parent_guid'));
	forward(REFERER);
}

$folder->title = $title3;
$folder->description = $description3;

$folder->access_id = $access_id;

if (!empty($change_children_access)) {
	$folder->save();
	file_tools_change_children_access($folder, !empty($change_files_access));
} elseif (!empty($change_files_access)) {
	$folder->save();
	file_tools_change_files_access($folder);
}

$folder->parent_guid = $parent_guid;

if ($folder->save()) {
	system_message(elgg_echo('file_tools:action:edit:success'));
	forward( $folder->getURL());
}

register_error(elgg_echo('file_tools:action:edit:error:save'));
forward(REFERER);
