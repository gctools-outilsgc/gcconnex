<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
$user_guid = $vars['candidate_guid'];

$input_mission = elgg_view('input/dropdown', array(
		'name' => 'mission_guid',
		'value' => $mission_guid,
		'options_values' => mm_get_invitable_missions($user_guid),
		'id' => 'invitable-missions-dropdown-input'
));

$hidden_user_guid = elgg_view('input/hidden', array(
		'name' => 'hidden_user_guid',
		'value' => $user_guid
));
?>

<?php echo $hidden_user_guid; ?>
<div>
	<?php echo $input_mission; ?>
</div>
<div>
	<?php 
		echo elgg_view('input/submit', array(
				'value' => elgg_echo('missions:invite_to_apply'),
				'id' => 'invitable-missions-submission-button',
				'style' => 'width:100%;'
		)); 
	?>
</div>