<?php

elgg_load_js("elgg.thewire");

$entity = $vars['entity'];
$lang = get_current_language();

if (!$entity) {
	return true;
}

// make compatible with posts created with original Curverider plugin
$thread_id = $entity->wire_thread;
if (!$thread_id) {
	$entity->wire_thread = $entity->guid;
}

$show_thread = false;
if (!elgg_in_context("thewire_tools_thread") && !elgg_in_context("thewire_thread")) {
	if ($entity->countEntitiesFromRelationship("parent") || $entity->countEntitiesFromRelationship("parent", true)) {
		$show_thread = true;
	}
}

$owner = $entity->getOwnerEntity();
$container = $entity->getContainerEntity();
$subtitle = array();

$owner_icon = elgg_view_entity_icon($owner, "medium");
$owner_link = elgg_view("output/url", array(
	"href" => "thewire/owner/$owner->username",
	"text" => $owner->name,
	"is_trusted" => true,
));
$subtitle[] = elgg_echo("byline", array($owner_link));
$subtitle[] = elgg_view_friendly_time($entity->time_created);

$metadata = elgg_view_menu("entity", array(
	"entity" => $entity,
	"handler" => "thewire",
	"sort_by" => "priority",
	"class" => "list-inline",
));

// check if need to show group
if (elgg_instanceof($container, "group") && ($container->getGUID() != elgg_get_page_owner_guid())) {
	$group_link = elgg_view("output/url", array(
		"href" => "thewire/group/" . $container->getGUID(),
		"text" => $container->name,
		"class" => "thewire_tools_object_link"
	));
	
	$subtitle[] = elgg_echo("river:ingroup", array($group_link));
}

// show text different in widgets
$description = gc_explode_translation($entity->getVolatileData('search_matched_description'), $lang);
if (elgg_in_context("widgets")) {
	$description = elgg_get_excerpt($description, 140);
	
	// show more link?
	if (substr($description, -3) == "...") {
		$description .= elgg_view("output/url", array(
			"text" => elgg_echo("more"),
			"href" => $entity->getURL(),
			"is_trusted" => true,
			"class" => "mlm"
		));
	}
}

$content = thewire_tools_filter($description);

// check for reshare entity
$reshare = $entity->getEntitiesFromRelationship(array("relationship" => "reshare", "limit" => 1));
if (!empty($reshare)) {
	$content .= "<div class='elgg-divide-left pls'>";
	$content .= elgg_view("thewire_tools/reshare_source", array("entity" => $reshare[0]));
	$content .= "</div>";
}

if (elgg_is_logged_in() && !elgg_in_context("thewire_tools_thread")) {
	$form_vars = array(
		"id" => "thewire-tools-reply-" . $entity->getGUID(),
		"class" => "hidden"
	);
	$content .= elgg_view_form("thewire/add", $form_vars, array("post" => $entity));
}

$params = array(
	"entity" => $entity,
	"metadata" => $metadata,
	"title" => false,
	"subtitle" => implode(" ", $subtitle),
	"content" => $content,
	"tags" => false,
);
$list_body = elgg_view("object/elements/summary", $params);

echo elgg_view_image_block($owner_icon, $list_body);

if ($show_thread) {
	echo elgg_format_element("div", array(
		"id" => "thewire-thread-" . $entity->getGUID(),
		"class" => "thewire-thread",
		"data-thread" => $entity->wire_thread,
		"data-guid" => $entity->getGUID()
	));
}
