<?php
if (isset($vars['entity']))
{
	$poll = $vars['entity'];
	//set up our variables
	$question = $poll->question;
	$tags = $poll->tags;
	$access_id = $poll->access_id;
}
else
{
	register_error(elgg_echo("polls:blank"));
	forward('polls/all');
}
$lang = get_current_language();
//convert $responses to radio inputs for form display
$responses = polls_get_choice_array($poll);
 
$response_inputs = elgg_view('input/radio', array('name' => 'response', 'class' => 'mrgn-rght-sm', 'options' => $responses));

$responses2 = polls_get_choice_array2($poll);
 
$response_inputs2 = elgg_view('input/radio', array('name' => 'response2', 'class' => 'mrgn-rght-sm', 'options' => $responses2));

$responses3 = polls_get_choice_array3($poll);
 
$response_inputs3 = elgg_view('input/radio', array('name' => 'response3', 'class' => 'mrgn-rght-sm', 'options' => $responses3));

foreach ($responses3 as $value) {

	$responses4 = gc_explode_translation($value, $lang);

$form_body .='  <input type="radio"  class = "mrgn-rght-sm" id="responses-'.$responses4.'" name="response3" value="'.$value.'"> <label for="responses-'.$responses4.'">'.$responses4.'</label><br>';
}


if (empty($responses3)) {
	 $response_inputs4 = elgg_view('input/radio', array('name' => 'response3', 'class' => 'mrgn-rght-sm', 'options' => $responses));
}



$submit_input = '<br />'.elgg_view('input/submit', array('rel'=>$poll->guid,'class'=>'poll-vote-button btn-primary','name' => 'submit_vote', 'value' => elgg_echo('polls:vote')));

if (isset($vars['entity'])) {
	$entity_hidden = elgg_view('input/hidden', array('name' => 'guid', 'value' => $poll->guid));
	$entity_hidden .= elgg_view('input/hidden', array('name' => 'callback', 'value' => $vars['callback']));
} else {
	$entity_hidden = '';
}

	$form_body .=  "<p>" . $response_inputs4 . "</p>";


$form_body .= "<p>" . $submit_input . $entity_hidden . "</p>";
if ($vars['form_display']) {
	echo '<div id="poll-vote-form-container-'.$poll->guid.'" style="display:'.$vars['form_display'].'">';
} else {
	echo  '<div class="poll-vote-form-container-'.$poll->guid.'">';
}

echo $form_body;

echo '</div>';
