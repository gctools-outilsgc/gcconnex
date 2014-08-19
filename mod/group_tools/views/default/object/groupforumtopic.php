<?php
/**
 * Forum topic entity view
 *
 * @package ElggGroups
*/

$full = elgg_extract('full_view', $vars, FALSE);
$topic = elgg_extract('entity', $vars, FALSE);

if (!$topic) {
	return true;
}

$poster = $topic->getOwnerEntity();
$group = $topic->getContainerEntity();
$excerpt = elgg_get_excerpt($topic->description);

$poster_icon = elgg_view_entity_icon($poster, 'tiny');
$poster_link = elgg_view('output/url', array(
	'href' => $poster->getURL(),
	'text' => $poster->name,
	'is_trusted' => true,
));
$poster_text = elgg_echo('groups:started', array($poster->name));
$container_text = "";
if ($group instanceof ElggGroup) {
	if (!elgg_get_page_owner_guid() || (elgg_get_page_owner_guid() != $group->getGUID())) {
		$container_text = elgg_echo("groups:ingroup") . " " . elgg_view("output/url", array(
			"text" => $group->name,
			"href" => $group->getURL(),
			"is_trusted" => true));
	}
}


$tags = elgg_view('output/tags', array('tags' => $topic->tags));
$date = elgg_view_friendly_time($topic->time_created);

$replies_link = '';
$reply_text = '';
$num_replies = elgg_get_annotations(array(
	'annotation_name' => 'group_topic_post',
	'guid' => $topic->getGUID(),
	'count' => true,
));
if ($num_replies != 0) {
	$last_reply = $topic->getAnnotations('group_topic_post', 1, 0, 'desc');
	$poster = $last_reply[0]->getOwnerEntity();
	$reply_time = elgg_view_friendly_time($last_reply[0]->time_created);
	$reply_text = elgg_echo('groups:updated', array($poster->name, $reply_time));

	$replies_link = elgg_view('output/url', array(
		'href' => $topic->getURL() . '#group-replies',
		'text' => elgg_echo('group:replies') . " ($num_replies)",
		'is_trusted' => true,
	));
}

// do not show the metadata and controls in widget view
$metadata = '';
if (!elgg_in_context('widgets')) {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'discussion',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

if ($full) {
	$title = "";
	if ($topic->status == "closed") {
		$title .= "<span title='" . htmlspecialchars(elgg_echo("groups:topicisclosed"), ENT_QUOTES, "UTF-8", false) . "'>" . elgg_view_icon("lock-closed") . "</span>";;
	}
	$title .= $topic->title;
	$subtitle = "$poster_text $date $replies_link";

	$params = array(
		'entity' => $topic,
		'metadata' => $metadata,
		'title' => $title,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	$info = elgg_view_image_block($poster_icon, $list_body);

	$body = elgg_view('output/longtext', array('value' => $topic->description));

	echo <<<HTML
$info
$body
HTML;

} else {
	// brief view
	$title = "";
	if ($topic->status == "closed") {
		$title .= "<span title='" . htmlspecialchars(elgg_echo("groups:topicisclosed"), ENT_QUOTES, "UTF-8", false) . "'>" . elgg_view_icon("lock-closed") . "</span>";;
	}
	$title .= elgg_view("output/url", array(
		"text" => $topic->title,
		"href" => $topic->getURL(),
		"is_trusted" => true
	));

	$subtitle = "$poster_text $container_text $date $replies_link <span class=\"groups-latest-reply\">$reply_text</span>";

	$params = array(
		'entity' => $topic,
		'metadata' => $metadata,
		'title' => $title,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($poster_icon, $list_body);
}
