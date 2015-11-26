<?php
/**
 * View a wire post
 *
 * @uses $vars["entity"]
 */

elgg_load_js("elgg.thewire");

$full = elgg_extract("full_view", $vars, FALSE);
$post = elgg_extract("entity", $vars, FALSE);

if (!$post) {
	return true;
}

// make compatible with posts created with original Curverider plugin
$thread_id = $post->wire_thread;
if (!$thread_id) {
	$post->wire_thread = $post->guid;
}

$show_thread = false;
if (!elgg_in_context("thewire_tools_thread") && !elgg_in_context("thewire_thread")) {
	if ($post->countEntitiesFromRelationship("parent") || $post->countEntitiesFromRelationship("parent", true)) {
		$show_thread = true;
	}
}

$owner = $post->getOwnerEntity();
$container = $post->getContainerEntity();
//$subtitle = array();

$owner_icon = elgg_view_entity_icon($owner, "medium", array('class' => 'img-responsive'));
$owner_link = elgg_view("output/url", array(
	"href" => "thewire/owner/$owner->username",
	"text" => $owner->name,
	"is_trusted" => true,
));
//$subtitle[] = elgg_echo("byline", array($owner_link));
//$subtitle[] = elgg_view_friendly_time($post->time_created);

$metadata = elgg_view_menu("entity", array(
	"entity" => $post,
	"handler" => "thewire",
	"sort_by" => "priority",
	'class' => 'list-inline mrgn-bttm-sm mrgn-tp-sm',
));

// check if need to show group
if (elgg_instanceof($container, "group") && ($container->getGUID() != elgg_get_page_owner_guid())) {
	$group_link = elgg_view("output/url", array(
		"href" => "thewire/group/" . $container->getGUID(),
		"text" => $container->name,
		"class" => "thewire_tools_object_link"
	));
	
	//$subtitle[] = elgg_echo("river:ingroup", array($group_link));
}

// show text different in widgets
$text = $post->description;
if (elgg_in_context("widgets")) {
	$text = elgg_get_excerpt($text, 140);
	
	// show more link?
	if (substr($text, -3) == "...") {
		$text .= elgg_view("output/url", array(
			"text" => elgg_echo("more"),
			"href" => $post->getURL(),
			"is_trusted" => true,
			"class" => "mlm"
		));
	}
}

$content = thewire_tools_filter($text);

// check for reshare entity
$reshare = $post->getEntitiesFromRelationship(array("relationship" => "reshare", "limit" => 1));
if (!empty($reshare)) {
	$content .= "<div class='elgg-divide-left pls timeStamp clearfix mrgn-lft-sm'>";
	$content .= elgg_view("thewire_tools/reshare_source", array("entity" => $reshare[0]));
	$content .= "</div>";
}

if (elgg_is_logged_in() && !elgg_in_context("thewire_tools_thread")) {
	$form_vars = array(
		"id" => "thewire-tools-reply-" . $post->getGUID(),
		"class" => "hidden"
	);
	$content .= elgg_view_form("thewire/add", $form_vars, array("post" => $post));
}

$author_text = elgg_echo($owner_link);
$date = elgg_view_friendly_time($post->time_created);
$subtitle = "$author_text <i class=\"timeStamp\">$date</i>";

$params = array(
	"entity" => $post,
	"metadata" => $metadata,
	//"subtitle" => implode(" ", $subtitle),
    'subtitle' => $subtitle,
	"content" => $content,
	"tags" => false,
);
$params = $params + $vars;
$list_body = elgg_view("object/elements/thewire_summary", $params);

echo elgg_view_image_block($owner_icon, $list_body);

if ($show_thread) {
	echo elgg_format_element("div", array(
		"id" => "thewire-thread-" . $post->getGUID(),
		"class" => "thewire-thread",
		"data-thread" => $post->wire_thread,
		"data-guid" => $post->getGUID()
	));
}
