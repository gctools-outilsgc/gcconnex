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
	
	$user_guid = elgg_get_logged_in_user_guid();
	$user = get_user ( $user_guid );
	
	$access_id = $user->optaccess;
	$params = array (
			'name' => "accesslevel['optaccess']",
			'value' => '-2',
			'class' => 'gcconnex-opt-in-access' 
	);
	//echo elgg_view ( 'input/access', $params );
    echo elgg_view('input/hidden', $params);
	
	// Decides whether or not the checkbox should start checked.
	
	

} else {
	echo 'An error has occurred.';
}
?>
<div class="clearfix brdr-bttm mrgn-bttm-sm mm-optin-holder">
    <div class="col-sm-4 col-sm-offset-2">
        <h4 class="mrgn-tp-0"><?php echo elgg_echo('gcconnex_profile:opt:atlevel'); ?></h4>
        <ul class="list-unstyled">
            <li class="clearfix">
                <?php echo elgg_echo ( 'missions:micro_mission' );?>
                <ul class="brdr-lft clearfix mrgn-lft-md list-unstyled">
                <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'mission_check',
			         'checked' => true,
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
			         'checked' => true,
			         'id' => 'gcconnex-opt-in-mentoringcreater-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:host' ),
	               ));
                    
                ?>
                </li>
                </ul>
            </li>
            
            <li class="clearfix">
                <?php echo elgg_echo('missions:assignment');?>
                
                <ul class="clearfix brdr-lft mrgn-lft-md list-unstyled">
                   <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'assignseek_check',
			         'checked' => true,
			         'id' => 'gcconnex-opt-in-swap-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:participants' ),
	               ));
                    
                ?>
                    </li> 
                    <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'assigncreate_check',
			         'checked' => true,
			         'id' => 'gcconnex-opt-in-swap-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:host' ),
	               ));
                    
                ?>
                    </li> 
                </ul>
            </li>
            
            <li class="clearfix">
                <?php echo elgg_echo('missions:deployment');?>
                
                <ul class="clearfix brdr-lft mrgn-lft-md list-unstyled">
                   <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'deploymentseek_check',
			         'checked' => true,
			         'id' => 'gcconnex-opt-in-swap-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:participants' ),
	               ));
                    
                ?>
                    </li> 
                    <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'deploymentcreate_check',
			         'checked' => true,
			         'id' => 'gcconnex-opt-in-swap-check',
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
			         'checked' => true,
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
			         'checked' => true,
			         'id' => 'gcconnex-opt-in-swap-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'missions:job_rotation' ),
	               ));
                    
                ?>
            </li>
            
            
        </ul>
    </div>

    <div class="col-sm-4">
        <h4 class="mrgn-tp-0"><?php echo elgg_echo('gcconnex_profile:opt:development'); ?></h4>
        <ul class="list-unstyled">
            
            
            <li class="clearfix">
                <?php echo elgg_echo('missions:mentoring');?>
                
                <ul class="clearfix brdr-lft mrgn-lft-md list-unstyled">
                <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'mentored_check',
			         'checked' => true,
			         'id' => 'gcconnex-opt-in-mentoring-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:mentored' ),
	               ));
                    
                ?>
            </li>
            
            <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
                        'name' => 'mentoring_check',
			         'checked' => true,
			         'id' => 'gcconnex-opt-in-mentored-check',
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
			         'checked' => true,
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
			         'checked' => true,
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
			         'checked' => true,
			         'id' => 'gcconnex-opt-in-shadowing-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:participants' ),
	               ));
                    
                ?>
                </li>
            
            <li class="clearfix pull-left mrgn-lft-md">
                <?php
                	echo elgg_view ( "input/checkbox", array (
			         'name' => 'skillcreator_check',
			         'checked' => true,
			         'id' => 'gcconnex-opt-in-shadowing-check',
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
			         'checked' => true,
			         'id' => 'gcconnex-opt-in-seekCoach-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'gcconnex_profile:opt:participants' ),
	               ));
                    
                ?>
                    </li>
                    <li class="clearfix pull-left mrgn-lft-md">
                        <?php
                	       echo elgg_view ( "input/checkbox", array (
			             'name' => 'coachcreate_check',
			         'checked' => true,
			         'id' => 'gcconnex-opt-in-becomeCoach-check',
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
			         'checked' => true,
			         'id' => 'gcconnex-opt-in-shadowing-check',
                        'class'=>'pull-left',
                        'label'=>elgg_echo ( 'missions:job_share' ),
	               ));
                    
                ?>
            </li>
            
        </ul>
    </div>
</div>
