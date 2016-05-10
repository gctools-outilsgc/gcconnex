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
$applicant = $vars['applicant'];

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
		'value' => $vars['mission']->guid
));

$hidden_applicant_input = elgg_view('input/hidden', array(
		'name' => 'hidden_applicant_guid',
		'value' => $vars['applicant']
));
?>

<?php echo $hidden_mission_input; ?>
<?php echo $hidden_applicant_input; ?>
<div class="form-group">
	<h4 style="display:inline-block;"><label for="reason-to-decline-dropdown-input"><?php echo elgg_echo('missions:reason_to_decline') . ':'; ?></label></h4>
	<div style="display:inline-block;vertical-align:middle;">
		<?php echo $input_reason; ?> 
	</div>
</div>
<?php echo $input_other_reason; ?>
<div>
	<?php 
		echo elgg_view('input/submit', array(
				'value' => elgg_echo('missions:decline'),
				'id' => 'mission-reason-to-decline-form-submission-button'
		)); 
		echo elgg_view('page/elements/one-click-restrictor', array('restricted_element_id' => 'mission-reason-to-decline-form-submission-button'));
	?>
</div>