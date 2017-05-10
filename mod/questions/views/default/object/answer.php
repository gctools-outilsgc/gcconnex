<?php

$answer = elgg_extract('entity', $vars);
if (!($answer instanceof ElggAnswer)) {
	return;
}

$question = $answer->getContainerEntity();

$image = elgg_view_entity_icon($answer->getOwnerEntity(), 'small');

// mark this as the correct answer?
$correct_answer = $answer->getCorrectAnswerMetadata();
if ($correct_answer) {
	$owner = $correct_answer->getOwnerEntity();
	$owner_name = htmlspecialchars($owner->name);
	
	$timestamp = htmlspecialchars(date(elgg_echo('friendlytime:date_format'), $correct_answer->time_created));
	
	$title = elgg_echo('questions:answer:checkmark:title', [$owner_name, $timestamp]);
	
	$image .= elgg_format_element('div', ['class' => 'questions-checkmark', 'title' => $title]);
}

// create subtitle
$owner = $answer->getOwnerEntity();
$owner_link = elgg_view('output/url', [
	'text' => $owner->name,
	'href' => $owner->getURL(),
	'is_trusted' => true
]);

$friendly_time = elgg_view_friendly_time($answer->time_created);
$subtitle = $owner_link . ' ' . $friendly_time;

// build entity menu
$entity_menu = elgg_view_menu('entity', [
	'entity' => $answer,
	'handler' => 'answers',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
]);

$body = elgg_view('output/longtext', ['value' => $answer->description]);

// show comments?
if ($question->comments_enabled !== 'off') {
	$comment_count = $answer->countComments();
	if ($comment_count) {
		$comment_options = [
			'type' => 'object',
			'subtype' => 'comment',
			'container_guid' => $answer->getGUID(),
			'limit' => false,
			'list_class' => 'elgg-river-comments',
			'distinct' => false,
			'full_view' => true,
		];
		
		$body .= elgg_format_element('h3', ['class' => 'elgg-river-comments-tab mtm'], elgg_echo('comments'));
		$body .= elgg_list_entities($comment_options);
	}
	
	if ($answer->canComment()) {
		// show a comment form like in the river
		$body_vars = [
			'entity' => $answer,
			'inline' => true,
		];
		$form = elgg_view_form('comment/save', [], $body_vars);
		$body .= elgg_format_element('div', ['class' => ['elgg-river-item', 'hidden'], 'id' => "comments-add-{$answer->getGUID()}"], $form);
	}
}

// build content
$params = [
	'entity' => $answer,
	'title' => false,
	'metadata' => $entity_menu,
	'subtitle' => $subtitle,
	'content' => $body,
];

$summary = elgg_view('page/components/summary', $params);

echo elgg_view_image_block($image, $summary);
