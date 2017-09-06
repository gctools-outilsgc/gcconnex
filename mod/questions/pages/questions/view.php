<?php
/**
 * View a question
 *
 * @package ElggQuestions
 */

$guid = (int) get_input('guid');

elgg_entity_gatekeeper($guid, 'object', 'question');
$question = get_entity($guid);

// set page owner
elgg_set_page_owner_guid($question->getContainerGUID());
$page_owner = $question->getContainerEntity();

// set breadcrumb
$crumbs_title = $page_owner->name;

if ($page_owner instanceof ElggGroup) {
	elgg_push_breadcrumb($crumbs_title, "questions/group/{$page_owner->guid}");
} else {
	elgg_push_breadcrumb($crumbs_title, "questions/owner/{$page_owner->username}");
}

$title = $question->title;

elgg_push_breadcrumb($title);

// build page elements
$title_icon = '';

$content = elgg_view_entity($question,['full_view' => true]);

$answers = '';

// add the answer marked as the correct answer first
$marked_answer = $question->getMarkedAnswer();
if ($marked_answer) {
	$answers .= elgg_view_entity($marked_answer);
}

// add the rest of the answers
$options = [
	'type' => 'object',
	'subtype' => 'answer',
	'container_guid' => $question->getGUID(),
	'count' => true,
	'limit' => false,
];

if ($marked_answer) {
	// do not include the marked answer as it already  added to the output before
	$options['wheres'] = ["e.guid <> {$marked_answer->getGUID()}"];
}

if (elgg_is_active_plugin('likes')) {
	// order answers based on likes
	$dbprefix = elgg_get_config('dbprefix');
	$likes_id = elgg_get_metastring_id('likes');
	
	$options['selects'] = [
		"(SELECT count(a.name_id) AS likes_count
		FROM {$dbprefix}annotations a
		WHERE a.entity_guid = e.guid
		AND a.name_id = {$likes_id}) AS likes_count",
	];
	$options['order_by'] = 'likes_count desc, e.time_created asc';
}

$answers .= elgg_list_entities($options);

$count = elgg_get_entities($options);
if ($marked_answer) {
	$count++;
}

$content .= elgg_view_module('info', "{$count} " . elgg_echo('answers'), $answers, ['class' => 'mtm', 'id' => 'question-answers']);

// add answer form
if (($question->getStatus() === 'open') && $question->canWriteToContainer(0, 'object', 'answer')) {
	
	$add_form = elgg_view_form('object/answer/add', [], ['container_guid' => $question->getGUID()]);
	
	$content .= elgg_view_module('info', elgg_echo('answers:addyours'), $add_form);
} elseif ($question->getStatus() === 'closed') {
	// add an icon to show this question is closed
	$title_icon = elgg_view_icon('lock-closed');
}

$body = elgg_view_layout('content', [
	'title' => $title_icon . $title,
	'content' => $content,
	'filter' => '',
]);

echo elgg_view_page($title, $body);
