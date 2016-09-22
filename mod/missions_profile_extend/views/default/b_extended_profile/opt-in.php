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
    	$user_guid = elgg_get_logged_in_user_guid();
	}
	
	// Gets the opt_in_set from the user's profile.
	$user = get_user($user_guid);
	
	// Division which will surround the table.
	echo '<a class="opt-in-anchor"></a>';
	echo '<div class="gcconnex-profile-opt-in-display" style="padding:20px 20px 10px 0px;">';
		
	if($user->canEdit() && false) {
		echo elgg_echo('gcconnex_profile:opt:set_empty');
	}
	else {
		echo '<div class="gcconnex-profile-opt-in-display-table" style="margin: 10px;">';
			echo '<ul class="col-sm-6 list-unstyled">';
                echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:micro_missionseek');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_missions) . '</span></li>';
                echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:micro_mission');
                echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_missionCreate) . '</span></li>';
                echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:assignment_deployment_seek');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_assignSeek) . '</span></li>';
				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:assignment_deployment_create');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_assignCreate) . '</span></li>';
                echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:deployment_seek');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_deploySeek) . '</span></li>';
				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:deployment_create');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_deployCreate) . '</span></li>';
        
				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:job_swap');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_swap) . '</span></li>';
			
                echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:job_rotate');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_rotation) . '</span></li>';
        
				
                
        echo '</ul>';
        echo '<ul class="col-sm-6 list-unstyled">';
                
				
                echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:mentored');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_mentored) . '</span></li>';
				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:mentoring');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_mentoring) . '</span></li>';
			
				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:shadowed');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_shadowed) . '</span></li>';
				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:shadowing');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_shadowing) . '</span></li>';
        
                echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:job_sharing');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_jobshare) . '</span></li>';
				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:peer_coached');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_pcSeek) . '</span></li>';
        
                echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:peer_coaching');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_pcCreate) . '</span></li>';
				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:skill_sharing');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_ssSeek) . '</span></li>';
        
                echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:skill_sharing_create');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_ssCreate) . '</span></li>';
				
                
                
        
                
                echo '</ul>';
			/*echo '</tr><tr>';
				echo '<div class="left-col">' . elgg_echo('gcconnex_profile:opt:peer_coached') . '</div>';
				echo '<div>' . elgg_echo($user->opt_in_peer_coached) . '</div>';
				echo '<div class="left-col">' . elgg_echo('gcconnex_profile:opt:peer_coaching') . '</div>';
				echo '<div>' . elgg_echo($user->opt_in_peer_coaching) . '</div>';
			echo '</tr><tr>';
				echo '<div class="left-col">' . elgg_echo('gcconnex_profile:opt:skill_sharing') . '</div>';
				echo '<div>' . elgg_echo($user->opt_in_skill_sharing) . '</div>';
				echo '<div class="left-col">' . elgg_echo('gcconnex_profile:opt:job_sharing') . '</div>';
				echo '<div>' . elgg_echo($user->opt_in_job_sharing) . '</div>';*/
			echo '</div>';
	}
	echo '</div>';
?>