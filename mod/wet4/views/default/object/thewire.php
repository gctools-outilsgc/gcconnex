<?php
/**
 * View a wire post
 *
 * @uses $vars["entity"]
 *
 * GC_MODIFICATION
 * Description: Added wet classes + styling
 * Author: GCTools Team
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

$owner_icon = elgg_view_entity_icon($owner, "small", array('class' => 'img-responsive'));
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
	'class' => 'list-inline mrgn-tp-md',
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
$text = urldecode(htmlspecialchars_decode($post->description, ENT_QUOTES));

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
	$content .= '<a class="wire-share-container timeStamp" href="'.$reshare[0]->getURL().'">';
	$content .= elgg_view("thewire_tools/reshare_source", array("entity" => $reshare[0]));
	$content .= "</a>";
}

if (elgg_is_logged_in() && !elgg_in_context("thewire_tools_thread")) {
	$form_vars = array(
		"id" => "thewire-tools-reply-" . $post->getGUID(),
		"class" => "hidden"
	);
	//$content .= elgg_view_form("thewire/add", $form_vars, array("post" => $post));
}

$author_text = elgg_echo($owner_link);
$date = '<span class="timeStamp mrgn-lft-sm"> - ' .elgg_view_friendly_time($post->time_created). '</span>';

$params = array(
	"entity" => $post,
	"metadata" => $metadata,
	"content" => $content,
	"tags" => false,
	"title" => false,
);
$params = $params + $vars;
$list_body = elgg_view("object/elements/thewire_summary", $params);

// $format_header = elgg_format_element('div', ['class' => 'd-flex mrgn-bttm-md'], $owner_icon . '<div class="mrgn-lft-sm">'.$author_text .$date.'</div>');
$format_wire = elgg_format_element('div', ['class' => 'd-flex new-wire-list-object'], '<div class="mrgn-rght-md">'.$owner_icon.'</div><div style="width:100%; flex-shrink:8;">' . $author_text . $date. $list_body.'</div>');

echo $format_wire;
if ($show_thread) {
	echo elgg_format_element("div", array(
		"id" => "thewire-thread-" . $post->getGUID(),
		"class" => "thewire-thread",
		"data-thread" => $post->wire_thread,
		"data-guid" => $post->getGUID()
	));
}
