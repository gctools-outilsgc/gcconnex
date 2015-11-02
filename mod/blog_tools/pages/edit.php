<?php
/**
 * Create/edit a blog
 */

gatekeeper();

elgg_load_library("elgg:blog");
elgg_require_js('elgg/blog/save_draft');

// get inputs
$page_type = get_input("page_type");
$guid = (int) get_input("guid");
$revision = get_input("revision");

$params = array(
	"filter" => ""
);

$vars = array();
$vars["id"] = "blog-post-edit";
$vars["name"] = "blog_post";
$vars["class"] = "elgg-form-alt";
$vars["enctype"] = "multipart/form-data";

$sidebar = "";

if ($page_type == "edit") {
	$blog = get_entity($guid);

	$title = elgg_echo("blog:edit");

	if (elgg_instanceof($blog, "object", "blog") && $blog->canEdit()) {
		$vars["entity"] = $blog;

		$title .= ": " . $blog->title;
		
		if ($revision) {
			$revision = elgg_get_annotation_from_id((int)$revision);
			$vars["revision"] = $revision;
			$title .= " " . elgg_echo("blog:edit_revision_notice");

			if (!$revision || !($revision->entity_guid == $guid)) {
				$content = elgg_echo("blog:error:revision_not_found");
				$params["content"] = $content;
				$params["title"] = $title;
				
				return $params;
			}
		}
		
		$body_vars = blog_prepare_form_vars($blog, $revision);
		
		elgg_push_breadcrumb($blog->title, $blog->getURL());
		elgg_push_breadcrumb(elgg_echo("edit"));
			
		$content = elgg_view_form("blog/save", $vars, $body_vars);
		$sidebar = elgg_view("blog/sidebar/revisions", $vars);
	} else {
		$content = elgg_echo("blog:error:cannot_edit_post");
	}
} else {
	if (!$guid) {
		$container = elgg_get_logged_in_user_entity();
	} else {
		$container = get_entity($guid);
	}

	elgg_push_breadcrumb(elgg_echo("blog:add"));
	$body_vars = blog_prepare_form_vars();

	$title = elgg_echo("blog:add");
	$content = elgg_view_form("blog/save", $vars, $body_vars);
}

$params["title"] = $title;
$params["content"] = $content;
$params["sidebar"] = $sidebar;

$params["sidebar"] .= elgg_view("blog/sidebar", array("page" => $page_type));

$body = elgg_view_layout("content", $params);

echo elgg_view_page($params["title"], $body);
	
