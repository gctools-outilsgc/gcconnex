<?php
/**
 * Default view for an entity returned in a search
*
* Display largely controlled by a set of overrideable volatile data:
*   - search_icon (defaults to entity icon)
*   - search_matched_title
*   - search_matched_description
*   - search_matched_extra
*   - search_url (defaults to entity->getURL())
*   - search_time (defaults to entity->time_updated or entity->time_created)
*
* @uses $vars['entity'] Entity returned in a search
*/

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof ElggAnswer)) {
	return;
}

$question = $entity->getContainerEntity();

// entity icon
$icon = $entity->getVolatileData('search_icon');
if (!$icon) {
	// display the entity's owner by default if available.
	$owner = $entity->getOwnerEntity();
	
	$icon = elgg_view_entity_icon($owner, 'tiny');
}

// search results
$description = $entity->getVolatileData('search_matched_description');
$extra_info = $entity->getVolatileData('search_matched_extra');
$url = $entity->getVolatileData('search_url');

if (!$url) {
	$url = $entity->getURL();
}

// make title
$answer_link = elgg_view('output/url', [
	'text' => elgg_echo('questions:search:answer:title'),
	'href' => $entity->getURL(),
	'is_trusted' => true,
]);
$question_link = elgg_view('output/url', [
	'text' => $question->title,
	'href' => $question->getURL(),
	'is_trusted' => true,
]);

$title = elgg_echo('generic_comment:on', [$answer_link, $question_link]);

// question in a group?
$question_container = $question->getContainerEntity();
if (($question_container instanceof ElggGroup) && (elgg_get_page_owner_guid() !== $question_container->getGUID())) {
	$group_link = elgg_view('output/url', [
		'text' => $question_container->name,
		'href' => $question_container->getURL(),
		'is_trusted' => true,
	]);
	$title .= ' ' . elgg_echo('river:ingroup', [$group_link]);
}

// time part
$time = $entity->getVolatileData('search_time');
if (!$time) {
	$tc = $entity->time_created;
	$tu = $entity->time_updated;
	$time = elgg_view_friendly_time(($tu > $tc) ? $tu : $tc);
}

// build result
$body = elgg_format_element('p', ['class' => 'mbn'], $title);
$body .= $description;
if ($extra_info) {
	$body .= elgg_format_element('p', ['class' => 'elgg-subtext'], $extra_info);
}
$body .= elgg_format_element('p', ['class' => 'elgg-subtext'], $time);

echo elgg_view_image_block($icon, $body);
