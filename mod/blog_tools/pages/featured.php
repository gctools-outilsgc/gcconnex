<?php
/**
 * list featured blogs
 */

$params["filter_context"] = "featured";

$options = array(
	"type" => "object",
	"subtype" => "blog",
	"full_view" => false,
	"metadata_name_value_pairs" => array(
		array("name" => "status", "value" => "published"),
		array("name" => "featured", "value" => "0", "operand" => " > "),
	)
);

$title = elgg_echo("blog_tools:menu:filter:featured");

elgg_push_breadcrumb($title);

elgg_register_title_button();

$list = elgg_list_entities_from_metadata($options);
if (!$list) {
	$params["content"] = elgg_echo("blog:none");
} else {
	$params["content"] = $list;
}

$params["sidebar"] = elgg_view("blog/sidebar", array("page" => null));

$body = elgg_view_layout("content", $params);

echo elgg_view_page($title, $body);
