<?php
/**
 * Forum topic entity view
 *
 * @package ElggGroups
*/

$full = elgg_extract('full_view', $vars, FALSE);
$topic = elgg_extract('entity', $vars, FALSE);

if (!$topic) {
	return;
}

$poster = $topic->getOwnerEntity();
if (!$poster) {
	elgg_log("User {$topic->owner_guid} could not be loaded, and is needed to display entity {$topic->guid}", 'WARNING');
	if ($full) {
		forward('', '404');
	}
	return;
}

$excerpt = elgg_get_excerpt($topic->description);

$poster_icon = elgg_view_entity_icon($poster, 'medium');
$poster_link = elgg_view('output/url', array(
	'href' => $poster->getURL(),
	'text' => $poster->name,
	'is_trusted' => true,
));

$poster_text = elgg_echo('groups:started', array($poster_link));
//$poster_text = elgg_echo('groups:started', array($poster->name));

$tags = elgg_view('output/tags', array('tags' => $topic->tags));
$date = elgg_view_friendly_time($topic->time_created);

$replies_link = '';
$reply_text = '';

$num_replies = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'discussion_reply',
	'container_guid' => $topic->getGUID(),
	'count' => true,
	'distinct' => false,
));

if ($num_replies != 0) {
	$last_reply = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'discussion_reply',
		'container_guid' => $topic->getGUID(),
		'limit' => 1,
		'distinct' => false,
	));
	if (isset($last_reply[0])) {
		$last_reply = $last_reply[0];
	}

	$poster = $last_reply->getOwnerEntity();
    
    
    //added to get link of person who replied
    $poster_reply_link = elgg_view('output/url', array(
        'href' => $poster->getURL(),
        'text' => $poster->name,
        'is_trusted' => true,
    ));
    
	$reply_time = elgg_view_friendly_time($last_reply->time_created);
	$reply_text = elgg_echo('groups:updated', array($poster_reply_link, $reply_time));


	$replies_link = elgg_view('output/url', array(
		'href' => $topic->getURL() . '#group-replies',
		'text' => "$num_replies " . elgg_echo('group:replies'),
		'is_trusted' => true,
	));
}

// We are showing the meta data and the ability to share and like from the widget view 
if (elgg_in_context('widgets')) {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'discussion',
		'sort_by' => 'priority',
		'class' => 'list-inline',
        'item_class' => 'mrgn-rght-sm',
	));
} else {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'discussion',
		'sort_by' => 'priority',
		'class' => 'list-inline',
        'item_class' => 'mrgn-rght-sm',
	));
}

if ($full) {
    //                              $replies_link - went here
	$subtitle = "$poster_text $date ";

	$params = array(
		'entity' => $topic,
        'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	$info = elgg_view_image_block($poster_icon, $list_body);

	$body = elgg_view('output/longtext', array(
		'value' => $topic->description,
		'class' => 'clearfix mrgn-lft-sm mrgn-rght-sm mrgn-tp-md',
	));
    
    $repliesFoot = '<div class="col-xs-12 text-right">' . $replies_link . '</div>';

	echo <<<HTML
<div class="panel-heading clearfix">$info</div>
$body
$repliesFoot
HTML;

} else {
	// brief view
	$subtitle = "<p class=\"mrgn-tp-sm mrgn-bttm-0\">$poster_text $date</p> <p class=\"mrgn-bttm-sm\">$reply_text</p> $replies_link";

	$params = array(
		'entity' => $topic,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($poster_icon, $list_body);
}
