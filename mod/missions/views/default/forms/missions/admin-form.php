<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Form which allows admins to target a mission by GUID and then perform an action on it.
 */
$input_mission_guid = elgg_view('input/text', array(
		'name' => 'mission_guid',
		'value' => '',
		'id' => 'admin-mission-guid-text-input'
));

$input_action_taken = elgg_view('input/dropdown', array(
		'name' => 'action_taken',
		'value' => '',
		'options' => array(
				elgg_echo('missions:complete'),
				elgg_echo('missions:cancel'),
				elgg_echo('missions:reopen'),
				elgg_echo('missions:delete')
		),
		'id' => 'admin-mission-action-taken-dropdown-input'
));
?>

<div class="form-group">
	<label for="admin-mission-guid-text-input"><?php echo elgg_echo('missions:mission_guid') . ':'; ?></label>
	<div style="display:inline-block;">
		<?php echo $input_mission_guid; ?> 
	</div>
</div>
<div class="form-group">
	<label for="admin-mission-action-taken-dropdown-input" style="display:inline-block;"><?php echo elgg_echo('missions:action_taken') . ': '; ?></label>
	<div style="display:inline-block;"><?php echo $input_action_taken; ?></div>
	<div style="display:inline-block;vertical-align:middle;">
		<?php 
			echo elgg_view('input/submit', array(
					'value' => elgg_echo('missions:act'),
					'id' => 'admin-mission-action-taken-form-submission-button',
					'confirm' => elgg_echo('missions:correct_action_and_guid')
			));
		echo elgg_view('page/elements/one-click-restrictor', array('restricted_element_id' => 'admin-mission-action-taken-form-submission-button'));
		?>
	</div>
</div>