<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 *
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */

	/*
	 * The view which display the opt-in choices that the user has saved.
	 * If no choices have been made it will display a message.
	 * This view is inside a section wrapper as described in wrapper.php.
	 */

	if (elgg_is_xhr()) {
    	$user_guid = $_GET["guid"];
	}
	else {
    	$user_guid = elgg_get_page_owner_guid();
	}
	
	// Gets the opt_in_set from the user's profile.
	$user = get_user($user_guid);
	
	// Division which will surround the table.
	echo '<a name="opt-in-anchor"></a>';
	echo '<div class="gcconnex-profile-opt-in-display" style="padding:20px 20px 10px 0px;">';
		
	if($user->canEdit() && false) {
		echo elgg_echo('gcconnex_profile:opt:set_empty');
	}
	else {
		echo '<table class="gcconnex-profile-opt-in-display-table table table-bordered" style="margin: 10px;">';
			echo '<tbody><tr>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:micro_mission') . '</td>';
				echo '<td>' . elgg_echo($user->opt_in_missions) . '</td>';
			echo '</tr><tr>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:job_swap') . '</td>';
				echo '<td>' . elgg_echo($user->opt_in_swap) . '</td>';
			echo '</tr><tr>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:mentored') . '</td>';
				echo '<td>' . elgg_echo($user->opt_in_mentored) . '</td>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:mentoring') . '</td>';
				echo '<td>' . elgg_echo($user->opt_in_mentoring) . '</td>';
			echo '</tr><tr>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:shadowed') . '</td>';
				echo '<td>' . elgg_echo($user->opt_in_shadowed) . '</td>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:shadowing') . '</td>';
				echo '<td>' . elgg_echo($user->opt_in_shadowing) . '</td>';
			echo '</tr><tr>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:peer_coached') . '</td>';
				echo '<td>' . elgg_echo($user->opt_in_peer_coached) . '</td>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:peer_coaching') . '</td>';
				echo '<td>' . elgg_echo($user->opt_in_peer_coaching) . '</td>';
			echo '</tr><tr>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:skill_sharing') . '</td>';
				echo '<td>' . elgg_echo($user->opt_in_skill_sharing) . '</td>';
				echo '<td class="left-col">' . elgg_echo('gcconnex_profile:opt:job_sharing') . '</td>';
				echo '<td>' . elgg_echo($user->opt_in_job_sharing) . '</td>';
			echo '</tr></tbody></table>';
	}
	echo '</div>';
?>