<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This view displays a form which allows the user to edit their opt-in choices.
 * This view is inside a section wrapper as described in wrapper.php.
 */
if (elgg_is_xhr) {
	echo elgg_echo ( 'gcconnex_profile:opt:opt_in_access' );
	
	$user_guid = elgg_get_logged_in_user_guid();
	$user = get_user ( $user_guid );
	
	$access_id = $user->optaccess;
	$params = array (
			'name' => "accesslevel['optaccess']",
			'value' => $access_id,
			'class' => 'gcconnex-opt-in-access' 
	);
	echo elgg_view ( 'input/access', $params );
	
	// Decides whether or not the checkbox should start checked.
	$opt_in_set = array();
	if($user->opt_in_missions == 'gcconnex_profile:opt:yes') {
	    $opt_in_set[0] = true;
	}
	if($user->opt_in_swap == 'gcconnex_profile:opt:yes') {
	    $opt_in_set[1] = true;
	}
	if($user->opt_in_mentored == 'gcconnex_profile:opt:yes') {
	    $opt_in_set[2] = true;
	}
	if($user->opt_in_mentoring == 'gcconnex_profile:opt:yes') {
	    $opt_in_set[3] = true;
	}
	if($user->opt_in_shadowed == 'gcconnex_profile:opt:yes') {
	    $opt_in_set[4] = true;
	}
	if($user->opt_in_shadowing == 'gcconnex_profile:opt:yes') {
	    $opt_in_set[5] = true;
	}
	/*if($user->opt_in_peer_coached == 'gcconnex_profile:opt:yes') {
	    $opt_in_set[6] = true;
	}
	if($user->opt_in_peer_coaching == 'gcconnex_profile:opt:yes') {
	    $opt_in_set[7] = true;
	}
	if($user->opt_in_skill_sharing == 'gcconnex_profile:opt:yes') {
		$opt_in_set[8] = true;
	}
	if($user->opt_in_job_sharing == 'gcconnex_profile:opt:yes') {
		$opt_in_set[9] = true;
	}*/
	
	echo '<table class="gcconnex-profile-opt-in-options-table table table-bordered" style="margin: 10px;">';
	echo '<tbody><tr>';
	echo '<td class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:micro_mission' ) . '</td>';
	echo '<td>' . elgg_view ( "input/checkbox", array (
			'name' => 'mission_check',
			'checked' => $opt_in_set [0],
			'id' => 'gcconnex-opt-in-mission-check' 
	) ) . '</td>';
	echo '</tr><tr>';
	echo '<td class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:job_swap' ) . '</td>';
	echo '<td>' . elgg_view ( "input/checkbox", array (
			'name' => 'swap_check',
			'checked' => $opt_in_set [1],
			'id' => 'gcconnex-opt-in-swap-check' 
	) ) . '</td>';
	echo '</tr><tr>';
	echo '<td class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:mentored' ) . '</td>';
	echo '<td>' . elgg_view ( "input/checkbox", array (
			'name' => 'mentored_check',
			'checked' => $opt_in_set [2],
			'id' => 'gcconnex-opt-in-mentored-check' 
	) ) . '</td>';
	echo '<td class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:mentoring' ) . '</td>';
	echo '<td>' . elgg_view ( "input/checkbox", array (
			'name' => 'mentoring_check',
			'checked' => $opt_in_set [3],
			'id' => 'gcconnex-opt-in-mentoring-check' 
	) ) . '</td>';
	echo '</tr><tr>';
	echo '<td class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:shadowed' ) . '</td>';
	echo '<td>' . elgg_view ( "input/checkbox", array (
			'name' => 'shadowed_check',
			'checked' => $opt_in_set [4],
			'id' => 'gcconnex-opt-in-shadowed-check' 
	) ) . '</td>';
	echo '<td class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:shadowing' ) . '</td>';
	echo '<td>' . elgg_view ( "input/checkbox", array (
			'name' => 'shadowing_check',
			'checked' => $opt_in_set [5],
			'id' => 'gcconnex-opt-in-shadowing-check' 
	) ) . '</td>';
	echo '</tr><tr>';
	/*echo '<td class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:peer_coached' ) . '</td>';
	echo '<td>' . elgg_view ( "input/checkbox", array (
			'name' => 'peer_coached_check',
			'checked' => $opt_in_set [6],
			'id' => 'gcconnex-opt-in-peer-coached-check' 
	) ) . '</td>';
	echo '<td class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:peer_coaching' ) . '</td>';
	echo '<td>' . elgg_view ( "input/checkbox", array (
			'name' => 'peer_coaching_check',
			'checked' => $opt_in_set [7],
			'id' => 'gcconnex-opt-in-peer-coaching-check' 
	) ) . '</td>';
	echo '</tr><tr>';
	echo '<td class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:skill_sharing' ) . '</td>';
	echo '<td>' . elgg_view ( "input/checkbox", array (
			'name' => 'skill_sharing_check',
			'checked' => $opt_in_set [8],
			'id' => 'gcconnex-opt-in-skill-sharing-check'
	) ) . '</td>';
	echo '<td class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:job_sharing' ) . '</td>';
	echo '<td>' . elgg_view ( "input/checkbox", array (
			'name' => 'job_sharing_check',
			'checked' => $opt_in_set [9],
			'id' => 'gcconnex-opt-in-job-sharing-check'
	) ) . '</td>';*/
	echo '</tr></tbody></table>';
} else {
	echo 'An error has occurred.';
}
?>