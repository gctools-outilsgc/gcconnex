<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Form which allows or disallows completed/cancelled missions to be displayed in My Opportunities.
 */
$check = false;
if(elgg_get_logged_in_user_entity()->show_closed_missions) {
	$checked = true;
}

$input_closed = elgg_view('input/checkbox', array(
		'name' => 'check_closed',
		'checked' => $checked,
		'id' => 'show-my-close-missions-checkbox-input'
));
?>

<div style="display:inline-block;">
	<div style="display:inline;">
		<?php echo $input_closed; ?>
	</div>
	<p style="display:inline;">
		<?php echo elgg_echo('missions:show_closed_missions'); ?>
	</p>
	
</div>

<div style="display:inline-block;margin-left:23px;"> 
	<?php
		echo elgg_view('input/submit', array(
				'value' => elgg_echo('missions:save'),
				'class' => 'elgg-button btn btn-primary',
				'id' => 'mission-refine-form-submission-button'
		));
		echo elgg_view('page/elements/one-click-restrictor', array('restricted_element_id' => 'mission-refine-form-submission-button'));
	?> 
</div>