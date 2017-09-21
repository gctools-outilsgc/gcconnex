<?php

$container_guid = (int) get_input("container_guid", 0);
$access_id = (int) get_input("access_id");
$parent_guid = get_input("parent_guid");
$tags = get_input("tags");

set_time_limit(0);

$forward_url = REFERER;
$googledoc_url = get_input("googledoc_url");
$prefix = "file/";

if( filter_var($googledoc_url, FILTER_VALIDATE_URL) === FALSE ){
	register_error(elgg_echo("file_tools:invalidurl"));
	forward($forward_url);
}

if( !preg_match("~^(https?://)?(docs\.)?google\.com/?~", $googledoc_url) ){
	register_error(elgg_echo("file_tools:invalidurl"));
	forward($forward_url);
}

if( !empty($container_guid) && !empty($googledoc_url) ){

	preg_match("/<title>(.+)<\/title>/siU", file_get_contents($googledoc_url), $matches);
	$title = $matches[1];

	$file = new FilePluginFile();
	$file->subtype = "file";

	$filestorename = elgg_strtolower(time().$title);
	$file->setFilename($prefix . $filestorename);

	$file->title = $title;
	$file->url = $googledoc_url;
	$file->container_guid = $container_guid;
	$file->access_id = $access_id;

	$file->setMimeType("googledoc");
	$file->simpletype = "googledoc";

	if( $tags ){
		$file->tags = string_to_tag_array($tags);
	}

	$guid = $file->save();

	if ($guid) {
		$message = elgg_echo("file:saved");
		system_message($message);
		elgg_create_river_item(array(
			'view' => 'river/object/file/create',
			'action_type' => 'create',
			'subject_guid' => elgg_get_logged_in_user_guid(),
			'object_guid' => $file->guid,
		));
	} else {
		// failed to save file object - nothing we can do about this
		$error = elgg_echo("file:uploadfailed");
		register_error($error);
	}

	$container = get_entity($container_guid);
	if (elgg_instanceof($container, 'group')) {
		forward("file/group/$container->guid/all");
	} else {
		forward("file/owner/$container->username");
	}
} else {
	register_error(elgg_echo("file:cannotload"));
}

forward($forward_url);