<?php
/**
 * Elgg file browser.
 * File renderer.
 *
 * @package ElggFile
 */

$file = elgg_extract("entity", $vars, false);
$full_view = elgg_extract("full_view", $vars, false);

if (empty($file)) {
	return true;
}

$file_guid = $file->getGUID();
$owner = $file->getOwnerEntity();

$tags = elgg_view("output/tags", array("value" => $file->tags));
$categories = elgg_view('output/categories', $vars);

$title = $file->title;
$mime = $file->mimetype;
$base_type = substr($mime, 0, strpos($mime,'/'));

$owner_link = elgg_view("output/url", array("text" => $owner->name, "href" => $owner->getURL(), "is_trusted" => true));
$author_text = elgg_echo("byline", array($owner_link));

// which time format to show
$time_preference = "date";

if ($user_time_preference = elgg_get_plugin_user_setting("file_tools_time_display", null, "file_tools")) {
	$time_preference = $user_time_preference;
} elseif ($site_time_preference = elgg_get_plugin_setting("file_tools_default_time_display", "file_tools")) {
	$time_preference = $site_time_preference;
}

if ($time_preference == "date") {
	$date = date(elgg_echo("friendlytime:date_format"), $file->time_created);
} else {
	$date = elgg_view_friendly_time($file->time_created);
}
$date = date(elgg_echo("friendlytime:date_format"), $file->time_created);
// count comments
$comments_link = "";
$comment_count = (int) $file->countComments();
if ($comment_count > 0) {
	$comments_link = elgg_view("output/url", array(
		"href" => $file->getURL() . "#file-comments",
		"text" => elgg_echo("comments") . " ($comment_count)",
		"is_trusted" => true,
	));
}

$subtitle = "$author_text $date $comments_link $categories";

// title
if (empty($title)) {
	$title = elgg_echo("untitled");
}

// entity actions
$entity_menu = "";
if (!elgg_in_context("widgets")) {
	$entity_menu = elgg_view_menu("entity", array(
		"entity" => $file,
		"handler" => "file",
		"sort_by" => "priority",
		"class" => "elgg-menu-hz",
		"item_class" => "mrgn-rght-sm"
	));
}

if ($full_view && !elgg_in_context("gallery")) {
	// normal full view
    
    //remove new folder button when looking at single file
	elgg_unregister_menu_item('title', 'new_folder');
    
	// add folder structure to the breadcrumbs
	if (file_tools_use_folder_structure()) {
		// @todo this should probably be moved to the file view page, but that is currently not under control of file_tools
		$endpoint = elgg_pop_breadcrumb();
		
		$parent_folder = elgg_get_entities_from_relationship(array(
			'relationship' => 'folder_of',
			'relationship_guid' => $file->getGUID(),
			'inverse_relationship' => true
		));

		$folders = array();
		if ($parent_folder) {

			$parent_guid = (int) $parent_folder[0]->guid;

			while (!empty($parent_guid) && ($parent = get_entity($parent_guid))) {
				$folders[] = $parent;
				$parent_guid = (int) $parent->parent_guid;
			}
		}

		while ($p = array_pop($folders)) {
			elgg_push_breadcrumb($p->title, $p->getURL());
		}

		elgg_push_breadcrumb($file->title);
	}

	$extra = "";
	if (elgg_view_exists("file/specialcontent/$mime")) {
		$extra = elgg_view("file/specialcontent/$mime", $vars);
	} elseif (elgg_view_exists("file/specialcontent/$base_type/default")) {
		$extra = elgg_view("file/specialcontent/$base_type/default", $vars);
	}
	
	$params = array(
		"entity" => $file,
		"title" => elgg_view("output/url", array("text" => $title, "href" => "file/download/" . $file->getGUID())),
		"metadata" => $entity_menu,
		"subtitle" => $subtitle,
		"tags" => $tags
	);
	$params = $params + $vars;
	$summary = elgg_view("object/elements/summary", $params);
	
	$text = elgg_view("output/longtext", array("value" => $file->description));
	$body = "$text $extra";
	
	echo elgg_view("object/elements/full", array(
			"entity" => $file,
			"title" => false,
			"icon" => elgg_view_entity_icon($file, "small"),
			"summary" => $summary,
			"body" => $body
	));
    elgg_unregister_menu_item('title2', 'new_folder');

} elseif (elgg_in_context("gallery")) {
	// gallery view of the file
	echo "<div class='file-gallery-item'>";
	echo "<h3>" . $file->title . "</h3>";
	echo elgg_view_entity_icon($file, "medium");
	echo "<p class='elgg-quiet'>$owner_link $date</p>";
	echo "</div>";
} else {
	// listing view of the file
	$file_icon_alt = "";
	if (file_tools_use_folder_structure()) {
		$file_icon = elgg_view_entity_icon($file, "small", array("img_class" => "file-tools-icon-small img-responsive"));
		
		if (elgg_in_context("file_tools_selector")) {
			$file_icon_alt = elgg_view("input/checkbox", array("name" => "file_guids[]", "value" => $file->getGUID(), "default" => false, 'class' => '',));
		}
		
		$excerpt = "";
		$subtitle = "";
		$tags = "";
	} else {
		$file_icon = elgg_view_entity_icon($file, "small");
		$excerpt = elgg_get_excerpt($file->description);
	}



	$params = array(
		"entity" => $file,
		"metadata" => $entity_menu,
		"subtitle" => $subtitle . $author_text . ' ' . $date,
		"tags" => $tags,
		"content" => $excerpt
	);
	$params = $params + $vars;
	$list_body = elgg_view("object/elements/summary", $params);
    
    $subtype = $file->getSubtype();
    $guid = $file->getGUID();
	
	echo elgg_view_image_block($file_icon, $list_body, array("class" => "file-tools-file", "image_alt" => $file_icon_alt, 'subtype' => $subtype, 'guid' => $guid));
}
