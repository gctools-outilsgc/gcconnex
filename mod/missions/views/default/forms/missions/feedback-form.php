<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Form which allows the user to generate feedback for the mission via plaintext input.
 */
$mission = $vars['entity'];
$feedback_target = $vars['feedback_target'];

$feedback_search = elgg_get_entities_from_metadata(array(
		'type' => 'object',
		'subtype' => 'mission-feedback',
		'owner_guid' => elgg_get_logged_in_user_guid(),
		'metadata_name_value_pairs' => array(
				array('name' => 'recipient', 'value' => $feedback_target->guid),
				array('name' => 'mission', 'value' => $mission->guid)
		)
));
$feedback = $feedback_search[0];

$feedback_body = $feedback->message;
$checked = false;
if($feedback->endorsement == 'on') {
	$checked = true;
}

// User icon.
$feedback_pic = elgg_view_entity_icon($feedback_target, 'tiny');
	
// User name linked to the user's profile.
$feedback_head = elgg_view('output/url', array(
		'href' => $feedback_target->getURL(),
		'text' => $feedback_target->name
));
	
if (elgg_is_sticky_form('applicationfill')) {
    extract(elgg_get_sticky_values('feedbackfill'));
    elgg_clear_sticky_form('feedbackfill');
}
	
// If a message has been sent then a second message cannot be sent.
$feedback_body .=  elgg_view('input/plaintext', array(
	    'name' => 'feedback_body',
	    'value' => $feedback_body,
	    'id' => 'mission-feedback-body-text-input'
));
	
$input_feedback_rating = elgg_view('input/checkbox', array(
		'name' => 'feedback_rating',
		'checked' => $checked,
		'id' => 'mission-feedback-rating-checkbox-input'
));;

echo elgg_view('input/hidden', array(
		'name' => 'hidden_target_guid',
		'value' => $feedback_target->guid
));

echo elgg_view('input/hidden', array(
		'name' => 'hidden_mission_guid',
		'value' => $mission->guid
));

echo elgg_view('input/hidden', array(
		'name' => 'hidden_feedback_guid',
		'value' => $feedback->guid
));
?>

<div class="form-group">
	<label for="mission-feedback-body-text-input" style="font-size:x-large;">
		<?php echo elgg_echo('missions:feedback_for') . $feedback_head; ?>
	</label>
	<span style="margin-left:8px;">
		<?php echo $feedback_pic; ?>
	</span>
	<?php echo $feedback_body; ?>
</div>
<div class="form-group">
	<div style="display:inline-block;">
		<?php echo $input_feedback_rating; ?>
	</div>
	<div style="display:inline-block;">
		<label for='mission-feedback-rating-checkbox-input'><?php echo elgg_echo('missions:endorse_person', array($feedback_target->name)); ?> </label>
	</div>
</div>
<div>
 	<?php 
		echo elgg_view('input/submit', array(
				'value' => elgg_echo('missions:submit'),
				'class' => 'elgg-button btn btn-primary',
				'style' => 'float:right;'
		)); 
	?> 
</div>