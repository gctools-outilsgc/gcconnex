<?php
/**
 * Edit answer page
 *
 * @package ElggQuestions
 */

$answer_guid = get_input('guid');
elgg_entity_gatekeeper($answer_guid, 'object', ElggAnswer::SUBTYPE);

$answer = get_entity($answer_guid);
if (!$answer->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERRER);
}

$question = $answer->getContainerEntity();

$title = elgg_echo('questions:answer:edit');

elgg_push_breadcrumb($question->title, $question->getURL());
elgg_push_breadcrumb($title);

$content = elgg_view_form('object/answer/edit', [], ['entity' => $answer]);

$body = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'filter' => '',
]);

echo elgg_view_page($title, $body);
