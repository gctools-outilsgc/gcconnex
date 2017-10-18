<?php
//This action lets users opt in from the splash page
$user = elgg_get_logged_in_user_entity();
$opt_in_mission = get_input('mission_check');
$opt_in_swap = get_input('swap_check');
$opt_in_mentored = get_input('mentored_check');
$opt_in_shadowed = get_input('shadowed_check');
$opt_in_mentoring = get_input('mentoring_check');
$opt_in_shadowing = get_input('shadowing_check');
$opt_in_jobshare = get_input('jobshare_check');
$opt_in_pcSeek = get_input('coachseek_check');
$opt_in_pcCreate = get_input('coachcreate_check');
$opt_in_ssSeek = get_input('skillseeker_check');
$opt_in_ssCreate = get_input('skillcreator_check');
$opt_in_rotation= get_input('rotation_check');
$opt_in_assignSeek = get_input('assignseek_check');
$opt_in_assignCreate = get_input('assigncreate_check');
$opt_in_deploySeek = get_input('deploymentseek_check');
$opt_in_deployCreate = get_input('deploymentcreate_check');
$opt_in_missionCreate = get_input('missioncreate_check');
$access = get_input('access');

$opt_in_inputs = array($opt_in_mission, $opt_in_swap, $opt_in_mentored, $opt_in_shadowed, $opt_in_mentoring, $opt_in_shadowing, $opt_in_jobshare, $opt_in_pcSeek, $opt_in_pcCreate, $opt_in_ssSeek, $opt_in_ssCreate, $opt_in_rotation, $opt_in_assignSeek, $opt_in_assignCreate, $opt_in_deploySeek, $opt_in_deployCreate, $opt_in_missionCreate);
//Nick - Loop through array of selected things and change their value to match the meta data
foreach ($opt_in_inputs as $k => $v) {
	if ($v == 'on') {
		$opt_in_inputs[$k]  = 'gcconnex_profile:opt:yes';
	} else {
		$opt_in_inputs[$k]  = 'gcconnex_profile:opt:no';
	}
}

$user->opt_in_missions = $opt_in_inputs[0];
$user->opt_in_swap = $opt_in_inputs[1];
$user->opt_in_mentored = $opt_in_inputs[2];
$user->opt_in_mentoring = $opt_in_inputs[3];
$user->opt_in_shadowed = $opt_in_inputs[4];
$user->opt_in_shadowing = $opt_in_inputs[5];
$user->opt_in_jobshare = $opt_in_inputs[6];
$user->opt_in_pcSeek = $opt_in_inputs[7];
$user->opt_in_pcCreate = $opt_in_inputs[8];
$user->opt_in_ssSeek = $opt_in_inputs[9];
$user->opt_in_ssCreate = $opt_in_inputs[10];
$user->opt_in_rotation = $opt_in_inputs[11];
$user->opt_in_assignSeek = $opt_in_inputs[12];
$user->opt_in_assignCreate = $opt_in_inputs[13];
$user->opt_in_deploySeek = $opt_in_inputs[14];
$user->opt_in_deployCreate = $opt_in_inputs[15];
$user->opt_in_missionCreate = $opt_in_inputs[16];

system_message(elgg_echo('missions:optin:success'));
