<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */


// Nick - added additional opportunity types, removed the table, changed layout to match splash page opt in
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
	/*if($user->opt_in_missions == 'gcconnex_profile:opt:yes') {
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
	}*/
    
    
                $opt_in_set = array($user->opt_in_missions, $user->opt_in_swap, $user->opt_in_mentored, $user->opt_in_mentoring, $user->opt_in_shadowed, $user->opt_in_shadowing, $user->opt_in_jobshare, $user->opt_in_pcSeek, $user->opt_in_pcCreate, $user->opt_in_ssSeek, $user->opt_in_ssCreate, $user->opt_in_rotation, $user->opt_in_assignSeek, $user->opt_in_assignCreate, $user->opt_in_deploySeek, $user->opt_in_deployCreate, $user->opt_in_missionCreate);
    //Nick - Loop through array of selected things and change their value to match the meta data        
foreach($opt_in_set as $k => $v){
    if($v == 'gcconnex_profile:opt:yes'){
        $opt_in_set[$k]  = true;
    }else{
        $opt_in_set[$k]  = false;   
    }
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
	/*
	echo '<div class="gcconnex-profile-opt-in-options-table" style="margin: 10px;">';
	echo '<div class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:micro_mission' ) . '</div>';
	echo '<div>' . elgg_view ( "input/checkbox", array (
			'name' => 'mission_check',
			'checked' => $opt_in_set [0],
			'id' => 'gcconnex-opt-in-mission-check' 
	) ) . '</div>';
	
	echo '<div class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:job_swap' ) . '</div>';
	echo '<div>' . elgg_view ( "input/checkbox", array (
			'name' => 'swap_check',
			'checked' => $opt_in_set [1],
			'id' => 'gcconnex-opt-in-swap-check' 
	) ) . '</div>';
	
	echo '<div class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:mentored' ) . '</div>';
	echo '<div>' . elgg_view ( "input/checkbox", array (
			'name' => 'mentored_check',
			'checked' => $opt_in_set [2],
			'id' => 'gcconnex-opt-in-mentored-check' 
	) ) . '</div>';
	echo '<div class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:mentoring' ) . '</div>';
	echo '<div>' . elgg_view ( "input/checkbox", array (
			'name' => 'mentoring_check',
			'checked' => $opt_in_set [3],
			'id' => 'gcconnex-opt-in-mentoring-check' 
	) ) . '</div>';
	
	echo '<div class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:shadowed' ) . '</div>';
	echo '<div>' . elgg_view ( "input/checkbox", array (
			'name' => 'shadowed_check',
			'checked' => $opt_in_set [4],
			'id' => 'gcconnex-opt-in-shadowed-check' 
	) ) . '</div>';
	echo '<div class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:shadowing' ) . '</div>';
	echo '<div>' . elgg_view ( "input/checkbox", array (
			'name' => 'shadowing_check',
			'checked' => $opt_in_set [5],
			'id' => 'gcconnex-opt-in-shadowing-check' 
	) ) . '</div>';
	
	/*echo '<div class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:peer_coached' ) . '</div>';
	echo '<div>' . elgg_view ( "input/checkbox", array (
			'name' => 'peer_coached_check',
			'checked' => $opt_in_set [6],
			'id' => 'gcconnex-opt-in-peer-coached-check' 
	) ) . '</div>';
	echo '<div class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:peer_coaching' ) . '</div>';
	echo '<div>' . elgg_view ( "input/checkbox", array (
			'name' => 'peer_coaching_check',
			'checked' => $opt_in_set [7],
			'id' => 'gcconnex-opt-in-peer-coaching-check' 
	) ) . '</div>';
	echo '</tr><tr>';
	echo '<div class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:skill_sharing' ) . '</div>';
	echo '<div>' . elgg_view ( "input/checkbox", array (
			'name' => 'skill_sharing_check',
			'checked' => $opt_in_set [8],
			'id' => 'gcconnex-opt-in-skill-sharing-check'
	) ) . '</div>';
	echo '<div class="left-col">' . elgg_echo ( 'gcconnex_profile:opt:job_sharing' ) . '</div>';
	echo '<div>' . elgg_view ( "input/checkbox", array (
			'name' => 'job_sharing_check',
			'checked' => $opt_in_set [9],
			'id' => 'gcconnex-opt-in-job-sharing-check'
	) ) . '</div>';
	echo '</div>';*/
} else {
	echo 'An error has occurred.';
}

//Nick - modifying the edit form to account for additional opportunity types
?>

<div class="clearfix brdr-bttm mrgn-bttm-sm mm-optin-holder gcconnex-profile-opt-in-options-table">
    <div class="col-sm-6">
        <h4 class="mrgn-tp-0"><?php echo elgg_echo('gcconnex_profile:opt:atlevel'); ?></h4>
        <ul class="list-unstyled">
            <li class="clearfix">
                <?php echo elgg_echo('gcconnex_profile:opt:atlevel');?>
                
                <ul class="clearfix brdr-lft mrgn-lft-md list-unstyled">
                   <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'assignseek_check',
			         'checked' => $opt_in_set[12],
			         'id' => 'gcconnex-opt-in-assignseek-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:participants' ),
	               ));
                    
                ?>
                    </li> 
                    <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'assigncreate_check',
			         'checked' => $opt_in_set[13],
			         'id' => 'gcconnex-opt-in-assigncreate-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:host' ),
	               ));
                    
                ?>
                    </li> 
                </ul>
            </li>
            
            <li class="clearfix">
                <?php echo elgg_echo('gcconnex_profile:opt:development');?>
                
                <ul class="clearfix brdr-lft mrgn-lft-md list-unstyled">
                   <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'deploymentseek_check',
			         'checked' => $opt_in_set[14],
			         'id' => 'gcconnex-opt-in-deploymentseek-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:participants' ),
	               ));
                    
                ?>
                    </li> 
                    <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'deploymentcreate_check',
			         'checked' => $opt_in_set[15],
			         'id' => 'gcconnex-opt-in-deploymentcreate-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:host' ),
	               ));
                    
                ?>
                    </li> 
                </ul>
            </li>
            
            <li class="clearfix">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'swap_check',
			         'checked' => $opt_in_set[1],
			         'id' => 'gcconnex-opt-in-swap-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:job_swap' ),
	               ));
                    
                ?>
            </li>
            
            <li class="clearfix">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'rotation_check',
			         'checked' => $opt_in_set[11],
			         'id' => 'gcconnex-opt-in-rotation-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'missions:job_rotation' ),
	               ));
                    
                ?>
            </li>
            
            
        </ul>
    </div>

    <div class="col-sm-6">
        <h4 class="mrgn-tp-0"><?php echo elgg_echo('gcconnex_profile:opt:development'); ?></h4>
        <ul class="list-unstyled">
            <li class="clearfix">
                <?php echo elgg_echo ( 'missions:micro_mission' );?>
                <ul class="brdr-lft clearfix mrgn-lft-md list-unstyled">
                <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'mission_check',
			         'checked' => $opt_in_set[0],
			         'id' => 'gcconnex-opt-in-mission-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:participants' ),
	               ));
                    
                ?>
                </li>
                    <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'missioncreate_check',
			         'checked' => $opt_in_set[16],
			         'id' => 'gcconnex-opt-in-missioncreator-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:host' ),
	               ));
                    
                ?>
                </li>
                </ul>
            </li>
            
            <li class="clearfix">
                <?php echo elgg_echo('missions:mentoring');?>
                
                <ul class="clearfix brdr-lft mrgn-lft-md list-unstyled">
                <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'mentored_check',
			         'checked' => $opt_in_set[2],
			         'id' => 'gcconnex-opt-in-mentored-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:mentored' ),
	               ));
                    
                ?>
            </li>
            
            <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
                        'name' => 'mentoring_check',
			         'checked' => $opt_in_set[3],
			         'id' => 'gcconnex-opt-in-mentoring-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:mentoring' ),
	               ));
                    
                ?>
            </li>
                </ul>
            </li>
            
            <li class="clearfix">
                <?php echo elgg_echo ( 'missions:job_shadowing' ); ?>
                
                <ul class="clearfix brdr-lft mrgn-lft-md list-unstyled">
                <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'shadowing_check',
			         'checked' => $opt_in_set[5],
			         'id' => 'gcconnex-opt-in-shadowing-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:participants' ),
	               ));
                    
                ?>
                </li>
            
                <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'shadowed_check',
			         'checked' => $opt_in_set[4],
			         'id' => 'gcconnex-opt-in-shadowed-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:host' ),
	               ));
                    
                ?>
                </li>
                </ul>
            </li>
            
            
            <li class="clearfix">
                <?php echo elgg_echo( 'missions:skill_share' ); ?>
                
                <ul class="brdr-lft clearfix mrgn-lft-md list-unstyled">
                <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'skillseeker_check',
			         'checked' => $opt_in_set[9],
			         'id' => 'gcconnex-opt-in-skillseeker-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:participants' ),
	               ));
                    
                ?>
                </li>
            
            <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'skillcreator_check',
			         'checked' => $opt_in_set[10],
			         'id' => 'gcconnex-opt-in-skillcreator-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:host' ),
	               ));
                    
                ?>
            </li>
                </ul>
            </li>
            
            
            <li class="clearfix">
                <?php echo elgg_echo( 'missions:peer_coaching' ); ?>
                
                <ul class="clearfix brdr-lft mrgn-lft-md list-unstyled">
                    <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'coachseek_check',
			         'checked' => $opt_in_set[7],
			         'id' => 'gcconnex-opt-in-coachseek-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:participants' ),
	               ));
                    
                ?>
                    </li>
                    <li class="clearfix pull-left mrgn-lft-md">
                        <?php
                	       echo elgg_view ( "input/checkbox", array (
			             'name' => 'coachcreate_check',
			         'checked' => $opt_in_set[8],
			         'id' => 'gcconnex-opt-in-coachcreate-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:host' ),
	                   ));
                    
                        ?>
                    </li>
                </ul>
            </li>
            
            <li class="clearfix">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'jobshare_check',
			         'checked' => $opt_in_set[6],
			         'id' => 'gcconnex-opt-in-jobshare-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'missions:job_share' ),
	               ));
                    
                ?>
            </li>
            
        </ul>
    </div>
</div>
