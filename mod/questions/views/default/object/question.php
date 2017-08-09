<?php
/**
 * Question entity view
 *
 * @package Questions
*/

$question = elgg_extract('entity', $vars, false);
if (!($question instanceof ElggQuestion)) {
	return true;
}

$full = (bool) elgg_extract('full_view', $vars, false);

$subtitle = [];

$poster = $question->getOwnerEntity();

$poster_icon = elgg_view_entity_icon($poster, 'tiny');
$poster_link = elgg_view('output/url', [
	'text' => $poster->name,
	'href' => $poster->getURL(),
	'is_trusted' => true
]);
$subtitle[] = elgg_echo('questions:asked', [$poster_link]);

$container = $question->getContainerEntity();
if (($container instanceof ElggGroup) && (elgg_get_page_owner_guid() !== $container->getGUID())) {
	$group_link = elgg_view('output/url', [
		'text' => $container->name,
		'href' => "questions/group/{$container->getGUID()}/all",
		'is_trusted' => true
	]);
	$subtitle[] = elgg_echo('river:ingroup', [$group_link]);
}

$subtitle[] = elgg_view_friendly_time($question->time_created);

$answer_options = [
	'type' => 'object',
	'subtype' => 'answer',
	'container_guid' => $question->getGUID(),
	'count' => true,
];

$num_answers = elgg_get_entities($answer_options);
$answer_text = '';

if ($num_answers != 0) {
	$subtitle[] = elgg_view('output/url', [
		'href' => "{$question->getURL()}#question-answers",
		'text' => elgg_echo('answers') . " ({$num_answers})",
	]);
}

$metadata = '';
// do not show the metadata and controls in widget view
if (!elgg_in_context('widgets')) {
	$metadata = elgg_view_menu('entity', [
		'entity' => $question,
		'handler' => 'questions',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz list-inline',
		'full_view' => $full,
	]);
}

$solution_time = (int) $question->solution_time;
if ($solution_time && !$question->getMarkedAnswer()) {
	$solution_class = [
		'question-solution-time',
		'float-alt'
	];
	if ($solution_time < time()) {
		$solution_class[] = ' question-solution-time-late';
	} elseif ($solution_time < (time() + (24 * 60 * 60))) {
		$solution_class[] = ' question-solution-time-due';
	}
	
	$solution_date = elgg_view('output/date', ['value' => $question->solution_time]);
	$answer_text .= elgg_format_element('span', ['class' => $solution_class], $solution_date);
}

if ($full) {
	
	$params = [
		'entity' => $question,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => implode(' ', $subtitle),
	];
	$list_body = elgg_view('object/elements/summary', $params);
	
	$list_body .= elgg_view('output/longtext', ['value' => $question->description]);
	
	// show comments?
	if ($question->comments_enabled !== 'off') {
		$comment_count = $question->countComments();
		if ($comment_count) {
			$comment_options = [
				'type' => 'object',
				'subtype' => 'comment',
				'container_guid' => $question->getGUID(),
				'limit' => false,
				'list_class' => 'elgg-river-comments',
				'distinct' => false,
				'full_view' => true,
			];
			
			$list_body .= elgg_format_element('h3', [
					'class' => ['elgg-river-comments-tab', 'mtm']
				], elgg_echo('comments')
			);
			$list_body .= elgg_list_entities($comment_options);
		}
		
		if ($question->canComment()) {
			// show a comment form like in the river
			$body_vars = [
				'entity' => $question,
				'inline' => true,
			];
			
			$form = elgg_view_form('comment/save', [], $body_vars);
			$list_body .= elgg_format_element('div', [
					'class' => ['elgg-river-item', 'hidden'],
					'id' => "comments-add-{$question->getGUID()}"
				], $form
			);
		}
	}
	
	echo elgg_view_image_block($poster_icon, $list_body);

} else {
	// brief view
	$title_text = '';
	if ($question->getMarkedAnswer()) {
		$title_text = elgg_view_icon('checkmark', ['class' => 'mrs question-listing-checkmark']);
	}
	$title_text .= elgg_get_excerpt($question->getDisplayName(), 100);
	$title = elgg_view('output/url', [
		'text' => $title_text,
		'href' => $question->getURL(),
		'is_trusted' => true,
	]);
	
	$excerpt = '';
	if (!empty($question->description)) {
		$excerpt = elgg_format_element('div', ['class' => 'mbm'], elgg_get_excerpt($question->description));
	}
	
	if (!empty($answer_text)) {
		$answer_text = elgg_format_element('div', ['class' => 'elgg-subtext'], $answer_text);
	}
	
	$params = [
		'entity' => $question,
		'title' => $title,
		'metadata' => $metadata,
		'subtitle' => implode(' ', $subtitle),
		'content' => $excerpt . $answer_text,
	];
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($poster_icon, $list_body);
}
