<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Form which allows users to send a pre-made declination message to the mission manager with an attached reason.
 */
$mission = $vars['mission'];
$applicant_guid = $vars['applicant'];

$button_text = '';
$label_text = '';
if(check_entity_relationship($mission->guid, 'mission_tentative', $applicant_guid)) {
	$button_text = elgg_echo('missions:decline');
	$label_text = 'missions:reason_to_decline_invite';
}
else if(check_entity_relationship($mission->guid, 'mission_offered', $applicant_guid)) {
	$button_text = elgg_echo('missions:decline');
	$label_text = 'missions:reason_to_decline_offer';
}
else if(check_entity_relationship($mission->guid, 'mission_applied', $applicant_guid)) {
	$button_text = elgg_echo('missions:withdraw');
	$label_text = 'missions:reason_to_withdraw_application';
}
else if(check_entity_relationship($mission->guid, 'mission_accepted', $applicant_guid)) {
	$button_text = elgg_echo('missions:withdraw');
	$label_text = 'missions:reason_to_withdraw_participation';
}

$reasons = mm_echo_explode_setting_string(elgg_get_plugin_setting('decline_reason_string', 'missions'));
$input_reason = elgg_view('input/dropdown', array(
		'name' => 'reason',
		'value' => '',
		'options_values' => $reasons,
		'id' => 'reason-to-decline-dropdown-input'
));

$input_other_reason = elgg_view('page/elements/other-text-input', array(
		'parent_id' => 'reason-to-decline-dropdown-input'
));

$hidden_mission_input = elgg_view('input/hidden', array(
		'name' => 'hidden_mission_guid',
		'value' => $mission->guid
));

$hidden_applicant_input = elgg_view('input/hidden', array(
		'name' => 'hidden_applicant_guid',
		'value' => $applicant_guid
));
?>

<?php echo $hidden_mission_input; ?>
<?php echo $hidden_applicant_input; ?>
<div class="form-group">
	<label for="reason-to-decline-dropdown-input">
		<?php echo elgg_echo($label_text, array(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions')))) . ':'; ?>
	</label>
	<div style="max-width:400px;">
		<?php echo $input_reason; ?> 
	</div>
</div>
<?php echo $input_other_reason; ?>
<div>
	<?php 
		echo elgg_view('input/submit', array(
				'value' => $button_text,
				'id' => 'mission-reason-to-decline-form-submission-button',
				'style' => 'margin-top:8px;'
		)); 
		echo elgg_view('page/elements/one-click-restrictor', array('restricted_element_id' => 'mission-reason-to-decline-form-submission-button'));
	?>
</div>