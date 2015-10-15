<?php

elgg_load_library('elgg:event_calendar');

$event_guid = get_input('guid', false);

if (!$event_guid) {
	return true;
}

$event = get_entity($event_guid);

if (!elgg_instanceof($event, 'object', 'event_calendar')) {
	return true;
}

$owner_link = elgg_view('output/url', array(
	'href' => "events/owner/" . $event->getOwnerEntity()->username,
	'text' => $event->getOwnerEntity()->name,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($event->time_created);

$owner_icon = elgg_view_entity_icon($event->getOwnerEntity(), 'tiny');

$subtitle = "$author_text $date";

$info = '';
$event_items = event_calendar_get_formatted_full_items($event);

foreach($event_items as $item) {
	$value = $item->value;
	if (!empty($value)) {
		$info .= '<div class="mts">';
		$info .= '<label>' . $item->title.': </label>';
		$info .= $item->value . '</div>';
	}
}
if ($event->description) {
	$info .= '<div class="mts">' . $event->description . '</div>';
}

$params = array(
	'entity' => $event,
	'title' => false,
	'metadata' => '',
	'subtitle' => $subtitle,
	'tags' => $tags,
);
$list_body = elgg_view('object/elements/summary', $params);

$summary = elgg_view_image_block($owner_icon, $list_body, $params);

$title = elgg_view_title($event->title);

echo '<div style="max-width:320px;">' . $title . $summary . $info . '</div>';
echo '<div align="center" class="mtm mbs">' . elgg_view('output/url', array(
	'href' => $event->getURL() . '#event_calendar-comments',
	'text' => elgg_echo('generic_comments:add'),
	'is_trusted' => true,
	'class' => 'elgg-button elgg-button-action'
)) . '</div>';