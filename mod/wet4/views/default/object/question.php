<?php
/**
 * Question entity view
 *
 * @package Questions
*/
$lang = get_current_language();
$question = elgg_extract('entity', $vars, false);
if (!($question instanceof ElggQuestion)) {
	return true;
}

$full = (bool) elgg_extract('full_view', $vars, false);

$subtitle = [];

$poster = $question->getOwnerEntity();

$poster_icon = elgg_view_entity_icon($poster, 'medium');
$poster_link = elgg_view('output/url', [
	'text' => $poster->name,
	'href' => $poster->getURL(),
	'is_trusted' => true
]);
$subtitle[] = elgg_echo('questions:asked', [$poster_link]);

$container = $question->getContainerEntity();
if (($container instanceof ElggGroup) && (elgg_get_page_owner_guid() !== $container->getGUID())) {
	$group_link = elgg_view('output/url', [
		'text' => gc_explode_translation($container->name,$lang),
		'href' => "questions/group/{$container->getGUID()}/all",
		'is_trusted' => true
	]);
	$subtitle[] = elgg_echo('river:ingroup', [$group_link]);
}

$tags = elgg_view('output/tags', ['tags' => $question->tags]);

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
	$answer_options['limit'] = 1;
	$answer_options['count'] = false;

	$correct_answer = $question->getMarkedAnswer();

	if ($correct_answer) {
		$poster = $correct_answer->getOwnerEntity();
		$answer_time = elgg_view_friendly_time($correct_answer->time_created);
		$answer_link = elgg_view('output/url', ['href' => $poster->getURL(), 'text' => $poster->name]);
		$answer_text = elgg_echo('questions:answered:correct', [$answer_link, $answer_time]);
	} else {
		$last_answer = elgg_get_entities($answer_options);

		$poster = $last_answer[0]->getOwnerEntity();
		$answer_time = elgg_view_friendly_time($last_answer[0]->time_created);
		$answer_link = elgg_view('output/url', ['href' => $poster->getURL(), 'text' => $poster->name]);
		$answer_text = elgg_echo('questions:answered', [$answer_link, $answer_time]);
	}

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

$subtitle[] = elgg_view('output/categories', $vars);

if ($full) {

	$params = [
		'entity' => $question,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => implode(' ', $subtitle),
		'tags' => $tags,
	];
	$list_body = elgg_view('object/elements/summary', $params);

	//Add translation
	//$question->description = gc_explode_translation($question->description, get_current_language());
	
	$body .= elgg_view('output/longtext', ['value' => gc_explode_translation($question->description, get_current_language()), 'class' => 'question_details']);

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
				"order_by" => "time_created"
			];

			if(elgg_instanceof(elgg_get_page_owner_entity(), "group")){
				$header = 'h3';
			} else {
				$header = 'h2';
			}
			$comments_body = elgg_format_element($header, [
					'class' => ['elgg-river-comments-tab', 'mtm']
				], elgg_echo('comments')
			);
			$comments_body .= elgg_list_entities($comment_options);
		}

		if ($question->canComment()) {
			// show a comment form like in the river
			$body_vars = [
				'entity' => $question,
				'inline' => true,
			];

			$form = elgg_view_form('comment/save', [], $body_vars);
			$comments_body .= elgg_format_element('div', [
					'class' => ['elgg-river-item'],
					'id' => "comments-add-{$question->getGUID()}",
					"style" => "display:none;"
				], $form
			);

			$comments = elgg_format_element('div', ['class' => 'mrgn-lft-md'], $comments_body);
		}
	}

	// identify available content
	$description_json = json_decode($question->description);
	$title_json = json_decode($question->title);

if( $description_json->en && $description_json->fr ){
	echo'<div id="change_language" class="change_language">';
	if (get_current_language() == 'fr'){

		?>	
		<span id="indicator_language_en" onclick="change_en('.question_details', '.title');"><span id="fr_title" class="testClass hidden" ><?php echo $title_json->fr;?></span><span id="en_title" class="testClass hidden" ><?php echo $title_json->en;?></span><span id="en_content" class="testClass hidden" ><?php echo $description_json->en;?></span><span id="fr_content" class="testClass hidden" ><?php echo $description_json->fr;?></span><?php echo elgg_echo('box:indicator:en') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:en') ?></span></span>
	
		<?php
	}else{
		?>		
		<span id="indicator_language_fr" onclick="change_fr('.question_details','.title');"><span id="fr_title" class="testClass hidden" ><?php echo $title_json->fr;?></span><span id="en_title" class="testClass hidden" ><?php echo $title_json->en;?></span><span id="en_content" class="testClass hidden" ><?php echo $description_json->en;?></span><span id="fr_content" class="testClass hidden" ><?php echo $description_json->fr;?></span><?php echo elgg_echo('box:indicator:fr') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:fr') ?></span></span>
	
		<?php	
	}
	echo'</div>';
}


	echo elgg_view_image_block($poster_icon, $list_body);
	echo elgg_format_element('div', ['class' => ['mrgn-tp-md']], $body.$comments);

} else {

		$question->title = gc_explode_translation($question->title, get_current_language());


	// brief view
	$title_text = '';
	$title_text .= elgg_get_excerpt($question->title, 100);
	$title = elgg_view('output/url', [
		'text' => $title_text,
		'href' => $question->getURL(),
		'is_trusted' => true,
	]);

	if ($question->getMarkedAnswer()) {

		//place checkmark telling user an answer has been marked correct
		$answer = $question->getMarkedAnswer()->getCorrectAnswerMetadata();
		$timestamp = htmlspecialchars(date(elgg_echo('friendlytime:date_format'), $answer->time_created));
		$correcttitle = elgg_echo('questions:answer:checkmark:brief', [$question->getOwnerEntity()->name, $poster->name, $timestamp]);

		$poster_icon .= elgg_format_element('div', ['class' => 'fa fa-check fa-3x questions-correct', 'title' => $correcttitle]);

		//add answered identifier to title of question
		$title .= elgg_echo('question:answered');
	}


	$excerpt = '';

		$question->description = gc_explode_translation($question->description, get_current_language());

		$excerpt = elgg_format_element('div', ['class' => 'mbm'], elgg_get_excerpt($question->description));
	

	if (!empty($answer_text)) {
		$answer_text = elgg_format_element('div', ['class' => 'elgg-subtext'], $answer_text);
	}

	$params = [
		'entity' => $question,
		'title' => $title,
		'metadata' => $metadata,
		'subtitle' => implode(' ', $subtitle) . $answer_text,
		'tags' => $tags,
		'content' => $excerpt,
	];
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($poster_icon, $list_body);
}
