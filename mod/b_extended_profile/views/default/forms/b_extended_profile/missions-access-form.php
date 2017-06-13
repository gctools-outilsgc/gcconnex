<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$access_options = get_write_access_array();
$user = get_user(elgg_get_page_owner_guid());

$default_access = $user->missions_hide_all_completed;
if($default_access === null) {
	$default_access = get_default_access();
}

/*$input_access = elgg_view('input/dropdown', array(
		'name' => 'completed_missions_access',
		'value' => $default_access,
		'options_values' => $access_options,
		'id' => 'missions-access-type-dropdown-input'
));*/
$params = array (
			'name' => "completed_missions_access",
			'value' => $default_access,
			'id' => 'missions-access-type-dropdown-input' 
	);
$input_access = elgg_view ( 'input/access', $params );
$hidden_user = elgg_view('input/hidden', array(
		'name' => 'hidden_user_guid',
		'value' => $user->guid
));
?>

<div class="form-group" style="margin-left:10px;">
	<div><?php echo $hidden_user; ?></div>
	<div class="col-sm-5"><?php echo $input_access; ?></div>
	<div class="col-sm-5">
		<?php 
			echo elgg_view('input/submit', array(
					'value' => elgg_echo('save'),
					'id' => 'mission-profile-extend-missions-access-form-submission-button'
			));
		?>
	</div>
</div>