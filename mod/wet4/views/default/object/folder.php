<?php

$folder = elgg_extract("entity", $vars);
$full_view = elgg_extract("full_view", $vars, false);

$time_preference = "date";

if ($user_time_preference = elgg_get_plugin_user_setting('file_tools_time_display', null, "file_tools")) {
	$time_preference = $user_time_preference;
} elseif ($site_time_preference = elgg_get_plugin_setting("file_tools_default_time_display", "file_tools")) {
	$time_preference = $site_time_preference;
}

if ($time_preference == 'date') {
	$friendlytime 	= date(elgg_echo("friendlytime:date_format"), $folder->time_created);
} else {
	$friendlytime 	= elgg_view_friendly_time($folder->time_created);
}

$title = $folder->title;
if (empty($title)) {
	$title = elgg_echo("untitled");
}
$params = array(
	'text' => elgg_get_excerpt($title, 100),
	'href' => $folder->getURL(),
	'is_trusted' => true,
);
$title = elgg_view('output/url', $params);

$entity_menu = "";
if (!elgg_in_context("widgets")) {
	$entity_menu = elgg_view_menu("entity", array(
		"entity" => $folder,
		"handler" => "file_tools/folder",
		"sort_by" => "priority",
		"class" => "elgg-menu-hz",
        'item_class' => 'mrgn-rght-sm',
	));
}

if ($full_view) {
	// full view
	$icon = elgg_view_entity_icon($folder, "small", array('img_class' => 'img-responsive',));
	
	$owner_link = elgg_view("output/url", array("text" => $folder->getOwnerEntity()->name, "href" => $folder->getOwnerEntity()->getURL()));
	$owner_text = elgg_echo("byline", array($owner_link));
	
	$subtitle = "$owner_text $friendlytime";
	
	$params = array(
		"entity" => $folder,
		"title" => $title,
		"metadata" => $entity_menu,
		"tags" => elgg_view("output/tags", array("value" => $folder->tags)),
		"subtitle" => $subtitle
	);
	
	$params = $params + $vars;
	$summary = elgg_view("object/elements/summary", $params);
	
	echo elgg_view("object/elements/full", array(
		"entity" => $folder,
		"title" => false,
		"icon" => $icon,
		"summary" => $summary,
		"body" => elgg_view("output/longtext", array("value" => $folder->description))
	));
    elgg_unregister_menu_item('title2', 'new_folder');
} else {
	// summary view
	$icon = elgg_view_entity_icon($folder, "small");
	$icon_alt = "";
	if (!elgg_in_context("widgets")) {
		$icon_alt = elgg_view("input/checkbox", array("name" => "folder_guids[]", "value" => $folder->getGUID(), "default" => false));
	}
	
	$params = array(
		"entity" => $folder,
		"title" => $title,
		"metadata" => $entity_menu
	);
	
	$params = $params + $vars;
	$list_body = elgg_view("object/elements/summary", $params);
	
	echo elgg_view_image_block($icon, $list_body, array("class" => "file-tools-folder", "image_alt" => $icon_alt));
}
