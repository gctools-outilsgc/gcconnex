<?php
/**
 * show the blogs owned by the provided user
 */

$container_guid = (int) get_input("owner_guid");

$params["filter_context"] = "mine";

$options = array(
	"type" => "object",
	"subtype" => "blog",
	"full_view" => false,
);

$current_user = elgg_get_logged_in_user_entity();

if ($container_guid) {
	// access check for closed groups
	//group_gatekeeper();

	$options["owner_guid"] = $container_guid;
	$container = get_entity($container_guid);
	
	$params["title"] = elgg_echo("blog:title:user_blogs", array($container->name));

	elgg_push_breadcrumb($container->name);

	if ($current_user && ($container_guid == $current_user->getGUID())) {
		$params["filter_context"] = "mine";
	} elseif (elgg_instanceof($container, "group")) {
		$params["filter"] = false;
	} else {
		// do not show button or select a tab when viewing someone else"s posts
		$params["filter_context"] = "none";
	}
}

elgg_register_title_button();

// show all posts for admin or users looking at their own blogs
// show only published posts for other users.
$show_only_published = true;
if ($current_user) {
	if (($current_user->getGUID() == $container_guid) || $current_user->isAdmin()) {
		$show_only_published = false;
	}
}
if ($show_only_published) {
	$options["metadata_name_value_pairs"] = array(
		"name" => "status",
		"value" => "published"
	);
}

$list = elgg_list_entities_from_metadata($options);
if (!$list) {
	$params["content"] = elgg_echo("blog:none");
} else {
	$params["content"] = $list;
}

$params["sidebar"] = elgg_view("blog/sidebar", array("page" => $page_type));

$body = elgg_view_layout("content", $params);

echo elgg_view_page($params["title"], $body);
