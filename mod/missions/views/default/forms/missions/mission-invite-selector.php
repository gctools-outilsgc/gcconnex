<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Small form which allows managers to select which mission to invite a candidate to.
 */
$user_guid = $vars['candidate_guid'];

$invitable_missions = mm_get_invitable_missions($user_guid);

if(!empty($invitable_missions) && !is_array($invitable_missions)) {
	$invitable_missions = array($invitable_missions);
	$invitable_missions = mm_get_invitable_missions($user_guid);
}

foreach($invitable_missions as $guid => $mission) {
	break;
}

if(!empty($invitable_missions)) {
	$input_mission = elgg_view('input/dropdown', array(
			'name' => 'mission_guid',
			'value' => $guid,
			'options_values' => $invitable_missions,
			'id' => 'invitable-missions-dropdown-input-' . $user_guid
	));
	
	$hidden_user_guid = elgg_view('input/hidden', array(
			'name' => 'hidden_user_guid',
			'value' => $user_guid
	));
	
	$invite_button = elgg_view('input/submit', array(
			'value' => elgg_echo('missions:invite_to_apply'),
			'id' => 'invitable-missions-submission-button-' . $user_guid,
			'style' => 'width:100%;height:100%;'
	));
	
	$invite_button_restrictor = elgg_view('page/elements/one-click-restrictor', array('restricted_element_id' => 'invitable-missions-submission-button-' . $user_guid));
}
?>

<?php echo $hidden_user_guid; ?>
<div>
	<?php echo $input_mission; ?>
</div>
<div>
	<?php 
		echo $invite_button;
		echo $invite_button_restrictor;
	?>
</div>