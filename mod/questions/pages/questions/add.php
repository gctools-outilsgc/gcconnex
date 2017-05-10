<?php
/**
 * Add question page
 *
 * @package ElggQuestions
 */

$title = elgg_echo('questions:add');

elgg_push_breadcrumb($title);

$form_vars = [];
if (questions_limited_to_groups()) {
	$form_vars['class'] = 'questions-validate-container';
}
$content = elgg_view_form('object/question/save', $form_vars);

$body = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'filter' => '',
]);

echo elgg_view_page($title, $body);
