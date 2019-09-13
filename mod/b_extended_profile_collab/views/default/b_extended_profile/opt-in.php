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
        echo '<div class="col-sm-6 "><h3 class="h4 mrgn-tp-0">'. elgg_echo('gcconnex_profile:opt:career').'</h3>';
		echo '<ul class="list-unstyled">';
				echo '<li class="left-col casual-tooltip" title="' . elgg_echo('gcconnex_profile:opt:casual_tooltip') . '">' . elgg_echo('gcconnex_profile:opt:casual_seek');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_casual_seek) . '</span></li>';
				echo '<li class="left-col casual-tooltip" title="' . elgg_echo('gcconnex_profile:opt:casual_tooltip') . '">' . elgg_echo('gcconnex_profile:opt:casual_create');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_casual_create) . '</span></li>';

				echo '<li class="left-col student-tooltip" title="' . elgg_echo('gcconnex_profile:opt:student_tooltip') . '">' . elgg_echo('gcconnex_profile:opt:student_seek');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_student_seek) . '</span></li>';
				echo '<li class="left-col student-tooltip" title="' . elgg_echo('gcconnex_profile:opt:student_tooltip') . '">' . elgg_echo('gcconnex_profile:opt:student_create');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_student_create) . '</span></li>';

				echo '<script>$(document).ready(function() { $(".casual-tooltip").tooltip(); $(".student-tooltip").tooltip(); });</script>';

				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:interchange_seek');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_interchange_seek) . '</span></li>';
				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:interchange_create');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_interchange_create) . '</span></li>';
        echo '</ul></div>';
        
        echo '<div class="col-sm-6 "><h3 class="h4 mrgn-tp-0">'. elgg_echo('gcconnex_profile:opt:development').'</h3>';
        echo '<ul class="list-unstyled">';
                
				
                echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:mentored');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_mentored) . '</span></li>';
				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:mentoring');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_mentoring) . '</span></li>';

				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:collaboration_seek');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_collaboration_seek) . '</span></li>';
				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:collaboration_create');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_collaboration_create) . '</span></li>';

				echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:skill_sharing');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_ssSeek) . '</span></li>';
                echo '<li class="left-col">' . elgg_echo('gcconnex_profile:opt:skill_sharing_create');
				echo '<span class="mrgn-lft-md">' . elgg_echo($user->opt_in_ssCreate) . '</span></li>';
                echo '</ul></div>';
			echo '</div>';
	}
	echo '</div>';
?>