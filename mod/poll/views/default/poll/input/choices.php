<?php

// TODO: add ability to reorder poll questions?
$poll = elgg_extract('poll', $vars);

elgg_require_js('elgg/poll/edit');

$body = '<div id="old-choices-area">';
$i = 0;

if ($poll) {
	$choices = $poll->getChoices();

	foreach ($choices as $choice) {
		$text_input = elgg_view('input/text', array(
			'name' => "choice_text_{$i}",
			'value' => $choice->text,
			'class' => 'poll_input-poll-choice'
		));

		$delete_icon = elgg_view_icon('pollchoicedelete');

		$delete_link = elgg_view('output/url', array(
			'href' => '#',
			'text' => $delete_icon,
			'title' => elgg_echo('poll:delete_choice'),
			'class' => 'delete-choice',
			'data-id' => $i,
		));

		$body .= "<div id=\"choice-container-{$i}\">{$text_input}{$delete_link}</div>";

		$i++;
	}
}

$body .="</div>";

$body .= '<div id="new-choices-area"></div>';

$body .= elgg_view('input/button', array(
	'id' => 'add-choice',
	'value' => elgg_echo('poll:add_choice'),
	'class' => 'elgg-button elgg-button-action',
));

$body .= elgg_view('input/hidden', array(
	'name' => 'number_of_choices',
	'id' => 'number-of-choices',
	'value' => $i,
));
$body .= elgg_view('input/hidden', array(
	'name' => 'max_choice_id',
	'id' => 'max-choice-id',
	'value' => $i,
));

echo $body;
